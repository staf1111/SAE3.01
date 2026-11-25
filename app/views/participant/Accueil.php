<?php
/*
 * Vue : Accueil du participant
 *
 * Les données viennent de public/index.php (variables globales).
 * Cette vue est chargée dans une méthode du contrôleur, donc on les
 * déclare "global" pour pouvoir les utiliser ici.
 */
global $participant, $langue, $projets, $prochainsCreneaux, $historique;

// Adresses utilisées par les pop-up d'inscription
$urlAccueil  = BASE_URL . '/index.php?c=participant&a=accueil';
$urlCreneaux = BASE_URL . '/index.php?c=participant&a=creneaux';

/*
 * Inscription : le formulaire de la 1re pop-up envoie projet_id + creneau + consentement (POST)
 * vers cette même page. Si la demande est valide, on affiche la 2e pop-up ("Demande envoyée").
 * (Plus tard : le contrôleur enregistrera la demande en base avant d'afficher cette pop-up.)
 */
$inscriptionEnvoyee = false;
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['projet_id'], $_POST['creneau'], $_POST['consentement'])) {
    foreach ($projets as $p) {
        if ((int) $p['id'] !== (int) $_POST['projet_id']) {
            continue;
        }
        foreach ($p['creneaux'] ?? [] as $cr) {
            // le créneau doit exister pour ce projet et ne pas être complet
            if ((int) $cr['id'] === (int) $_POST['creneau'] && $cr['places'] > 0) {
                $inscriptionEnvoyee = true;
            }
        }
    }
}
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/css/participant/accueil.css">

<div class="page">

    <header class="page-header">
        <div>
            <h1>Accueil</h1>
            <p class="page-sous-titre">
                Participant · <?= htmlspecialchars($participant['prenom'] . ' ' . $participant['nom']) ?>
            </p>
        </div>

        <div class="langue">
            <button type="button" class="langue-connexion">
                <img src="<?= BASE_URL ?>/images/globe.png" alt="" class="icone">
                <?= htmlspecialchars($langue) ?>
                <img src="<?= BASE_URL ?>/images/fleche.png" alt="" class="icone-fleche">
            </button>

            <button type="button" class="night" aria-label="Mode sombre">
                <img src="<?= BASE_URL ?>/images/dark.png" alt="" class="icone-night">
            </button>
        </div>
    </header>

    <div class="accueil-layout">

        <section id="NewProjet">
            <div class="section-entete">
                <h2>Nouveau(x) projet(s) ouvert(s) pour vous</h2>

                <div class="filtres">
                    <button type="button" class="filtre actif">Toutes (<?= count($projets) ?>)</button>
                    <button type="button" class="filtre">&lt; 30 min</button>
                    <button type="button" class="filtre">Filtres</button>
                </div>
            </div>

            <div class="cartes">
                <?php foreach ($projets as $projet): ?>
                    <article class="carte-projet">
                        <div class="carte-entete">
                            <span class="carte-icone">
                                <img src="<?= BASE_URL ?>/images/fiole.png" alt="">
                            </span>
                            <h3><?= htmlspecialchars($projet['titre']) ?></h3>
                        </div>

                        <p class="carte-description"><?= htmlspecialchars($projet['description']) ?></p>

                        <p class="carte-duree"><?= (int) $projet['duree'] ?> min</p>

                        <p class="carte-creneau">
                            <img src="<?= BASE_URL ?>/images/horloge.png" alt="" class="icone-petite">
                            Prochain créneau : <strong><?= htmlspecialchars($projet['creneau']) ?></strong>
                        </p>

                        <?php $id = (int) $projet['id']; ?>
                        <button type="button" class="btn-primaire" popovertarget="inscription-<?= $id ?>">S'inscrire</button>

                        <!-- ===== POP-UP 1 : choix du créneau (s'ouvre avec le bouton, sans JavaScript) ===== -->
                        <div popover id="inscription-<?= $id ?>" class="modale">
                            <header class="modale-entete">
                                <div>
                                    <span class="modale-sur-titre">Expérimentation</span>
                                    <h2>S'inscrire</h2>
                                </div>
                                <button type="button" class="modale-fermer" popovertarget="inscription-<?= $id ?>" popovertargetaction="hide" aria-label="Fermer">
                                    <img src="<?= BASE_URL ?>/images/croix.png" alt="">
                                </button>
                            </header>

                            <form method="post" action="<?= htmlspecialchars($urlAccueil) ?>" class="modale-corps">
                                <input type="hidden" name="projet_id" value="<?= $id ?>">

                                <fieldset>
                                    <legend>Choisissez un créneau</legend>

                                    <!-- CHANGE : les créneaux viennent de $projet['creneaux'] (id, libelle, places) -->
                                    <?php $premierLibre = true; ?>
                                    <?php foreach ($projet['creneaux'] ?? [] as $cr): ?>
                                        <?php
                                        $complet = $cr['places'] <= 0;
                                        $pluriel = $cr['places'] > 1 ? 's' : '';
                                        $texte   = $complet ? 'complet' : $cr['places'] . ' place' . $pluriel . ' restante' . $pluriel;
                                        ?>
                                        <label class="option-creneau <?= $complet ? 'complet' : '' ?>">
                                            <input type="radio" name="creneau" value="<?= (int) $cr['id'] ?>"
                                                   <?= $complet ? 'disabled' : 'required' ?>
                                                   <?= (!$complet && $premierLibre) ? 'checked' : '' ?>>
                                            <span>
                                                <strong><?= htmlspecialchars($cr['libelle']) ?></strong>
                                                <small><?= htmlspecialchars($texte) ?></small>
                                            </span>
                                        </label>
                                        <?php if (!$complet) { $premierLibre = false; } ?>
                                    <?php endforeach; ?>

                                    <?php if (empty($projet['creneaux'])): ?>
                                        <p class="aucun-creneau">Aucun créneau disponible pour le moment.</p>
                                    <?php endif; ?>
                                </fieldset>

                                <label class="consentement">
                                    <input type="checkbox" name="consentement" required>
                                    J'ai lu et j'accepte la fiche de consentement
                                </label>

                                <button type="submit" class="btn-envoyer" <?= empty($projet['creneaux']) ? 'disabled' : '' ?>>
                                    Envoyer ma demande
                                    <img src="<?= BASE_URL ?>/images/avion.png" alt="" class="icone-avion">
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <aside id="ProchainsCreneaux">
            <h2>Mes prochains créneaux</h2>

            <ul class="liste-creneaux">
                <?php foreach ($prochainsCreneaux as $creneau): ?>
                    <li class="creneau">
                        <div class="creneau-date">
                            <span class="jour"><?= htmlspecialchars($creneau['jour']) ?></span>
                            <span class="mois"><?= htmlspecialchars($creneau['mois']) ?></span>
                        </div>
                        <div class="creneau-infos">
                            <strong><?= htmlspecialchars($creneau['titre']) ?></strong>
                            <span><?= htmlspecialchars($creneau['heure']) ?> salle <?= htmlspecialchars($creneau['salle']) ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

    </div>

    <section id="Historique">
        <h2>Historique récent</h2>

        <table>
            <thead>
                <tr>
                    <th>Expérimentations</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($historique as $ligne): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($ligne['titre']) ?></strong>
                            <small><?= htmlspecialchars($ligne['detail']) ?></small>
                        </td>
                        <td><span class="badge-date"><?= htmlspecialchars($ligne['date']) ?></span></td>
                        <td><span class="statut statut-valide"><?= htmlspecialchars($ligne['statut']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</div>

<?php if ($inscriptionEnvoyee): ?>
    <!-- ===== POP-UP 2 : "Demande envoyée" (affichée par PHP après l'envoi du formulaire) ===== -->
    <div class="modale-fond" role="dialog" aria-modal="true" aria-labelledby="titre-confirmation">
        <div class="modale">
            <header class="modale-entete">
                <div>
                    <span class="modale-sur-titre">Terminé</span>
                    <h2>S'inscrire</h2>
                </div>
                <!-- la croix recharge l'accueil : la pop-up disparaît -->
                <a class="modale-fermer" href="<?= htmlspecialchars($urlAccueil) ?>" aria-label="Fermer">
                    <img src="<?= BASE_URL ?>/images/croix.png" alt="">
                </a>
            </header>

            <div class="modale-corps modale-succes">
                <span class="succes-icone">
                    <img src="<?= BASE_URL ?>/images/coche.png" alt="">
                </span>
                <h3 id="titre-confirmation">Demande envoyée</h3>
                <p>Le responsable valide sous 48 h. Vous recevrez un e-mail de confirmation.</p>
                <a class="btn-envoyer btn-bleu" href="<?= htmlspecialchars($urlCreneaux) ?>">Voir mes créneaux</a>
            </div>
        </div>
    </div>
<?php endif; ?>

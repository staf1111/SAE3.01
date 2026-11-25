<?php
/*
 * Vue : Accueil du participant
 *
 * Les données sont préparées par ParticipantController::accueil() :
 * $participant, $langue, $projets, $prochainsCreneaux et $inscriptionEnvoyee
 * et pour les filtres : $nbProjets, $filtreActif, $durees, $dureeMax et $seulementDispo
 */

$urlAccueil = BASE_URL . '/index.php?page=accueil-participant';
$urlCreneaux = BASE_URL . '/index.php?page=creneaux-participant';
?>

<div class="page page-accueil">

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

                <!-- la classe "actif" colore le filtre choisi ($filtreActif vient du contrôleur) -->
                <div class="filtres">
                    <a class="filtre <?= $filtreActif == 'toutes' ? 'actif' : '' ?>" href="<?= $urlAccueil ?>">Toutes (<?= $nbProjets ?>)</a>
                    <a class="filtre <?= $filtreActif == '30min' ? 'actif' : '' ?>" href="<?= $urlAccueil ?>&amp;duree=30">≤ 30 min</a>
                    <button type="button" class="filtre <?= $filtreActif == 'filtres' ? 'actif' : '' ?>" popovertarget="panneau-filtres">Filtres</button>
                </div>
            </div>

            <?php if ($nbProjets == 0): ?>
                <p>Aucune nouvelle expérimentation pour le moment.</p>
            <?php elseif (count($projets) == 0): ?>
                <p>Aucune expérimentation ne correspond à ces filtres.</p>
            <?php endif; ?>

            <!-- ===== POP-UP DES FILTRES (formulaire en GET : les filtres vont dans l'adresse) ===== -->
            <div popover id="panneau-filtres" class="modale">
                <header class="modale-entete">
                    <div>
                        <span class="modale-sur-titre">Accueil</span>
                        <h2>Filtres</h2>
                    </div>
                    <button type="button" class="modale-fermer" popovertarget="panneau-filtres" popovertargetaction="hide" aria-label="Fermer">
                        <img src="<?= BASE_URL ?>/images/croix.png" alt="">
                    </button>
                </header>

                <form method="get" action="<?= BASE_URL ?>/index.php" class="modale-corps">
                    <!-- en GET, l'adresse de action est remplacée : il faut renvoyer le nom de la page -->
                    <input type="hidden" name="page" value="accueil-participant">

                    <label for="duree" class="label-filtre">Durée maximale</label>
                    <select id="duree" name="duree" class="select-filtre">
                        <option value="">Peu importe</option>
                        <?php foreach ($durees as $d): ?>
                            <option value="<?= $d ?>" <?= $d == $dureeMax ? 'selected' : '' ?>><?= $d ?> min</option>
                        <?php endforeach; ?>
                    </select>

                    <label class="consentement">
                        <input type="checkbox" name="dispo" value="1" <?= $seulementDispo ? 'checked' : '' ?>>
                        Seulement avec un créneau disponible
                    </label>

                    <button type="submit" class="btn-envoyer btn-bleu">Appliquer</button>
                    <a class="lien-reinitialiser" href="<?= $urlAccueil ?>">Réinitialiser les filtres</a>
                </form>
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

                                <p class="modale-info">
                                    Votre demande sera envoyée au responsable de l'expérimentation.
                                    Une fois acceptée, vous recevrez une notification et pourrez choisir
                                    votre créneau dans la page Créneaux.
                                </p>

                                <label class="consentement">
                                    <input type="checkbox" name="consentement" required>
                                    J'ai lu et j'accepte la fiche de consentement
                                </label>

                                <button type="submit" class="btn-envoyer">
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

            <?php if (count($prochainsCreneaux) == 0): ?>
                <p>Aucun créneau à venir.</p>
            <?php endif; ?>

            <ul class="liste-creneaux">
                <?php foreach ($prochainsCreneaux as $creneau): ?>
                    <li class="creneau">
                        <div class="creneau-date">
                            <span class="jour"><?= htmlspecialchars($creneau['jour']) ?></span>
                            <span class="mois"><?= htmlspecialchars($creneau['mois']) ?></span>
                        </div>
                        <div class="creneau-infos">
                            <strong><?= htmlspecialchars($creneau['titre']) ?></strong>
                            <span><?= htmlspecialchars($creneau['heure']) ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

    </div>

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
                <p>Le responsable doit maintenant valider votre demande. Vous serez prévenu dans votre messagerie, puis vous pourrez choisir votre créneau.</p>
                <a class="btn-envoyer btn-bleu" href="<?= htmlspecialchars($urlCreneaux) ?>">Voir mes créneaux</a>
            </div>
        </div>
    </div>
<?php endif; ?>
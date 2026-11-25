<?php
/*
 * Vue : Mes créneaux
 *
 * Les données viennent de public/index.php (variables globales).
 * Cette vue est chargée dans une méthode du contrôleur, donc on les
 * déclare "global" pour pouvoir les utiliser ici.
 */
global $creneauxAVenir, $creneauxParExperience, $langue;

/*
 * Bouton "Changer" : il recharge la page avec ?changer=<id du rendez-vous>.
 * Le panneau du bas n'apparaît que dans ce cas, avec les créneaux de l'expérimentation concernée.
 */
$rdvChoisi = null;
if (isset($_GET['changer'])) {
    foreach ($creneauxAVenir as $r) {
        if ((int) $r['id'] === (int) $_GET['changer']) {
            $rdvChoisi = $r;
        }
    }
}

// créneaux proposés pour l'expérimentation de ce rendez-vous (vide si aucun)
$creneauxDisponibles = $rdvChoisi ? ($creneauxParExperience[$rdvChoisi['experience_id']] ?? []) : [];
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/css/participant/creneaux.css">

<div class="page">

    <header class="page-header">
        <div>
            <h1>Mes créneaux</h1>
            <p class="page-sous-titre">Vos rendez-vous pour les expérimentations auxquelles vous êtes inscrit.</p>
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

    <!-- ========== À VENIR ========== -->
    <section class="panneau" id="AVenir">
        <h2>À venir</h2>

        <ul class="liste-rdv">
            <?php foreach ($creneauxAVenir as $rdv): ?>
                <li class="rdv">
                    <div class="rdv-date">
                        <span class="jour"><?= htmlspecialchars($rdv['jour']) ?></span>
                        <span class="mois"><?= htmlspecialchars($rdv['mois']) ?></span>
                    </div>

                    <div class="rdv-infos">
                        <strong><?= htmlspecialchars($rdv['titre']) ?></strong>
                        <p>
                            <img src="<?= BASE_URL ?>/images/horloge.png" alt="" class="icone-petite">
                            <?= htmlspecialchars($rdv['debut']) ?> – <?= htmlspecialchars($rdv['fin']) ?>
                            <img src="<?= BASE_URL ?>/images/lieu.png" alt="" class="ico">
                            Salle <?= htmlspecialchars($rdv['salle']) ?>
                        </p>
                    </div>

                    <!-- statut_classe : statut-attente ou statut-confirme -->
                    <span class="statut <?= htmlspecialchars($rdv['statut_classe']) ?>">
                        <?= htmlspecialchars($rdv['statut']) ?>
                    </span>

                    <div class="rdv-actions">
                        <!-- "Changer" : affiche le panneau du bas pour CE rendez-vous (ouvre ?changer=<id>) -->
                        <form method="get" action="<?= BASE_URL ?>/index.php#ChoisirCreneau">
                            <input type="hidden" name="c" value="participant">
                            <input type="hidden" name="a" value="creneaux">
                            <input type="hidden" name="changer" value="<?= (int) $rdv['id'] ?>">
                            <button type="submit" class="btn-contour">
                                <img src="<?= BASE_URL ?>/images/crayon.png" alt="" class="icone-bouton">
                                Changer
                            </button>
                        </form>
                        <button type="button" class="btn-contour btn-annuler">
                            <img src="<?= BASE_URL ?>/images/croix.png" alt="" class="icone-bouton">
                            Annuler
                        </button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <!-- ========== CHOISIR UN CRÉNEAU ==========
         Affiché seulement après un clic sur "Changer", pour l'expérimentation de ce rendez-vous. -->
    <?php if ($rdvChoisi): ?>
        <section class="panneau" id="ChoisirCreneau">
            <h2>Choisir un créneau — <?= htmlspecialchars($rdvChoisi['titre']) ?></h2>
            <p class="aide">Sélectionnez un ou plusieurs créneaux, puis validez. Le responsable confirmera votre inscription.</p>

            <?php if (empty($creneauxDisponibles)): ?>
                <p class="aide">Aucun créneau disponible pour cette expérimentation.</p>
            <?php endif; ?>

            <form method="post" action="" class="formulaire-creneaux">
                <input type="hidden" name="rdv_id" value="<?= (int) $rdvChoisi['id'] ?>">

                <div class="choix-liste">
                    <?php foreach ($creneauxDisponibles as $c): ?>
                        <!-- etat : libre / selectionne / reserve / complet -->
                        <label class="choix choix-<?= htmlspecialchars($c['etat']) ?>">
                            <input type="checkbox" name="creneaux[]"
                                   value="<?= htmlspecialchars($c['libelle']) ?>"
                                   <?= $c['etat'] === 'selectionne' ? 'checked' : '' ?>
                                   <?= in_array($c['etat'], ['reserve', 'complet']) ? 'disabled' : '' ?>>
                            <span>
                                <?= $c['etat'] === 'reserve' ? '✓ ' : '' ?><?= htmlspecialchars($c['libelle']) ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="reservation">
                    <!-- Les nombres entre parenthèses sont comptés par le CSS (voir creneaux.css) -->
                    <button type="submit" class="btn-reserver" <?= empty($creneauxDisponibles) ? 'disabled' : '' ?>>✓ Réserver <span class="nb"></span></button>

                    <!-- "Fermer" fait partie du petit formulaire ci-dessous (attribut form=) : il recharge la page sans ?changer -->
                    <button type="submit" form="fermer-changement" class="btn-contour">Fermer</button>
                </div>
            </form>

            <form id="fermer-changement" method="get" action="<?= BASE_URL ?>/index.php#AVenir">
                <input type="hidden" name="c" value="participant">
                <input type="hidden" name="a" value="creneaux">
            </form>
        </section>
    <?php endif; ?>

</div>

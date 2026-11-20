<?php
/*
 * Vue : Mes créneaux
 *
 * Les données viennent de public/index.php (variables globales).
 * Cette vue est chargée dans une méthode du contrôleur, donc on les
 * déclare "global" pour pouvoir les utiliser ici.
 */
global $creneauxAVenir, $experienceChoisie, $creneauxDisponibles;
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/css/participant/creneaux.css">

<div class="page">

    <header class="page-header">
        <h1>Mes créneaux</h1>
        <p class="page-sous-titre">Vos rendez-vous pour les expérimentations auxquelles vous êtes inscrit.</p>
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
                        <button type="button" class="btn-contour">
                            <img src="<?= BASE_URL ?>/images/crayon.png" alt="" class="icone-bouton">
                            Changer
                        </button>
                        <button type="button" class="btn-contour btn-annuler">
                            <img src="<?= BASE_URL ?>/images/croix.png" alt="" class="icone-bouton">
                            Annuler
                        </button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <!-- ========== CHOISIR UN CRÉNEAU ========== -->
    <section class="panneau" id="ChoisirCreneau">
        <h2>Choisir un créneau — <?= htmlspecialchars($experienceChoisie) ?></h2>
        <p class="aide">Sélectionnez un ou plusieurs créneaux, puis validez. Le responsable confirmera votre inscription.</p>

        <form method="post" action="" class="formulaire-creneaux">
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
                <button type="submit" class="btn-reserver">✓ Réserver <span class="nb"></span></button>            </div>
        </form>
    </section>

</div>

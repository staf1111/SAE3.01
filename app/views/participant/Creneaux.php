<?php
/*
 * Vue : Mes créneaux
 *
 * Les données sont préparées par ParticipantController::creneaux() :
 * $creneauxAVenir (rendez-vous), $aChoisir (inscriptions validées avec des séances à réserver),
 * $panneau (créneaux proposés, null si le panneau est fermé) et $langue
 */

$urlPage = BASE_URL . '/index.php?page=creneaux-participant';
?>

<div class="page page-creneaux">

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

    <!-- ========== CRÉNEAUX À RÉSERVER ========== -->
    <?php if (count($aChoisir) > 0): ?>
        <section class="panneau" id="AChoisir">
            <h2>Créneaux à réserver</h2>
            <p class="aide">Votre inscription a été acceptée : choisissez vos créneaux.</p>

            <ul class="liste-rdv">
                <?php foreach ($aChoisir as $inscription): ?>
                    <li class="rdv">
                        <div class="rdv-infos">
                            <strong><?= htmlspecialchars($inscription['titre']) ?></strong>
                            <p><?= $inscription['restantes'] ?> séance(s) à réserver sur <?= $inscription['nombre_sessions'] ?></p>
                        </div>

                        <div class="rdv-actions">
                            <a class="btn-contour" href="<?= $urlPage ?>&inscription=<?= $inscription['id_inscription'] ?>#ChoisirCreneau">
                                Choisir un créneau
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <!-- ========== À VENIR ========== -->
    <section class="panneau" id="AVenir">
        <h2>À venir</h2>

        <?php if (count($creneauxAVenir) == 0): ?>
            <p class="aide">Aucun rendez-vous à venir.</p>
        <?php endif; ?>

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
                        </p>
                    </div>

                    <!-- statut_classe : statut-attente ou statut-confirme -->
                    <span class="statut <?= htmlspecialchars($rdv['statut_classe']) ?>">
                        <?= htmlspecialchars($rdv['statut']) ?>
                    </span>

                    <div class="rdv-actions">
                        <!-- "Changer" : affiche le panneau du bas pour CE rendez-vous -->
                        <a class="btn-contour" href="<?= $urlPage ?>&changer=<?= (int) $rdv['id'] ?>#ChoisirCreneau">
                            <img src="<?= BASE_URL ?>/images/crayon.png" alt="" class="icone-bouton">
                            Changer
                        </a>

                        <form method="post" action="<?= $urlPage ?>">
                            <input type="hidden" name="action" value="annuler">
                            <input type="hidden" name="id_inscription" value="<?= (int) $rdv['id_inscription'] ?>">
                            <input type="hidden" name="id_creneau" value="<?= (int) $rdv['id_creneau'] ?>">
                            <button type="submit" class="btn-contour btn-annuler" onclick="return confirm('Annuler ce créneau ?')">
                                <img src="<?= BASE_URL ?>/images/croix.png" alt="" class="icone-bouton">
                                Annuler
                            </button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <!-- ========== CHOISIR UN CRÉNEAU ==========
         Affiché seulement après un clic sur "Choisir un créneau" ou "Changer" -->
    <?php if ($panneau != null): ?>
        <section class="panneau" id="ChoisirCreneau">
            <h2>Choisir un créneau — <?= htmlspecialchars($panneau['titre']) ?></h2>

            <?php if ($panneau['mode'] == 'changer'): ?>
                <p class="aide">Sélectionnez le nouveau créneau. L'ancien sera annulé et le responsable devra valider le nouveau.</p>
            <?php else: ?>
                <p class="aide">Sélectionnez jusqu'à <?= $panneau['max'] ?> créneau(x), puis validez. Le responsable confirmera vos créneaux.</p>
            <?php endif; ?>

            <?php if (count($panneau['creneaux']) == 0): ?>
                <p class="aide">Aucun créneau disponible pour cette expérimentation.</p>
            <?php endif; ?>

            <form method="post" action="<?= $urlPage ?>" class="formulaire-creneaux">
                <input type="hidden" name="action" value="reserver">
                <input type="hidden" name="id_inscription" value="<?= (int) $panneau['id_inscription'] ?>">
                <input type="hidden" name="id_creneau_actuel" value="<?= (int) $panneau['id_creneau_actuel'] ?>">

                <div class="choix-liste">
                    <?php foreach ($panneau['creneaux'] as $c): ?>
                        <!-- etat : libre / reserve / complet -->
                        <label class="choix choix-<?= htmlspecialchars($c['etat']) ?>">
                            <input type="checkbox" name="creneaux[]" value="<?= (int) $c['id'] ?>"
                                   <?= $c['etat'] != 'libre' ? 'disabled' : '' ?>>
                            <span>
                                <?= $c['etat'] == 'reserve' ? '✓ ' : '' ?><?= htmlspecialchars($c['libelle']) ?>
                                <?= $c['etat'] == 'complet' ? '(complet)' : '' ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="reservation">
                    <!-- Les nombres entre parenthèses sont comptés par le CSS (voir participant.css) -->
                    <button type="submit" class="btn-reserver" <?= count($panneau['creneaux']) == 0 ? 'disabled' : '' ?>>✓ Réserver <span class="nb"></span></button>
                    <a class="btn-contour" href="<?= $urlPage ?>#AVenir">Fermer</a>
                </div>
            </form>
        </section>
    <?php endif; ?>

</div>

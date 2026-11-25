<?php
/*
 * Vue : Historique de mes participations
 *
 * Les données sont préparées par ParticipantController::historique() :
 * $statsHistorique (nb_participations, temps_total), $participations et $langue
 */
?>

<div class="page page-historique">

    <header class="page-header">
        <div>
            <h1>Historique de mes participations</h1>
            <p class="page-sous-titre">Toutes les expérimentations auxquelles vous avez participé.</p>
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

    <!-- ========== STATISTIQUES ========== -->
    <div class="stats">
        <div class="stat">
            <span class="stat-icone">
                <img src="<?= BASE_URL ?>/images/fiole.png" alt="">
            </span>
            <div>
                <strong><?= (int) $statsHistorique['nb_participations'] ?></strong>
                <span>Participations</span>
            </div>
        </div>

        <div class="stat">
            <span class="stat-icone">
                <img src="<?= BASE_URL ?>/images/horloge.png" alt="" class="icone-blanche">
            </span>
            <div>
                <strong><?= htmlspecialchars($statsHistorique['temps_total']) ?></strong>
                <span>Temps total</span>
            </div>
        </div>
    </div>

    <!-- ========== TABLEAU DES PARTICIPATIONS ========== -->
    <section class="panneau">
        <h2>Mes participations</h2>

        <?php if (count($participations) == 0): ?>
            <p>Aucune participation pour le moment.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Expérimentation</th>
                        <th>Date</th>
                        <th>Participation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participations as $p): ?>
                        <tr>
                            <td class="exp"><?= htmlspecialchars($p['titre']) ?></td>
                            <td><?= htmlspecialchars($p['date']) ?></td>
                            <!-- statut_classe : statut-valide / statut-absent / statut-annule -->
                            <td>
                                <span class="statut <?= htmlspecialchars($p['statut_classe']) ?>">
                                    <?= htmlspecialchars($p['statut']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

</div>

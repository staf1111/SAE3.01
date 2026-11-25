<?php
/*
 * Vue : Historique de mes participations
 *
 * Les données viennent de public/index.php (variables globales).
 * Cette vue est chargée dans une méthode du contrôleur, donc on les
 * déclare "global" pour pouvoir les utiliser ici.
 */
global $statsHistorique, $participations, $langue;
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/css/participant/historique.css">

<div class="page">

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
    </section>

</div>

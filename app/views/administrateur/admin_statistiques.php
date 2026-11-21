<?php
$stats             = $stats ?? [];
$connexionsParJour = $connexionsParJour ?? []; // valeurs par défaut provisoires pour éviter les erreurs de VS Code
$comptesParRole    = $comptesParRole ?? [];
$compte_connexion_echoue = $compte_connexion_echoue ?? [];
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/administrateur_css/statistiques.css">

<div class="entete-stats">
    <div class="titre-bloc">
        <h1 class="titre-stats">Statistiques de l'application</h1>
        <p class="sous-titre-stats">Administrateur</p>
    </div>

    <div class="duree">
        <span class="derniers-jours">
            14 derniers jours
            <img src="<?= BASE_URL ?>/images/fleche.png" alt="" class="icone-fleche">
        </span>

        <span class="exporter">
            <img src="<?= BASE_URL ?>/images/export.png" alt="" class="icone-export">
            Exporter
        </span>
    </div>
</div>

<div class="cartes-stats">
    <div class="carte-stat">
        <span class="carte-label">Comptes actifs</span>
        <span class="carte-valeur"><?= number_format($stats['comptes_actifs'], 0, ',', ' ') ?></span>
        <span class="carte-info vert"> <?= $stats['nouveaux_mois'] ?> ce mois</span>
    </div>

    <div class="carte-stat">
        <span class="carte-label">Connexions aujourd'hui</span>
        <span class="carte-valeur"><?= $stats['connexions_jour'] ?></span>
        <span class="carte-info">moyenne : <?= $stats['moyenne_jour'] ?> / jour</span>
    </div>

    <div class="carte-stat">
        <span class="carte-label">Échecs de connexion (24 h)</span>
        <span class="carte-valeur"><?= $stats['echecs_24h'] ?></span>
        <span class="carte-info rouge"><?= $stats['comptes_bloques'] ?> comptes bloqués</span>
    </div>

    <div class="carte-stat">
        <span class="carte-label">Données à anonymiser (RGPD)</span>
        <span class="carte-valeur"><?= $stats['a_anonymiser'] ?></span>
        <span class="carte-info orange">à traiter</span>
    </div>
</div>


<?php
$maxJour  = max($connexionsParJour);
$maxRole  = max($comptesParRole);
?>
<div class="graphiques">

    <!-- Connexions par jour -->
    <div class="panneau">
        <h2 class="panneau-titre">Connexions par jour</h2>
        <div class="diagramme">
            <?php foreach ($connexionsParJour as $jour => $nombre): ?>
                <div class="colonne">
                    <span class="colonne-valeur"><?= $nombre ?></span>
                    <div class="barre" style="height: <?= round($nombre / $maxJour * 100) ?>%;"></div>
                    <span class="colonne-jour"><?= $jour ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <div class="panneau">
        <h2 class="panneau-titre">Comptes par rôle</h2>
        <?php foreach ($comptesParRole as $role => $nombre): ?>
            <div class="ligne-role">
                <span class="role-nom"><?= htmlspecialchars($role) ?></span>
                <div class="jauge">
                    <div class="jauge-remplie" style="width: <?= round($nombre / $maxRole * 100) ?>%;"></div>
                </div>
                <span class="role-nombre"><?= number_format($nombre, 0, ',', ' ') ?></span>
            </div>
        <?php endforeach; ?>
    </div>




</div>

<div class="panneau panneau-echecs">
    <h2 class="panneau-titre">Échecs de connexion récents</h2>

    <table class="tableau-echecs">
        <thead>
            <tr>
                <th>Compte</th>
                <th>Adresse IP</th>
                <th>Tentatives</th>
                <th>Dernière tentative</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($compte_connexion_echoue as $email => $info): ?>
                <tr>
                    <td class="compte"><?= htmlspecialchars($email) ?></td>
                    <td><?= htmlspecialchars($info['ip']) ?></td>
                    <td><?= $info['tentatives'] ?></td>
                    <td><?= htmlspecialchars($info['derniere_tentative']) ?></td>
                    <td>
                        <span class="badge-etat <?= $info['etat'] === 'OK' ? 'ok' : 'alerte' ?>">
                            <?= htmlspecialchars($info['etat']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
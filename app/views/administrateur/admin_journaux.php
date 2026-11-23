<?php
$filtres     = $filtres ?? [];
$filtreActif = $filtreActif ?? 'tout';
$journaux    = $journaux ?? [];
$journauxPage = $journauxPage ?? [];
$page = $page ?? 1;
$nbPages = $nbPages ?? 1;
$total = $total ?? 0;
$debut = $debut ?? 0;
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/administrateur_css/journaux.css">

<div class="entete-journaux">
    <div class="titre-bloc">
        <h1 class="titre-journaux">Journaux d'activités</h1>
    </div>


    <div class="exporter">
        <span class="exporter-csv">
            <img src="<?= BASE_URL ?>/images/export.png" alt="" class="icone-export">
            Exporter(CSV)
        </span>
    </div>
</div>

<form method="get" action="index.php" class="barre-filtres">
    <input type="hidden" name="c" value="administrateur">
    <input type="hidden" name="a" value="journaux">

    <div class="recherche">
        <img src="<?= BASE_URL ?>/images/chercher.png" alt="" class="icone-recherche">
        <input type="text" name="q" placeholder="Rechercher un utilisateur, une IP…">
    </div>

    <input type="date" name="date" value="2026-09-30" class="filtre-date">

    <select name="role" class="filtre-role">
        <option value="">Tous les rôles</option>
        <option value="participant">Participant</option>
        <option value="enseignant">Enseignant-chercheur</option>
        <option value="admin">Administrateur</option>
    </select>
</form>

<div class="filtres">
    <?php foreach ($filtres as $cle => $filtre): ?>
        <a href="index.php?c=administrateur&a=journaux&filtre=<?= $cle ?>"
            class="filtre <?= $cle === $filtreActif ? 'actif' : '' ?>">
            <?= $filtre['label'] ?> (<?= number_format($filtre['nombre'], 0, ',', ' ') ?>)
        </a>
    <?php endforeach; ?>
</div>

<div class="panneau-journaux">
    <h2 class="titre-tableau">Aujourd'hui — 30 sept. 2026</h2>

    <table class="tableau-journaux">
        <thead>
            <tr>
                <th>Heure</th>
                <th>Utilisateur</th>
                <th>Action</th>
                <th>Adresse IP</th>
                <th>Session</th>
                <th>Résultat</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($journauxPage as $ligne): ?>
                <tr>
                    <td class="heure"><?= htmlspecialchars($ligne['heure']) ?></td>
                    <td>
                        <span class="utilisateur"><?= htmlspecialchars($ligne['nom']) ?></span>
                        <span class="role"><?= htmlspecialchars($ligne['role']) ?></span>
                    </td>
                    <td><?= htmlspecialchars($ligne['action']) ?></td>
                    <td><?= htmlspecialchars($ligne['ip']) ?></td>
                    <td><?= htmlspecialchars($ligne['session']) ?></td>
                    <td>
                        <span class="badge-resultat <?= $ligne['type'] ?>">
                            <?= htmlspecialchars($ligne['resultat']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pied-tableau">
        <span class="compteur">
            <?= $debut + 1 ?>–<?= $debut + count($journauxPage) ?> sur <?= $total ?> aujourd'hui
        </span>

        <?php $lien = "index.php?c=administrateur&a=journaux&filtre=$filtreActif&page="; ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="<?= $lien . ($page - 1) ?>" class="page-btn">Précédent</a>
            <?php else: ?>
                <span class="page-btn desactive">Précédent</span>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $nbPages; $i++): ?>
                <a href="<?= $lien . $i ?>" class="page-btn <?= $i === $page ? 'actif' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($page < $nbPages): ?>
                <a href="<?= $lien . ($page + 1) ?>" class="page-btn">Suivant</a>
            <?php else: ?>
                <span class="page-btn desactive">Suivant</span>
            <?php endif; ?>
        </div>
    </div>
</div>
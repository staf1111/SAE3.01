<?php $filtres          = $filtres ?? [];
$filtreActif      = $filtreActif ?? 'tout';
$utilisateursPage = $utilisateursPage ?? [];
$total            = $total ?? 0;
$debut            = $debut ?? 0;
$page             = $page ?? 1;
$nbPages          = $nbPages ?? 1;
$roles            = $roles ?? [];
$permissions      = $permissions ?? [];
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/css/administrateur_css/utilisateurs.css">
<?php $classesRoles = [
    'Participant'          => 'role-participant',
    'Enseignant-chercheur' => 'role-enseignant',
    'Administrateur'       => 'role-admin',
];
?>
<div class="entete-users">
    <div class="titre-bloc">
        <h1 class="titre-users">Utilisateurs</h1>
    </div>

    <div class="exporter">
        <span class="exporter-csv">
            <img src="<?= BASE_URL ?>/images/export.png" alt="" class="icone-export">
            Exporter(CSV)
        </span>

        <span class="new-users">
            <img src="<?= BASE_URL ?>/images/plus.png" alt="" class="icone-plus">
            Crée un utilisateur
        </span>
    </div>


</div>
<div class="filtres">
    <?php foreach ($filtres as $cle => $filtre): ?>
        <a href="index.php?c=administrateur&a=utilisateurs&filtre=<?= $cle ?>"
            class="filtre <?= $cle === $filtreActif ? 'actif' : '' ?>">
            <?= $filtre['label'] ?> (<?= number_format($filtre['nombre'], 0, ',', ' ') ?>)
        </a>
    <?php endforeach; ?>
</div>

<div class="panneau-users">
    <table class="tableau-utilisateurs">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Rôle</th>
                <th>Laboratoire</th>
                <th>Dernière connexion</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateursPage as $u): ?>
                <tr>
                    <!-- Utilisateur -->
                    <td>
                        <span class="nom-utilisateur"><?= htmlspecialchars($u['prenom'] . ' ' . $u['nom']) ?></span>
                        <span class="email-utilisateur"><?= htmlspecialchars($u['email']) ?></span>
                    </td>

                    <!-- Rôle -->
                    <td>
                        <span class="pastille <?= $classesRoles[$u['role']] ?? '' ?>">
                            <?= htmlspecialchars($u['role']) ?>
                        </span>
                    </td>

                    <!-- Laboratoire -->
                    <td><?= htmlspecialchars($u['equipe']) ?></td>

                    <!-- Dernière connexion -->
                    <td><?= htmlspecialchars($u['derniere_connexion']) ?></td>

                    <!-- Statut -->
                    <td>
                        <?php if ($u['statut'] === 'actif'): ?>
                            <span class="statut actif">Actif</span>
                        <?php else: ?>
                            <span class="statut bloque">Bloqué</span>
                        <?php endif; ?>
                    </td>

                    <!-- Actions -->
                    <td>
                        <div class="actions-ligne">
                            <a href="#" class="bouton-icone">
                                <img src="<?= BASE_URL ?>/images/modifier.png" alt="Modifier">
                            </a>
                            <a href="#" class="bouton-icone supprimer">
                                <img src="<?= BASE_URL ?>/images/supprimer.png" alt="Supprimer">
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<div class="pied-tableau">
    <span class="compteur">
        <?= $total > 0 ? $debut + 1 : 0 ?>–<?= $debut + count($utilisateursPage) ?> sur <?= $total ?>
    </span>

    <?php $lien = "index.php?c=administrateur&a=utilisateurs&filtre=$filtreActif&page="; ?>
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
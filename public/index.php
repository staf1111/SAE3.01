<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Fausses données (seront fournies par AdministrateurController plus tard)
$stats = [
    'comptes_actifs'  => 1284,
    'connexions_jour' => 212,
    'echecs_24h'      => 17,
    'a_anonymiser'    => 12,
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <?php require __DIR__ . '/../app/views/administrateur/admin_statistiques.php'; ?>
</body>
</html>
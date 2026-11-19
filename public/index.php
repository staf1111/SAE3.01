<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

$erreur = null;

$participant = [
    'prenom' => 'Léa',
    'nom'    => 'Bernard',
];

$langue = 'Français';

$projets = [
    [
        'id'          => 1,
        'titre'       => 'Perception des couleurs en réalité virtuelle',
        'description' => "Évaluation de couleurs à l'aide d'un casque",
        'duree'       => 45,
        'creneau'     => 'Auj. 14:00 · Salle B-104',
    ],
    [
        'id'          => 2,
        'titre'       => 'Mémoire de travail et bilinguisme',
        'description' => 'Tâches de mémorisation sur ordinateur',
        'duree'       => 30,
        'creneau'     => 'Mer. 10:00 · Salle A-012',
    ],
];

$prochainsCreneaux = [
    ['jour' => '30', 'mois' => 'SEPT', 'titre' => 'Perception VR', 'heure' => '10.00h', 'salle' => 'B'],
    ['jour' => '30', 'mois' => 'SEPT', 'titre' => 'Perception VR', 'heure' => '10.00h', 'salle' => 'B'],
];

$historique = [
    [
        'titre'  => 'Perceptions des couleurs',
        'detail' => '4 séances de 45 min prochainement',
        'date'   => '12 sept',
        'statut' => 'Participation validée',
    ],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <?php require __DIR__ . '/../app/views/participant/Accueil.php'; ?>
</body>
</html>

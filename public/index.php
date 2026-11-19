<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

define('BASE_URL', '/SAE3.01/public');

// TEST : simule un utilisateur connecté
$_SESSION['role'] = 'admin';   // essaie aussi 'enseignant' et 'participant'

// Fausses données pour la page
$stats = [
    'comptes_actifs'   => 1284,
    'nouveaux_mois'    => 57,
    'connexions_jour'  => 212,
    'moyenne_jour'     => 185,
    'echecs_24h'       => 17,
    'comptes_bloques'  => 2,
    'a_anonymiser'     => 12,
];

$connexionsParJour = [
    17 => 160,
    18 => 172,
    19 => 60,
    20 => 48,
    21 => 190,
    22 => 205,
    23 => 198,
    24 => 188,
    25 => 176,
    26 => 55,
    27 => 41,
    28 => 214,
    29 => 221,
    30 => 212,
];

$comptesParRole = [
    'Participants'           => 1104,
    'Enseignants-chercheurs' => 118,
    'Administrateurs'        => 4,
];

$currentPage = 'statistiques';   // onglet surligné
$contentView = __DIR__ . '/../app/views/administrateur/admin_statistiques.php';

require __DIR__ . '/../app/views/layout.php';

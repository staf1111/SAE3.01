<?php
session_start();

define('BASE_URL', '/SAE3.01/public'); // XAMPP

// TEST uniquement : simule un utilisateur connecté (participant, enseignant ou admin).
$_SESSION['role'] = 'enseignant';

require_once __DIR__ . '/../app/controllers/EnseignantController.php';

$routes = [
    'dashboard'        => 'dashboard',
    'experimentations' => 'mesExperimentations',
    'creneaux'         => 'mesCreneaux',
    'statistiques'     => 'statistiques',
];

$page   = $_GET['page'] ?? 'dashboard';
$method = $routes[$page] ?? null;

if ($method === null) {
    http_response_code(404);
    exit('Page introuvable');
}

(new EnseignantController())->$method();
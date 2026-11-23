<?php
session_start();

// adresse du dossier public dans XAMPP (http://localhost/SAE3.01/public)
define('BASE_URL', '/SAE3.01/public');

// provisoire, en attendant la page de connexion
$_SESSION['role'] = 'enseignant';
$_SESSION['id_utilisateur'] = 3;

require_once __DIR__ . '/../app/controllers/EnseignantController.php';

// nom de la page dans l'URL => méthode du contrôleur à appeler
$routes = [
    'dashboard' => 'dashboard',
    'experimentations' => 'mesExperimentations',
    'experimentation' => 'gererExperimentation',
    'changer-statut' => 'changerStatut',
    'creneaux' => 'mesCreneaux',
    'statistiques' => 'statistiques',
];

// sans ?page= dans l'URL, on affiche le tableau de bord
$page = $_GET['page'] ?? 'dashboard';

if (!isset($routes[$page])) {
    http_response_code(404);
    exit('Page introuvable');
}

$controleur = new EnseignantController();
$methode = $routes[$page];
$controleur->$methode();
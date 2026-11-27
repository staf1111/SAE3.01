<?php
session_start();

// adresse du dossier public dans XAMPP (http://localhost/SAE3.01/public)
define('BASE_URL', '/SAE3.01/public');

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/EnseignantController.php';
require_once __DIR__ . '/../app/controllers/ParticipantController.php';
require_once __DIR__ . '/../app/controllers/AdministrateurController.php';

// nom de la page dans l'URL => [contrôleur, méthode, rôle obligatoire]
// rôle null = page accessible sans être connecté
$routes = [
    'connexion' => ['AuthController', 'connexion', null],
    'deconnexion' => ['AuthController', 'deconnexion', null],

    'dashboard' => ['EnseignantController', 'dashboard', 'enseignant'],
    'experimentations' => ['EnseignantController', 'mesExperimentations', 'enseignant'],
    'experimentation' => ['EnseignantController', 'gererExperimentation', 'enseignant'],
    'changer-statut' => ['EnseignantController', 'changerStatut', 'enseignant'],
    'creneaux' => ['EnseignantController', 'mesCreneaux', 'enseignant'],
    'statistiques' => ['EnseignantController', 'statistiques', 'enseignant'],

    'accueil-participant' => ['ParticipantController', 'accueil', 'participant'],
    'experimentations-participant' => ['ParticipantController', 'experimentation', 'participant'],
    'creneaux-participant' => ['ParticipantController', 'creneaux', 'participant'],
    'historique-participant' => ['ParticipantController', 'historique', 'participant'],
    'profil-participant' => ['ParticipantController', 'profil', 'participant'],

    'admin-statistiques' => ['AdministrateurController', 'statistiques', 'admin'],
    'admin-utilisateurs' => ['AdministrateurController', 'utilisateurs', 'admin'],
    'admin-parametres' => ['AdministrateurController', 'parametres', 'admin'],
    'admin-journaux' => ['AdministrateurController', 'journaux', 'admin'],
    'admin-profil' => ['AdministrateurController', 'profil', 'admin'],
    'admin-dashboard' => ['AdministrateurController', 'dashboard', 'admin'],
];

// sans ?page= dans l'URL : la page de connexion
// (si on est déjà connecté, elle renvoie vers la page d'accueil du rôle)
$page = $_GET['page'] ?? 'connexion';

if (!isset($routes[$page])) {
    http_response_code(404);
    exit('Page introuvable');
}

$controleur = $routes[$page][0];
$methode = $routes[$page][1];
$roleObligatoire = $routes[$page][2];

if ($roleObligatoire != null) {
    // pas connecté : retour à la page de connexion
    if (!isset($_SESSION['id_utilisateur'])) {
        header('Location: ' . BASE_URL . '/index.php?page=connexion');
        exit;
    }

    // connecté, mais avec un autre rôle (ex : un participant qui tape une adresse enseignant)
    if ($_SESSION['role'] != $roleObligatoire) {
        http_response_code(403);
        exit('Vous n\'avez pas accès à cette page.');
    }
}

$objet = new $controleur();
$objet->$methode();

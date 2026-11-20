<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

define('BASE_URL', '/SAE3.01/public');

// TEST : simule un admin connecté (en attendant la vraie connexion)
$_SESSION['role'] = 'admin';

// Quel controller et quelle action ? (?c=...&a=...)
$c = $_GET['c'] ?? 'administrateur';
$a = $_GET['a'] ?? 'statistiques';

$controleurs = [
    'administrateur' => 'AdministrateurController',
];

if (!isset($controleurs[$c])) {
    exit('Page introuvable');
}

require __DIR__ . '/../app/controllers/' . $controleurs[$c] . '.php';
$controleur = new $controleurs[$c]();

if (!method_exists($controleur, $a)) {
    exit('Page introuvable');
}

$controleur->$a();

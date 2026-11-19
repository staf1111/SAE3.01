<?php

/**
 * Configuration de la navigation, un menu par rôle.
 * Fichier : app/controllers/navigation.php
 *
 * Chaque lien : clé => [libellé, href, icône].
 * "Mon profil" est ajouté automatiquement à la fin de chaque menu.
 */

$icons = [
    'home'     => '<path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>',
    'flask'    => '<path d="M9 3h6M10 3v6L4.5 19a1.5 1.5 0 0 0 1.3 2.2h12.4a1.5 1.5 0 0 0 1.3-2.2L14 9V3M7.5 15h9"/>',
    'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>',
    'users'    => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/>',
    'calendar' => '<rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 10h18M8 2v4M16 2v4"/>',
    'chart'    => '<path d="M4 21V10M10 21V4M16 21v-8M22 21H2"/>',
    'history'  => '<path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5M12 7v5l3 2"/>',
    'settings' => '<path d="M4 6h10M18 6h2M4 12h4M12 12h8M4 18h12M20 18h0"/><circle cx="16" cy="6" r="2"/><circle cx="10" cy="12" r="2"/><circle cx="18" cy="18" r="2"/>',
    'journal'  => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/>',
];

$profil = ['profil' => ['label' => 'Mon profil', 'href' => '#', 'icon' => $icons['user']]];

return [
    'participant' => [
        'accueil'          => ['label' => 'Accueil',          'href' => '#', 'icon' => $icons['home']],
        'experimentations' => ['label' => 'Expérimentations', 'href' => '#', 'icon' => $icons['flask']],
        'creneaux'         => ['label' => 'Créneaux',         'href' => '#', 'icon' => $icons['calendar']],
        'historique'       => ['label' => 'Historique',       'href' => '#', 'icon' => $icons['history']],
    ] + $profil,

    'enseignant' => [
        'dashboard'        => ['label' => 'Tableau de bord',  'href' => '#', 'icon' => $icons['home']],
        'experimentations' => ['label' => 'Expérimentations', 'href' => '#', 'icon' => $icons['flask']],
        'participants'     => ['label' => 'Participants',     'href' => '#', 'icon' => $icons['user']],
        'creneaux'         => ['label' => 'Créneaux',         'href' => '#', 'icon' => $icons['calendar']],
        'statistiques'     => ['label' => 'Statistiques',     'href' => '#', 'icon' => $icons['chart']],
    ] + $profil,

    'admin' => [
        'dashboard'    => ['label' => 'Tableau de bord', 'href' => '#', 'icon' => $icons['home']],
        'utilisateurs' => ['label' => 'Utilisateurs',    'href' => '#', 'icon' => $icons['users']],
        'parametres'   => ['label' => 'Paramètres',      'href' => '#', 'icon' => $icons['settings']],
        'journaux'     => ['label' => 'Journaux',        'href' => '#', 'icon' => $icons['journal']],
        'statistiques' => ['label' => 'Statistiques',    'href' => '#', 'icon' => $icons['chart']],
    ] + $profil,
];

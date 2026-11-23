<?php
// Onglets de la navbar pour chaque rôle
// Un onglet = label (texte affiché), href (lien) et icon (dessin SVG)

$icones = [
    'maison' => '<path d="M3 10.5 12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>',
    'fiole' => '<path d="M9 3h6M10 3v6L4.5 19a1.5 1.5 0 0 0 1.3 2.2h12.4a1.5 1.5 0 0 0 1.3-2.2L14 9V3M7.5 15h9"/>',
    'utilisateur' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>',
    'utilisateurs' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/>',
    'calendrier' => '<rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 10h18M8 2v4M16 2v4"/>',
    'graphique' => '<path d="M4 21V10M10 21V4M16 21v-8M22 21H2"/>',
    'historique' => '<path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5M12 7v5l3 2"/>',
    'reglages' => '<path d="M4 6h10M18 6h2M4 12h4M12 12h8M4 18h12"/><circle cx="16" cy="6" r="2"/><circle cx="10" cy="12" r="2"/><circle cx="18" cy="18" r="2"/>',
    'journal' => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/>',
    'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
];

// onglets présents pour tous les rôles
$ongletMessagerie = ['label' => 'Messagerie', 'href' => '#', 'icon' => $icones['mail']];
$ongletProfil = ['label' => 'Mon profil', 'href' => '#', 'icon' => $icones['utilisateur']];

$menus = [];

$menus['participant'] = [
    'accueil' => ['label' => 'Accueil', 'href' => '#', 'icon' => $icones['maison']],
    'experimentations' => ['label' => 'Expérimentations', 'href' => '#', 'icon' => $icones['fiole']],
    'creneaux' => ['label' => 'Créneaux', 'href' => '#', 'icon' => $icones['calendrier']],
    'historique' => ['label' => 'Historique', 'href' => '#', 'icon' => $icones['historique']],
    'messagerie' => $ongletMessagerie,
    'profil' => $ongletProfil,
];

$menus['enseignant'] = [
    'dashboard' => ['label' => 'Tableau de bord', 'href' => BASE_URL . '/index.php?page=dashboard', 'icon' => $icones['maison']],
    'experimentations' => ['label' => 'Expérimentations', 'href' => BASE_URL . '/index.php?page=experimentations', 'icon' => $icones['fiole']],
    'participants' => ['label' => 'Participants', 'href' => BASE_URL . '/index.php?page=participants', 'icon' => $icones['utilisateurs']],
    'creneaux' => ['label' => 'Créneaux', 'href' => BASE_URL . '/index.php?page=creneaux', 'icon' => $icones['calendrier']],
    'statistiques' => ['label' => 'Statistiques', 'href' => BASE_URL . '/index.php?page=statistiques', 'icon' => $icones['graphique']],
    'messagerie' => $ongletMessagerie,
    'profil' => $ongletProfil,
];

$menus['admin'] = [
    'dashboard' => ['label' => 'Tableau de bord', 'href' => '#', 'icon' => $icones['maison']],
    'utilisateurs' => ['label' => 'Utilisateurs', 'href' => BASE_URL . '/index.php?c=administrateur&a=utilisateurs', 'icon' => $icones['utilisateurs']],
    'parametres' => ['label' => 'Paramètres', 'href' => BASE_URL . '/index.php?c=administrateur&a=parametres', 'icon' => $icones['reglages']],
    'journaux' => ['label' => 'Journaux', 'href' => BASE_URL . '/index.php?c=administrateur&a=journaux', 'icon' => $icones['journal']],
    'statistiques' => ['label' => 'Statistiques', 'href' => BASE_URL . '/index.php?c=administrateur&a=statistiques', 'icon' => $icones['graphique']],
    'messagerie' => $ongletMessagerie,
    'profil' => $ongletProfil,
];

return $menus;

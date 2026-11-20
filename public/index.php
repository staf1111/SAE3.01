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

$utilisateur = [
    'role'   => 'Enseignant-chercheur',
    'prenom' => 'Damien',
    'nom'    => 'Serveau',
];

$experimentations = [
    [
        'titre'         => 'Perception des couleurs en réalité virtuelle',
        'statut'        => 'En cours',
        'statut_classe' => 'statut-en-cours',
        'progression'   => '',
        'creneau'       => 'Auj. 14:00 · Salle B-104',
    ],
    [
        'titre'         => 'Mémoire de travail et bilinguisme',
        'statut'        => 'En cours',
        'statut_classe' => 'statut-en-cours',
        'progression'   => '',
        'creneau'       => 'Mer. 10:00 · Salle A-012',
    ],
    [
        'titre'         => 'Attention visuelle chez l\'enfant',
        'statut'        => 'Brouillon',
        'statut_classe' => 'statut-brouillon',
        'progression'   => '',
        'creneau'       => '',
    ],
    [
        'titre'         => 'Sommeil et mémoire',
        'statut'        => 'Archivée',
        'statut_classe' => 'statut-archive',
        'progression'   => '',
        'creneau'       => '',
    ],
];

$creneauxAVenir = [
    [
        'jour' => '30', 'mois' => 'SEPT.',
        'titre' => 'Perception des couleurs en réalité virtuelle',
        'debut' => '10:00', 'fin' => '10:45', 'salle' => 'B-104',
        'statut' => 'En attente de validation', 'statut_classe' => 'statut-attente',
    ],
    [
        'jour' => '07', 'mois' => 'OCT.',
        'titre' => 'Perception des couleurs en réalité virtuelle',
        'debut' => '14:00', 'fin' => '14:45', 'salle' => 'B-104',
        'statut' => 'Confirmé', 'statut_classe' => 'statut-confirme',
    ],
    [
        'jour' => '15', 'mois' => 'OCT.',
        'titre' => 'Mémoire de travail et bilinguisme',
        'debut' => '09:00', 'fin' => '10:00', 'salle' => 'A-012',
        'statut' => 'Confirmé', 'statut_classe' => 'statut-confirme',
    ],
];

$experienceChoisie = 'Mémoire de travail et bilinguisme';

// etat : libre / selectionne / reserve / complet
$creneauxDisponibles = [
    ['libelle' => 'Lun. 13 oct. · 10:00', 'etat' => 'libre'],
    ['libelle' => 'Lun. 13 oct. · 14:00', 'etat' => 'selectionne'],
    ['libelle' => 'Mar. 14 oct. · 09:00', 'etat' => 'libre'],
    ['libelle' => 'Mer. 15 oct. · 09:00 · Déjà réservé', 'etat' => 'reserve'],
    ['libelle' => 'Jeu. 16 oct. · 11:00 · Complet', 'etat' => 'complet'],
    ['libelle' => 'Ven. 17 oct. · 10:00', 'etat' => 'libre'],
];

$statsHistorique = [
    'nb_participations' => 6,
    'temps_total'       => '4 h 30',
];

// statut_classe : statut-valide / statut-absent / statut-annule
$participations = [
    ['titre' => 'Perception des couleurs en réalité virtuelle', 'date' => '23 sept. 2026', 'statut' => 'Validée', 'statut_classe' => 'statut-valide'],
    ['titre' => 'Suivi oculaire et lecture sur écran',           'date' => '12 sept. 2026', 'statut' => 'Validée', 'statut_classe' => 'statut-valide'],
    ['titre' => 'Temps de réaction et fatigue',                  'date' => '3 sept. 2026',  'statut' => 'Validée', 'statut_classe' => 'statut-valide'],
    ['titre' => 'Écoute et localisation des sons',               'date' => '28 juin 2026',  'statut' => 'Absent',  'statut_classe' => 'statut-absent'],
    ['titre' => 'Mémoire de travail et bilinguisme',             'date' => '14 mai 2026',   'statut' => 'Validée', 'statut_classe' => 'statut-valide'],
    ['titre' => 'Perception tactile',                            'date' => '2 avr. 2026',   'statut' => 'Annulée par le labo', 'statut_classe' => 'statut-annule'],
];

$profil = [
    'prenom'            => 'Léa',
    'nom'               => 'Bernard',
    'email'             => 'lea.bernard@etu.univ-lemans.fr',
    'inscription'       => 'septembre 2025',
    'naissance'         => '2005-03-14',   // format AAAA-MM-JJ obligatoire pour le champ date
    'genre'             => 'Femme',
    'nb_participations' => 6,
    'profil_complete'   => 80,
];

$consentement = [
    'signe_le'       => '12/09/2025',
    'valable_jusqua' => '2027',
    'email'          => true,
    'rappel_veille'  => true,
    'sms'            => false,
];

session_start();

define('BASE_URL', '/SAE3.01/public'); // XAMPP

// TEST uniquement : simule un utilisateur connecté (participant, enseignant ou admin).
$_SESSION['role'] = 'participant';

require_once __DIR__ . '/../app/controllers/ParticipantController.php';

/*
 * Les liens de la navbar valent "#" dans navigation.php (fichier non modifié).
 * On les remplace ici, dans le HTML final, pour le participant uniquement.
 * Les liens qui ne valent pas "#" ne sont pas touchés : quand navigation.php
 * aura de vrais liens, tout ce bloc pourra être supprimé.
 */
if ($_SESSION['role'] === 'participant') {
    $pagesNavbar = [
        'Accueil'          => 'accueil',
        'Expérimentations' => 'experimentation',
        'Créneaux'         => 'creneaux',
        'Historique'       => 'historique',
        'Mon profil'       => 'profil',
    ];

    ob_start(function ($html) use ($pagesNavbar) {
        return preg_replace_callback(
            '#<a class="nav-link"\s+href="\#"(.*?)</a>#s',
            function ($m) use ($pagesNavbar) {
                // texte du lien = ce qui suit le premier ">" (on ignore les attributs et l'icône)
                $texte = trim(strip_tags(substr($m[1], strpos($m[1], '>') + 1)));
                foreach ($pagesNavbar as $libelle => $action) {
                    if (strpos($texte, $libelle) === 0) {
                        return str_replace('href="#"', 'href="' . BASE_URL . '/index.php?c=participant&amp;a=' . $action . '"', $m[0]);
                    }
                }
                return $m[0];
            },
            $html
        );
    });
}

/*
 * Routage simple, même principe que ta page de connexion (?c=...&a=...) :
 *   index.php?c=participant&a=accueil
 * Sans paramètre, on tombe sur l'accueil du participant.
 */
$controleur = $_GET['c'] ?? 'participant';
$action     = $_GET['a'] ?? 'accueil';

// Liste blanche : seules ces méthodes peuvent être appelées depuis l'adresse
$actionsParticipant = ['accueil', 'experimentation', 'creneaux', 'historique', 'profil'];

if ($controleur === 'participant' && in_array($action, $actionsParticipant, true)) {
    (new ParticipantController())->$action();
} else {
    http_response_code(404);
    echo 'Page introuvable';
}
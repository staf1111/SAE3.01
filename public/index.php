<<<<<<< HEAD
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
=======
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
        // créneaux proposés dans la pop-up "S'inscrire" (places = 0 : complet)
        'creneaux'    => [
            ['id' => 11, 'libelle' => 'Lundi 6 octobre · 10:00',     'places' => 2],
            ['id' => 12, 'libelle' => 'Mercredi 8 octobre · 14:00',  'places' => 3],
            ['id' => 13, 'libelle' => 'Vendredi 10 octobre · 09:30', 'places' => 0],
        ],
    ],
    [
        'id'          => 2,
        'titre'       => 'Mémoire de travail et bilinguisme',
        'description' => 'Tâches de mémorisation sur ordinateur',
        'duree'       => 30,
        'creneau'     => 'Mer. 10:00 · Salle A-012',
        'creneaux'    => [
            ['id' => 21, 'libelle' => 'Lundi 13 octobre · 10:00',    'places' => 4],
            ['id' => 22, 'libelle' => 'Mardi 14 octobre · 09:00',    'places' => 1],
            ['id' => 23, 'libelle' => 'Jeudi 16 octobre · 11:00',    'places' => 0],
        ],
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
        'id' => 1, 'experience_id' => 1,
        'jour' => '30', 'mois' => 'SEPT.',
        'titre' => 'Perception des couleurs en réalité virtuelle',
        'debut' => '10:00', 'fin' => '10:45', 'salle' => 'B-104',
        'statut' => 'En attente de validation', 'statut_classe' => 'statut-attente',
    ],
    [
        'id' => 2, 'experience_id' => 1,
        'jour' => '07', 'mois' => 'OCT.',
        'titre' => 'Perception des couleurs en réalité virtuelle',
        'debut' => '14:00', 'fin' => '14:45', 'salle' => 'B-104',
        'statut' => 'Confirmé', 'statut_classe' => 'statut-confirme',
    ],
    [
        'id' => 3, 'experience_id' => 2,
        'jour' => '15', 'mois' => 'OCT.',
        'titre' => 'Mémoire de travail et bilinguisme',
        'debut' => '09:00', 'fin' => '10:00', 'salle' => 'A-012',
        'statut' => 'Confirmé', 'statut_classe' => 'statut-confirme',
    ],
];

// Créneaux proposés quand on clique sur "Changer" (clé = experience_id du rendez-vous)
// etat : libre / selectionne / reserve / complet
$creneauxParExperience = [
    1 => [
        ['libelle' => 'Mar. 30 sept. · 10:00 · Déjà réservé', 'etat' => 'reserve'],
        ['libelle' => 'Mar. 7 oct. · 14:00 · Déjà réservé',   'etat' => 'reserve'],
        ['libelle' => 'Jeu. 9 oct. · 10:00',                  'etat' => 'libre'],
        ['libelle' => 'Ven. 10 oct. · 09:30 · Complet',       'etat' => 'complet'],
    ],
    2 => [
        ['libelle' => 'Lun. 13 oct. · 10:00', 'etat' => 'libre'],
        ['libelle' => 'Lun. 13 oct. · 14:00', 'etat' => 'selectionne'],
        ['libelle' => 'Mar. 14 oct. · 09:00', 'etat' => 'libre'],
        ['libelle' => 'Mer. 15 oct. · 09:00 · Déjà réservé', 'etat' => 'reserve'],
        ['libelle' => 'Jeu. 16 oct. · 11:00 · Complet', 'etat' => 'complet'],
        ['libelle' => 'Ven. 17 oct. · 10:00', 'etat' => 'libre'],
    ],
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
>>>>>>> Yeta

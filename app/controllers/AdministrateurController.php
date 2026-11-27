<?php
class AdministrateurController
{

    public function statistiques(): void
    {

        $stats = [
            'comptes_actifs'  => 1284,
            'nouveaux_mois'   => 57,
            'connexions_jour' => 212,
            'moyenne_jour'    => 185,
            'echecs_24h'      => 17,
            'comptes_bloques' => 2,
            'a_anonymiser'    => 12,
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
            30 => 212
        ];
        $comptesParRole = ['Participants' => 1104, 'Enseignants-chercheurs' => 118, 'Administrateurs' => 4];
        $compte_connexion_echoue = [];

        $currentPage = 'statistiques';
        $contentView = __DIR__ . '/../views/administrateur/admin_statistiques.php';
        require __DIR__ . '/../views/layout.php';
    }

    public function parametres(): void
    {

        $parametres = [
            'nom_application'           => 'Gestion des expérimentations',
            'email_contact'             => 'experimentations@univ-lemans.fr',
            'delai_annulation_heures'   => 24,
            'nb_max_inscriptions_simultanees' => 5,
            'duree_session_defaut_minutes'    => 30,
            'taille_max_document_mo'    => 10,
        ];

        $currentPage = 'parametres';
        $contentView = __DIR__ . '/../views/administrateur/admin_parametres.php';
        require __DIR__ . '/../views/layout.php';
    }

    public function journaux(): void
    {
        $filtres = [
            'tout'       => ['label' => 'Tout',       'nombre' => 1482],
            'connexions' => ['label' => 'Connexions', 'nombre' => 640],
            'actions'    => ['label' => 'Actions',    'nombre' => 824],
            'erreurs'    => ['label' => 'Erreurs',    'nombre' => 18],
        ];
        $filtreActif = $_GET['filtre'] ?? 'tout';
        $journaux = [
            [
                'heure'    => '14:32',
                'nom'      => 'Claire Martin',
                'role'     => 'Enseignant-chercheur',
                'action'   => "Validation d'une inscription",
                'ip'       => '192.168.4.21',
                'session'  => '08:42 → en cours',
                'resultat' => 'Succès',
                'type'     => 'succes',
            ],
            [
                'heure'    => '14:05',
                'nom'      => 'Marc Leroy',
                'role'     => 'Enseignant-chercheur',
                'action'   => 'Créneau validé — Salle B-104',
                'ip'       => '192.168.4.10',
                'session'  => '08:05 → en cours',
                'resultat' => 'Succès',
                'type'     => 'succes',
            ],
            [
                'heure'    => '12:47',
                'nom'      => 'Léa Bernard',
                'role'     => 'Participant',
                'action'   => "Réservation d'un créneau",
                'ip'       => '92.184.10.7',
                'session'  => '12:40 → 12:52',
                'resultat' => 'Succès',
                'type'     => 'succes',
            ],
            [
                'heure'    => '11:18',
                'nom'      => 'Julie Moreau',
                'role'     => 'Administrateur',
                'action'   => 'Modification des paramètres',
                'ip'       => '192.168.4.2',
                'session'  => '09:00 → en cours',
                'resultat' => 'Succès',
                'type'     => 'succes',
            ],
            [
                'heure'    => '08:31',
                'nom'      => 'tom.nguyen@exemple.fr',
                'role'     => 'Participant',
                'action'   => 'Connexion — mot de passe incorrect ×5',
                'ip'       => '81.250.3.14',
                'session'  => '—',
                'resultat' => 'Compte bloqué',
                'type'     => 'alerte',
            ],
            [
                'heure'    => '03:12',
                'nom'      => 'inconnu',
                'role'     => '—',
                'action'   => '12 tentatives « admin »',
                'ip'       => '185.220.101.7',
                'session'  => '—',
                'resultat' => 'IP bloquée',
                'type'     => 'alerte',
            ],
            [
                'heure'    => '02:00',
                'nom'      => 'Système',
                'role'     => 'Tâche automatique',
                'action'   => 'Anonymisation RGPD — 4 comptes',
                'ip'       => 'localhost',
                'session'  => '02:00 → 02:01',
                'resultat' => 'Succès',
                'type'     => 'info',
            ],
            [
                'heure'    => '01:45',
                'nom'      => 'Nathalie Bouvier',
                'role'     => 'Enseignant-chercheur',
                'action'   => "Création d'une expérimentation",
                'ip'       => '192.168.4.33',
                'session'  => '01:30 → 01:50',
                'resultat' => 'Succès',
                'type'     => 'succes',
            ],
            [
                'heure'    => '00:12',
                'nom'      => 'hugo.bernard@etu.univ-lemans.fr',
                'role'     => 'Participant',
                'action'   => 'Connexion — mot de passe incorrect ×2',
                'ip'       => '78.192.4.55',
                'session'  => '—',
                'resultat' => 'Échec',
                'type'     => 'alerte',
            ],
        ];
        $filtreActif = $_GET['filtre'] ?? 'tout';


        $parPage  = 7; //on aura 7lignes par pages
        $total    = count($journaux);
        $nbPages  = (int) ceil($total / $parPage);
        $page     = (int) ($_GET['page'] ?? 1);
        $page     = max(1, min($page, $nbPages));

        $debut          = ($page - 1) * $parPage;
        $journauxPage   = array_slice($journaux, $debut, $parPage);
        $currentPage = 'journaux';
        $contentView =  __DIR__ . '/../views/administrateur/admin_journaux.php';
        require __DIR__ . '/../views/layout.php';
    }

    public function utilisateurs(): void
    {

        $utilisateurs = [
            ['prenom' => 'Claire',  'nom' => 'Martin',  'email' => 'claire.martin@univ-lemans.fr',   'role' => 'Enseignant-chercheur', 'equipe' => 'LIUM · IEIAH', 'derniere_connexion' => 'Auj. 08:42', 'statut' => 'actif'],
            ['prenom' => 'Antoine', 'nom' => 'Petit',   'email' => 'antoine.petit@univ-lemans.fr',   'role' => 'Enseignant-chercheur', 'equipe' => 'LIUM · LST',   'derniere_connexion' => 'Auj. 09:10', 'statut' => 'actif'],
            ['prenom' => 'Marc',    'nom' => 'Leroy',   'email' => 'marc.leroy@univ-lemans.fr',      'role' => 'Administrateur',       'equipe' => 'LIUM',         'derniere_connexion' => 'Hier 17:10', 'statut' => 'actif'],
            ['prenom' => 'Léa',     'nom' => 'Bernard', 'email' => 'lea.bernard@etu.univ-lemans.fr', 'role' => 'Participant',          'equipe' => '—',            'derniere_connexion' => 'Auj. 12:40', 'statut' => 'actif'],
            ['prenom' => 'Tom',     'nom' => 'Nguyen',  'email' => 'tom.nguyen@exemple.fr',          'role' => 'Participant',          'equipe' => '—',            'derniere_connexion' => '30 sept.',   'statut' => 'bloque'],
            ['prenom' => 'Hugo',    'nom' => 'Bernard', 'email' => 'hugo.bernard@etu.univ-lemans.fr', 'role' => 'Participant',          'equipe' => '—',            'derniere_connexion' => 'Auj. 07:55', 'statut' => 'actif'],
            ['prenom' => 'Nathalie', 'nom' => 'Bouvier', 'email' => 'nathalie.bouvier@univ-lemans.fr', 'role' => 'Enseignant-chercheur', 'equipe' => 'CREN',         'derniere_connexion' => 'Hier 15:02', 'statut' => 'actif'],
        ];

        $filtres = [
            'tout'        => ['label' => 'Tous',        'role' => null],
            'participant' => ['label' => 'Participants', 'role' => 'Participant'],
            'enseignant'  => ['label' => 'Enseignants',  'role' => 'Enseignant-chercheur'],
            'admin'       => ['label' => 'Admins',       'role' => 'Administrateur'],
        ];
        //
        $filtreActif = $_GET['filtre'] ?? 'tout';
        if (!isset($filtres[$filtreActif])) {
            $filtreActif = 'tout';
        }

        // Nombre d'utilisateurs par onglet
        foreach ($filtres as $cle => $filtre) {
            $filtres[$cle]['nombre'] = 0;
            foreach ($utilisateurs as $u) {
                if ($filtre['role'] === null || $u['role'] === $filtre['role']) {
                    $filtres[$cle]['nombre']++;
                }
            }
        }

        // On ne garde que les utilisateurs de l'onglet choisi
        $roleChoisi = $filtres[$filtreActif]['role'];
        $liste = [];
        foreach ($utilisateurs as $u) {
            if ($roleChoisi === null || $u['role'] === $roleChoisi) {
                $liste[] = $u;
            }
        }

        // Pagination : 5 lignes par page
        $parPage = 5;
        $total   = count($liste);
        $nbPages = max(1, (int) ceil($total / $parPage));
        $page    = (int) ($_GET['page'] ?? 1);
        $page    = max(1, min($page, $nbPages));
        $debut   = ($page - 1) * $parPage;
        $utilisateursPage = array_slice($liste, $debut, $parPage);

        // Rôles et permissions (true = coché)
        $roles = ['Participant', 'Enseignant-chercheur', 'Administrateur'];
        $permissions = [
            "S'inscrire à une expérimentation"         => [true,  false, false],
            'Créer / modifier ses expérimentations'    => [false, true,  false],
            'Gérer les créneaux et les inscriptions'   => [false, true,  false],
            'Consulter les statistiques'               => [false, true,  true],
            'Gérer les comptes, paramètres et journaux' => [false, false, true],
        ];

        $currentPage = 'utilisateurs';
        $contentView = __DIR__ . '/../views/administrateur/admin_utilisateurs.php';
        require __DIR__ . '/../views/layout.php';
    }
    public function profil(): void
    {
        // Fausses données (remplacées plus tard par une requête sur UTILISATEUR)
        $profil = [
            'prenom'        => 'Claire',
            'nom'           => 'Lemoine',
            'email'         => 'claire.lemoine@univ-lemans.fr',
            'inscription'   => 'septembre 2025',
            'naissance'     => '1985-04-12',      // format AAAA-MM-JJ
            'genre'         => 'Femme',
            'derniere_connexion' => "Aujourd'hui à 08:42",
            'derniere_ip'   => '192.168.4.2',
        ];


        $resume = [
            'comptes_geres'       => 1284,
            'demandes_en_attente' => 12,
        ];


        $alertes = [
            'echecs_connexion' => true,
            'demandes_rgpd'    => true,
            'rapport_hebdo'    => false,
        ];

        $langue = 'Français';

        $currentPage = 'profil';
        $contentView = __DIR__ . '/../views/administrateur/admin_profil.php';
        require __DIR__ . '/../views/layout.php';
    }
}

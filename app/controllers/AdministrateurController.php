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
}

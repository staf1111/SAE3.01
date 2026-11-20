<?php
class AdministrateurController
{

    public function statistiques(): void
    {
        // Fausses données (remplacées plus tard par des requêtes SQL)
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
        $compte_connexion_echoue = [ /* ton tableau */];

        $currentPage = 'statistiques';
        $contentView = __DIR__ . '/../views/administrateur/admin_statistiques.php';
        require __DIR__ . '/../views/layout.php';
    }

    public function parametres(): void
    {
        // Fausses données : mêmes clés que ta table PARAMETRE
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
}

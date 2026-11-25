<?php
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Experimentation.php';

class EnseignantController
{
    public function dashboard()
    {
        $this->afficher('dashboard', 'TableauDeBord');
    }

    public function mesExperimentations()
    {
        $toutes = Experimentation::getParResponsable($_SESSION['id_utilisateur']);

        // nombre d'expérimentations pour chaque statut (pour les boutons de filtre)
        $compteurs = ['ouverte' => 0, 'brouillon' => 0, 'clôturée' => 0, 'archivée' => 0];
        foreach ($toutes as $exp) {
            $compteurs[$exp['statut_experimentation']]++;
        }

        // statut choisi dans l'URL (?statut=ouverte), null = toutes les expérimentations
        // on vérifie qu'il fait partie des statuts connus
        $filtre = null;
        if (isset($_GET['statut']) && isset($compteurs[$_GET['statut']])) {
            $filtre = $_GET['statut'];
        }

        // on garde seulement les expérimentations du statut choisi
        $experimentations = [];
        foreach ($toutes as $exp) {
            if ($filtre == null || $exp['statut_experimentation'] == $filtre) {
                $experimentations[] = $exp;
            }
        }

        $this->afficher('experimentations', 'MesExperimentations', [
            'experimentations' => $experimentations,
            'compteurs' => $compteurs,
            'total' => count($toutes),
            'filtre' => $filtre,
        ]);
    }

    // page de détail d'une expérimentation (bouton Gérer)
    public function gererExperimentation()
    {
        $idExperimentation = (int) ($_GET['id'] ?? 0);
        $exp = Experimentation::getParId($idExperimentation, $_SESSION['id_utilisateur']);

        if ($exp == false) {
            $this->rediriger('experimentations', 'erreur', 'Expérimentation introuvable.');
        }

        $this->afficher('experimentations', 'GererExperimentation', [
            'exp' => $exp,
        ]);
    }

    // bouton Clôturer ou Archiver d'une carte (formulaire en POST)
    public function changerStatut()
    {
        // on refuse un accès direct par l'URL : seul le formulaire peut modifier la base
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->rediriger('experimentations');
        }

        $exp = Experimentation::getParId($_POST['id_experimentation'], $_SESSION['id_utilisateur']);
        if ($exp == false) {
            $this->rediriger('experimentations', 'erreur', 'Expérimentation introuvable.');
        }

        $action = $_POST['action'] ?? '';
        $statut = $exp['statut_experimentation'];

        // une expérimentation en cours doit être clôturée avant d'être archivée
        if ($action == 'cloturer' && $statut == 'ouverte') {
            Experimentation::changerStatut($exp['id_experimentation'], 'clôturée');
            $this->rediriger('experimentations', 'succes', '« ' . $exp['titre'] . ' » est clôturée.');
        }

        if ($action == 'archiver' && ($statut == 'brouillon' || $statut == 'clôturée')) {
            Experimentation::changerStatut($exp['id_experimentation'], 'archivée');
            $this->rediriger('experimentations', 'succes', '« ' . $exp['titre'] . ' » est archivée.');
        }

        $this->rediriger('experimentations', 'erreur', 'Cette action n\'est pas possible pour cette expérimentation.');
    }

    public function mesCreneaux()
    {
        $this->afficher('creneaux', 'MesCreneaux');
    }

    public function statistiques()
    {
        $this->afficher('statistiques', 'Statistiques');
    }

    // affiche une vue de l'enseignant à l'intérieur du layout
    // $donnees contient les variables à envoyer à la vue
    private function afficher($page, $vue, $donnees = [])
    {
        // transforme ['experimentations' => ...] en variable $experimentations
        extract($donnees);

        // message laissé par la page précédente (après un formulaire), affiché une seule fois
        $message = null;
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        $utilisateur = Utilisateur::getParId($_SESSION['id_utilisateur']);
        $currentPage = $page; // onglet en rouge dans la navbar
        $badges = [];
        $contentView = __DIR__ . '/../views/enseignant/' . $vue . '.php';

        require __DIR__ . '/../views/layout.php';
    }

    // renvoie vers une page, avec un message à afficher ($type = succes ou erreur)
    private function rediriger($page, $type = null, $texte = null)
    {
        if ($texte != null) {
            $_SESSION['message'] = ['type' => $type, 'texte' => $texte];
        }

        header('Location: ' . BASE_URL . '/index.php?page=' . $page);
        exit;
    }
}
<?php

class EnseignantController
{
    public function dashboard()
    {
        $this->afficher('dashboard', 'TableauDeBord');
    }

    public function mesExperimentations()
    {
        $this->afficher('experimentations', 'MesExperimentations');
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
    private function afficher($page, $vue)
    {
        $currentPage = $page; // onglet en rouge dans la navbar
        $badges = [];
        $contentView = __DIR__ . '/../views/enseignant/' . $vue . '.php';

        require __DIR__ . '/../views/layout.php';
    }
}
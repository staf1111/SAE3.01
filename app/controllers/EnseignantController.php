<?php

class EnseignantController
{
    public function dashboard()        { $this->render('dashboard', 'TableauDeBord'); }
    public function mesExperimentations() { $this->render('experimentations', 'MesExperimentations'); }
    public function mesCreneaux()      { $this->render('creneaux', 'MesCreneaux'); }
    public function statistiques()     { $this->render('statistiques', 'Statistiques'); }

    private function render(string $page, string $vue): void
    {
        $currentPage = $page;                          // onglet allumé
        $badges      = [];                             // ex. ['creneaux' => 5]
        $contentView = __DIR__ . "/../views/enseignant/$vue.php";

        require __DIR__ . '/../views/layout.php';
    }
}
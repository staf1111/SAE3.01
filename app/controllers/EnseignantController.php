<?php

class EnseignantController
{
    public function mesExperimentations()
    {
        $currentPage = 'experimentations';
        $contentView = __DIR__ . '/../views/enseignant/MesExperimentations.php';

        require __DIR__ . '/../views/layout.php';
    }
}
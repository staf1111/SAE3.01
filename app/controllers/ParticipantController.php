<?php

class ParticipantController
{
    public function accueil()
    {
        $currentPage = 'accueil';
        $contentView = __DIR__ . '/../views/participant/Accueil.php';

        require __DIR__ . '/../views/layout.php';
    }

    public function experimentation()
    {
        $currentPage = 'experimentations';
        $contentView = __DIR__ . '/../views/participant/Experimentation.php';

        require __DIR__ . '/../views/layout.php';
    }
}
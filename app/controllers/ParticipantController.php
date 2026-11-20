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

        public function creneaux()
    {
        $currentPage = 'creneaux';
        $contentView = __DIR__ . '/../views/participant/Creneaux.php';

        require __DIR__ . '/../views/layout.php';
    }

            public function historique()
    {
        $currentPage = 'historique';
        $contentView = __DIR__ . '/../views/participant/Historique.php';

        require __DIR__ . '/../views/layout.php';
    }

                public function profil()
    {
        $currentPage = 'profil';
        $contentView = __DIR__ . '/../views/participant/Profil.php';

        require __DIR__ . '/../views/layout.php';
    }
}
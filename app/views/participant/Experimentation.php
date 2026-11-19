<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes expérimentations</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/participant/experimentation.css">
</head>
<body>

    <!-- NAVBAR : à ajouter ici quand elle sera prête -->

    <div class="page">

        <header class="page-header">
            <div>
                <h1>Mes expérimentations</h1>
                <!-- CHANGE : rôle et nom de l'utilisateur connecté -->
                <p class="page-sous-titre">Enseignant-chercheur · Serveau Damien</p>
            </div>

            <div class="langue">
                <button type="button" class="langue-connexion">
                    <img src="images/globe.png" alt="" class="icone">
                    Français <!-- CHANGE : langue active -->
                    <img src="images/fleche.png" alt="" class="icone-fleche">
                </button>

                <button type="button" class="night" aria-label="Mode sombre">
                    <img src="images/dark.png" alt="" class="icone-night">
                </button>
            </div>
        </header>

        <main>

            <div class="filtres">
                <!-- CHANGE : les nombres = nombre d'expérimentations de chaque type -->
                <button type="button" class="filtre actif">Toutes (4)</button>
                <button type="button" class="filtre">En cours (2)</button>
                <button type="button" class="filtre">Brouillons (1)</button>
                <button type="button" class="filtre">Archivées (1)</button>
            </div>

            <div class="cartes">

                <!-- CARTE (à répéter pour chaque expérimentation) -->
                <article class="carte">
                    <div class="carte-haut">
                        <div class="carte-titre">
                            <span class="carte-icone">
                                <img src="images/fiole.png" alt="">
                            </span>
                            <!-- CHANGE : titre -->
                            <h2>Perception des couleurs en réalité virtuelle</h2>
                        </div>
                        <!-- CHANGE : statut (statut-en-cours / statut-brouillon / statut-archive) -->
                        <span class="statut statut-en-cours">En cours</span>
                    </div>

                    <div class="progression">
                        <p class="progression-titre">
                            <img src="images/stats.png" alt="" class="icone-petite">
                            Progression
                        </p>
                        <!-- CHANGE : progression (ex : 8 / 20 participants) -->
                        <p class="progression-valeur">—</p>
                    </div>

                    <p class="carte-creneau">
                        <img src="images/horloge.png" alt="" class="icone-petite">
                        Prochain créneau : <strong>Auj. 14:00 · Salle B-104</strong> <!-- CHANGE : créneau -->
                    </p>
                </article>

                <article class="carte">
                    <div class="carte-haut">
                        <div class="carte-titre">
                            <span class="carte-icone">
                                <img src="images/fiole.png" alt="">
                            </span>
                            <h2>Exemple de travail</h2>
                        </div>
                        <span class="statut statut-en-cours">Statut</span>
                    </div>

                    <div class="progression">
                        <p class="progression-titre">
                            <img src="images/stats.png" alt="" class="icone-petite">
                            Progression
                        </p>
                        <p class="progression-valeur">—</p>
                    </div>

                    <p class="carte-creneau">
                        <img src="images/horloge.png" alt="" class="icone-petite">
                        Prochain créneau : <strong>Mer. 10:00 · Salle Ex-0</strong>
                    </p>
                </article>

            </div>
        </main>

    </div>

</body>
</html>

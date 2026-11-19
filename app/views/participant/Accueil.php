<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Accueil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/participant/accueil.css">
</head>
<body>

    <!-- NAVBAR : à ajouter ici quand elle sera prête -->

    <div class="page">

        <header class="page-header">
            <div>
                <h1>Accueil</h1>
                <!-- CHANGE : nom du participant connecté -->
                <p class="page-sous-titre">Participant Léa Bernard</p>
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
            <div class="accueil-layout">

                <section id="NewProjet">
                    <div class="section-entete">
                        <h2>Nouveaux projet ouvert pour vous</h2>

                        <div class="filtres">
                            <!-- CHANGE : le nombre = nombre de projets affichés -->
                            <button type="button" class="filtre actif">Toutes (4)</button>
                            <button type="button" class="filtre">&lt; 30 min</button>
                            <button type="button" class="filtre">Filtres</button>
                            <button type="button" class="filtre filtre-vide" aria-label="Autre filtre"></button>
                        </div>
                    </div>

                    <div class="cartes">

                        <!-- CARTE PROJET (à répéter pour chaque projet) -->
                        <article class="carte-projet">
                            <div class="carte-entete">
                                <span class="carte-icone">
                                    <img src="images/fiole.png" alt="">
                                </span>
                                <!-- CHANGE : titre du projet -->
                                <h3>Perception des couleurs en réalité virtuelle</h3>
                            </div>

                            <!-- CHANGE : description -->
                            <p class="carte-description">Évaluation de couleurs à l'aide d'un casque</p>

                            <!-- CHANGE : durée -->
                            <p class="carte-duree">45 min</p>

                            <!-- CHANGE : prochain créneau disponible -->
                            <p class="carte-creneau">
                                <img src="images/horloge.png" alt="" class="icone-petite">
                                Prochain créneau : <strong>Auj. 14:00 · Salle B-104</strong>
                            </p>

                            <button type="button" class="btn-primaire">S'inscrire</button>
                        </article>

                        <!-- 2e carte (même structure) -->
                        <article class="carte-projet">
                            <div class="carte-entete">
                                <span class="carte-icone">
                                    <img src="images/fiole.png" alt="">
                                </span>
                                <h3>Perception des couleurs en réalité virtuelle</h3>
                            </div>

                            <p class="carte-description">Évaluation de couleurs à l'aide d'un casque</p>
                            <p class="carte-duree">45 min</p>

                            <p class="carte-creneau">
                                <img src="images/horloge.png" alt="" class="icone-petite">
                                Prochain créneau : <strong>Auj. 14:00 · Salle B-104</strong>
                            </p>

                            <button type="button" class="btn-primaire">S'inscrire</button>
                        </article>

                    </div>
                </section>

                <aside id="ProchainsCreneaux">
                    <h2>Mes prochains créneaux</h2>

                    <ul class="liste-creneaux">
                        <!-- CRÉNEAU (à répéter pour chaque créneau réservé) -->
                        <li class="creneau">
                            <!-- CHANGE : jour et mois -->
                            <div class="creneau-date">
                                <span class="jour">30</span>
                                <span class="mois">SEPT</span>
                            </div>
                            <!-- CHANGE : titre, heure, salle -->
                            <div class="creneau-infos">
                                <strong>Perception VR</strong>
                                <span>10.00h salle B</span>
                            </div>
                        </li>

                        <li class="creneau">
                            <div class="creneau-date">
                                <span class="jour">30</span>
                                <span class="mois">SEPT</span>
                            </div>
                            <div class="creneau-infos">
                                <strong>Perception VR</strong>
                                <span>10.00h salle B</span>
                            </div>
                        </li>
                    </ul>
                </aside>

            </div>

            <section id="Historique">
                <h2>Historique récent</h2>

                <table>
                    <thead>
                        <tr>
                            <th>Expérimentations</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <!-- CHANGE : nom de l'expérimentation + détail -->
                            <td>
                                <strong>Perceptions des couleurs</strong>
                                <small>4 séances de 45 min prochainement</small>
                            </td>
                            <!-- CHANGE : date -->
                            <td><span class="badge-date">12 sept</span></td>
                            <!-- CHANGE : statut -->
                            <td><span class="statut statut-valide">Participation validée</span></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>

    </div>

</body>
</html>

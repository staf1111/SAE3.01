<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Accueil</title>
    <link rel="stylesheet" href="css/participant/accueil.css">
</head>
<body>

    <!-- NAVBAR : à ajouter ici quand elle sera prête -->

    <header>
        <div>
            <h1>Accueil</h1>
            <!-- CHANGE : nom du participant connecté -->
            <p>Participant Léa Bernard</p>
        </div>
        <div>
            <select>
                <option>Français</option>
                <option>English</option>
            </select>
            <button type="button">o</button>
        </div>
    </header>

    <main>
        <div class="contenu">

            <section id="NewProjet">
                <h2>Nouveaux projet ouvert pour vous</h2>

                <div class="filtres">
                    <!-- CHANGE : le nombre = nombre de projets -->
                    <button type="button">Toutes (4)</button>
                    <button type="button">&lt; 30 min</button>
                    <button type="button">Filtres</button>
                </div>

                <div class="cartes">

                    <article class="carte-projet">
                        <h3>Perception des couleurs en réalité virtuelle</h3> <!-- CHANGE : titre -->
                        <p>Évaluation de couleurs à l'aide d'un casque</p>       <!-- CHANGE : description -->
                        <p>45 min</p>                                            <!-- CHANGE : durée -->
                        <p>Prochain créneau : <strong>Auj. 14:00 · Salle B-104</strong></p> <!-- CHANGE : créneau -->
                        <button type="button">S'inscrire</button>
                    </article>

                    <article class="carte-projet">
                        <h3>Perception des couleurs en réalité virtuelle</h3>
                        <p>Évaluation de couleurs à l'aide d'un casque</p>
                        <p>45 min</p>
                        <p>Prochain créneau : <strong>Auj. 14:00 · Salle B-104</strong></p>
                        <button type="button">S'inscrire</button>
                    </article>

                </div>
            </section>

            <aside id="Creneaux">
                <h2>Mes prochains créneaux</h2>

                <div class="creneau">
                    <div class="date">
                        <strong>30</strong><br>SEPT   <!-- CHANGE : jour / mois -->
                    </div>
                    <div>
                        <strong>Perception VR</strong><br>   <!-- CHANGE : titre -->
                        10.00h salle B                       <!-- CHANGE : heure / salle -->
                    </div>
                </div>

                <div class="creneau">
                    <div class="date">
                        <strong>30</strong><br>SEPT
                    </div>
                    <div>
                        <strong>Perception VR</strong><br>
                        10.00h salle B
                    </div>
                </div>
            </aside>

        </div>

        <section id="Historique">
            <h2>Historique récent</h2>

            <table>
                <tr>
                    <th>Expérimentations</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
                <tr>
                    <td>
                        <strong>Perceptions des couleurs</strong><br> <!-- CHANGE : nom -->
                        <small>4 séances de 45 min prochainement</small> <!-- CHANGE : détail -->
                    </td>
                    <td>12 sept</td>                  <!-- CHANGE : date -->
                    <td class="valide">Participation validée</td> <!-- CHANGE : statut -->
                </tr>
            </table>
        </section>
    </main>

</body>
</html>

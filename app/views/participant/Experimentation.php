<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes expérimentations</title>
    <link rel="stylesheet" href="css/participant/experimentation.css">
</head>
<body>

    <!-- NAVBAR : à ajouter ici quand elle sera prête -->

    <div class="page">

        <header>
            <div>
                <h1>Mes expérimentations</h1>
                <!-- CHANGE : rôle et nom de l'utilisateur connecté -->
                <p>Enseignant-chercheur · Serveau Damien</p>
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

            <div class="filtres">
                <!-- CHANGE : les nombres = nombre d'expérimentations de chaque type -->
                <button type="button" class="actif">Toutes (4)</button>
                <button type="button">En cours (2)</button>
                <button type="button">Brouillons (1)</button>
                <button type="button">Archivées (1)</button>
            </div>

            <div class="cartes">

                <!-- CARTE (à répéter pour chaque expérimentation) -->
                <article class="carte">
                    <div class="carte-haut">
                        <h2> Perception des couleurs en réalité virtuelle</h2> <!-- CHANGE : titre -->
                        <span class="statut">● En cours</span>                  <!-- CHANGE : statut -->
                    </div>

                    <div class="progression">
                         Progression<br>
                        <strong>—</strong>   <!-- CHANGE : progression (ex : 8 / 20 participants) -->
                    </div>

                    <p> Prochain créneau : <strong>Auj. 14:00 · Salle B-104</strong></p> <!-- CHANGE : créneau -->
                </article>

                <article class="carte">
                    <div class="carte-haut">
                        <h2> Mémoire de travail et bilinguisme</h2>
                        <span class="statut">● En cours</span>
                    </div>

                    <div class="progression">
                         Progression<br>
                        <strong>—</strong>
                    </div>

                    <p> Prochain créneau : <strong>Mer. 10:00 · Salle A-012</strong></p>
                </article>

            </div>
        </main>

    </div>

</body>
</html>

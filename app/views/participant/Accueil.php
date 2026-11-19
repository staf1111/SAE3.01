<?php
/*
 * Vue : Accueil du participant
 *
 * Variables attendues (définies dans index.php, plus tard dans le contrôleur) :
 *   $participant        -> ['prenom' => ..., 'nom' => ...]
 *   $langue             -> 'Français'
 *   $projets            -> liste de projets ouverts
 *   $prochainsCreneaux  -> liste des créneaux réservés
 *   $historique         -> liste des participations passées
 */
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/participant/accueil.css">

<!-- NAVBAR : à ajouter ici quand elle sera prête -->
<!-- <?php // require __DIR__ . '/../navbar.php'; ?> -->

<div class="page">

    <!-- ========== EN-TÊTE DE PAGE ========== -->
    <header class="page-header">
        <div>
            <h1>Accueil</h1>
            <p class="page-sous-titre">
                Participant <?= htmlspecialchars($participant['prenom'] . ' ' . $participant['nom']) ?>
            </p>
        </div>

        <!-- Les 2 boutons : langue + mode sombre -->
        <div class="langue">
            <button type="button" class="langue-connexion">
                <img src="images/globe.png" alt="" class="icone">
                <?= htmlspecialchars($langue) ?>
                <img src="images/fleche.png" alt="" class="icone-fleche">
            </button>

            <button type="button" class="night" aria-label="Mode sombre">
                <img src="images/dark.png" alt="" class="icone-night">
            </button>
        </div>
    </header>

    <main>
        <div class="accueil-layout">

            <!-- ========== NOUVEAUX PROJETS ========== -->
            <section id="NewProjet">
                <div class="section-entete">
                    <h2>Nouveaux projet ouvert pour vous</h2>

                    <div class="filtres">
                        <button type="button" class="filtre actif">Toutes (<?= count($projets) ?>)</button>
                        <button type="button" class="filtre">&lt; 30 min</button>
                        <button type="button" class="filtre">Filtres</button>
                    </div>
                </div>

                <div class="cartes">
                    <?php foreach ($projets as $projet): ?>
                        <article class="carte-projet">
                            <div class="carte-entete">
                                <span class="carte-icone">
                                    <img src="images/fiole.png" alt="">
                                </span>
                                <h3><?= htmlspecialchars($projet['titre']) ?></h3>
                            </div>

                            <p class="carte-description"><?= htmlspecialchars($projet['description']) ?></p>

                            <p class="carte-duree"><?= (int) $projet['duree'] ?> min</p>

                            <p class="carte-creneau">
                                <img src="images/horloge.png" alt="" class="icone-petite">
                                Prochain créneau : <strong><?= htmlspecialchars($projet['creneau']) ?></strong>
                            </p>

                            <!-- À faire plus tard : envoyer $projet['id'] pour l'inscription -->
                            <button type="button" class="btn-primaire">S'inscrire</button>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- ========== MES PROCHAINS CRÉNEAUX ========== -->
            <aside id="ProchainsCreneaux">
                <h2>Mes prochains créneaux</h2>

                <ul class="liste-creneaux">
                    <?php foreach ($prochainsCreneaux as $creneau): ?>
                        <li class="creneau">
                            <div class="creneau-date">
                                <span class="jour"><?= htmlspecialchars($creneau['jour']) ?></span>
                                <span class="mois"><?= htmlspecialchars($creneau['mois']) ?></span>
                            </div>
                            <div class="creneau-infos">
                                <strong><?= htmlspecialchars($creneau['titre']) ?></strong>
                                <span><?= htmlspecialchars($creneau['heure']) ?> salle <?= htmlspecialchars($creneau['salle']) ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>

        </div>

        <!-- ========== HISTORIQUE RÉCENT ========== -->
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
                    <?php foreach ($historique as $ligne): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($ligne['titre']) ?></strong>
                                <small><?= htmlspecialchars($ligne['detail']) ?></small>
                            </td>
                            <td><span class="badge-date"><?= htmlspecialchars($ligne['date']) ?></span></td>
                            <td><span class="statut statut-valide"><?= htmlspecialchars($ligne['statut']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

</div>

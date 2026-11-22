<link rel="stylesheet" href="<?= BASE_URL ?>/css/administrateur_css/parametres.css">

<div class="entete-param">
    <h1 class="titre-parametre">Paramètres de l'application</h1>
</div>

<div class="carte-param">

    <div class="carte-titre">
        <span class="carte-icone">
            <img src="<?= BASE_URL ?>/images/globe.png" alt="">
        </span>
        <h2>Général</h2>
    </div>


    <div class="champ-param">
        <label for="nom_application">Nom de l'application</label>
        <input type="text" id="nom_application" name="nom_application" value="Le Mans Université">
    </div>


    <div class="deux-colonnes">
        <div class="champ-param">
            <label for="langue_defaut">Langue par défaut</label>
            <select id="langue_defaut" name="langue_defaut">
                <option value="fr">Français</option>
                <option value="en">English</option>
                <option value="es">Español</option>
            </select>
        </div>

        <div class="champ-param">
            <label>Thème par défaut</label>
            <div class="choix-theme">
                <span class="theme actif">
                    <img src="<?= BASE_URL ?>/images/clair.png" alt="" class="icone-theme"> Clair
                </span>
                <span class="theme">
                    <img src="<?= BASE_URL ?>/images/dark.png" alt="" class="icone-theme"> Sombre
                </span>
                <span class="theme">Auto</span>
            </div>
        </div>
    </div>


    <div class="champ-param">
        <label>Langues disponibles</label>
        <div class="liste-langues">
            <span class="langue-chip">Français <img src="<?= BASE_URL ?>/images/croix.png" alt="Retirer" class="croix"></span>
            <span class="langue-chip">English <img src="<?= BASE_URL ?>/images/croix.png" alt="Retirer" class="croix"></span>
            <span class="langue-chip">Español <img src="<?= BASE_URL ?>/images/croix.png" alt="Retirer" class="croix"></span>
            <span class="ajouter-langue">+ Ajouter</span>
        </div>
    </div>


    <p class="libelles">
        Libellés des champs et boutons :
        <a href="#" class="lien-rouge">Modifier les textes (248)</a>
    </p>

</div>

<div class="carte-param">

    <div class="carte-titre">
        <span class="carte-icone">
            <img src="<?= BASE_URL ?>/images/bdd.png" alt="">
        </span>
        <h2>Base de données</h2>
        <span class="badge-connexion">Connectée</span>
    </div>

    <div class="deux-colonnes">
        <div class="champ-param">
            <label for="type_bdd">Type</label>
            <select id="type_bdd" name="type_bdd">
                <option value="mariadb">MariaDB</option>
                <option value="mysql">MySQL</option>
            </select>
        </div>

        <div class="champ-param">
            <label for="port">Port</label>
            <input type="text" id="port" name="port" value="3306">
        </div>
    </div>

    <div class="champ-param">
        <label for="url_bdd">Adresse (URL) de la base</label>
        <input type="text" id="url_bdd" name="url_bdd" value="mysql://localhost/sae">
    </div>

    <div class="deux-colonnes">
        <div class="champ-param">
            <label for="identifiant_bdd">Identifiant</label>
            <input type="text" id="identifiant_bdd" name="identifiant_bdd" value="etu">
        </div>

        <div class="champ-param">
            <label for="mdp_bdd">Mot de passe</label>
            <div class="champ-mdp">
                <input type="password" id="mdp_bdd" name="mdp_bdd" placeholder="••••••••••">
                <img src="<?= BASE_URL ?>/images/voir_mdp.png" alt="Afficher le mot de passe" class="oeil">
            </div>
        </div>
    </div>

    <button type="button" class="bouton-tester">
        <img src="<?= BASE_URL ?>/images/prise.png" alt="" class="icone-bouton">
        Tester la connexion
    </button>

</div>
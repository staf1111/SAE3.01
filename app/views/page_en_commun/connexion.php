<link rel="stylesheet" href="css/connexion.css">

<div class="marque">
    <img src="images/logo.png" alt="" class="marque-logo">
    <div class="marque-textes">
        <span class="marque-titre">Le Mans Université</span>
      
    </div>
</div>

<div class="langue">
    <span class="langue-connexion">
        <img src="images/globe.png" alt="" class="icone">
        Français
        <img src="images/fleche.png" alt="" class="icone-fleche">
    </span>

    <span class="night">
        <img src="images/dark.png" alt="Mode sombre" class="icone-night">
    </span>
</div>

<div class="panneau-gauche">
    <img src="images/Ellipse.png" alt="" class="ellipse">
    <div class="Textes-connexion">
        <span class="Textes-exp">Les expérimentations de vos <br> laboratoires, au même <br> endroit.</span>
        <span class="Sous-textes">Créez, planifiez et suivez vos études — de l'inscription des participants<br> jusqu'à la rétribution.</span>
    </div>
</div>


<div class="panneau-droit">
    <div class="carte-connexion">
        <h1 class="titre-connexion">Connexion</h1>
        <p class="sous-titre-connexion">Utilisez vos identifiants de l'université.</p>

        <a href="#" class="bouton-cas">
            <img src="images/cle.png" alt="" class="icone">
            Se connecter avec l'ENT (CAS)
        </a>

        <div class="separateur"><span>ou participant externe</span></div>

        <?php if (!empty($erreur)): ?>
            <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <form method="post" action="index.php?c=auth&a=connexion">
            <label for="email">Adresse e-mail</label>
            <div class="champ">
                <img src="images/mail.png" alt="" class="icone">
                <input type="email" id="email" name="email" placeholder="prenom.nom@exemple.fr" required>
            </div>

            <label for="mot_de_passe">Mot de passe</label>
            <div class="champ">
                <img src="images/cadenas.png" alt="" class="icone">
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" required>
                <img src="images/voir_mdp.png" alt="Afficher le mot de passe" class="icone oeil">
            </div>

            <div class="options">
                <label class="souvenir">
                    <input type="checkbox" name="souvenir"> Se souvenir de moi
                </label>
                <a href="#" class="lien-rouge">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="bouton-connexion">Se connecter →</button>
        </form>

        <p class="pied-connexion">
            Pas encore de compte ? <a href="#" class="lien-rouge">Devenir participant</a>
        </p>
    </div>
</div>



<?php
// Valeurs par défaut (évitent les avertissements de VS Code)
$profil  = $profil ?? [];
$resume  = $resume ?? [];
$alertes = $alertes ?? [];
$langue  = $langue ?? 'Français';

// Initiales affichées dans le rond orange (ex : CL)
$initiales = mb_strtoupper(mb_substr($profil['prenom'], 0, 1) . mb_substr($profil['nom'], 0, 1));

// Choix possibles pour le genre
$genres = ['Femme', 'Homme', 'Autre', 'Ne souhaite pas répondre'];
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/administrateur_css/profil.css">

<!-- Un seul formulaire pour toute la page : le bouton "Enregistrer" envoie tout -->
<form class="page-profil" method="post" action="" enctype="multipart/form-data">

    <!-- ========== EN-TÊTE ========== -->
    <header class="page-header">
        <div>
            <h1>Mon profil</h1>
            <p class="page-sous-titre">Administrateur · <?= htmlspecialchars($profil['prenom'] . ' ' . $profil['nom']) ?></p>
        </div>

        <div class="actions-header">
            <button type="button" class="langue-connexion">
                <img src="<?= BASE_URL ?>/images/globe.png" alt="" class="icone">
                <?= htmlspecialchars($langue) ?>
                <img src="<?= BASE_URL ?>/images/fleche.png" alt="" class="icone-fleche">
            </button>

            <button type="button" class="night" aria-label="Mode sombre">
                <img src="<?= BASE_URL ?>/images/dark.png" alt="" class="icone-night">
            </button>

            <button type="submit" class="btn-enregistrer">
                <img src="<?= BASE_URL ?>/images/disquette.png" alt="" class="ico">
                Enregistrer
            </button>
        </div>
    </header>

    <!-- ========== BANDEAU BLEU ========== -->
    <section class="bandeau">
        <div class="avatar"><?= htmlspecialchars($initiales) ?></div>

        <div class="bandeau-identite">
            <h2><?= htmlspecialchars($profil['prenom'] . ' ' . $profil['nom']) ?></h2>
            <p><?= htmlspecialchars($profil['email']) ?> · administrateur depuis <?= htmlspecialchars($profil['inscription']) ?></p>
        </div>

        <div class="bandeau-stats">
            <div>
                <strong><?= number_format($resume['comptes_geres'], 0, ',', ' ') ?></strong>
                <span>comptes gérés</span>
            </div>
            <div>
                <strong><?= (int) $resume['demandes_en_attente'] ?></strong>
                <span>demandes RGPD</span>
            </div>
        </div>

        <!-- Le label ouvre le choix de fichier (sans JavaScript) -->
        <label class="btn-photo">
            <img src="<?= BASE_URL ?>/images/crayon.png" alt="" class="icone-bouton">
            Changer la photo
            <input type="file" name="photo" accept="image/*" hidden>
        </label>
    </section>

    <div class="profil-layout">

        <!-- ========== INFORMATIONS PERSONNELLES ========== -->
        <section class="carte">
            <h2 class="carte-titre">
                <span class="titre-icone"><img src="<?= BASE_URL ?>/images/personne-rouge.png" alt="" class="ico"></span>
                Informations personnelles
            </h2>

            <div class="grille">
                <div class="groupe">
                    <label for="prenom">Prénom</label>
                    <div class="champ">
                        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($profil['prenom']) ?>" required>
                    </div>
                </div>

                <div class="groupe">
                    <label for="nom">Nom</label>
                    <div class="champ">
                        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($profil['nom']) ?>" required>
                    </div>
                </div>

                <div class="groupe">
                    <label for="naissance">Date de naissance</label>
                    <div class="champ">
                        <img src="<?= BASE_URL ?>/images/calendrier.png" alt="" class="ico">
                        <input type="date" id="naissance" name="naissance" value="<?= htmlspecialchars($profil['naissance']) ?>">
                    </div>
                </div>

                <div class="groupe">
                    <label for="genre">Genre</label>
                    <div class="champ">
                        <select id="genre" name="genre">
                            <?php foreach ($genres as $g): ?>
                                <option <?= $g === $profil['genre'] ? 'selected' : '' ?>><?= htmlspecialchars($g) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="groupe pleine-largeur">
                    <label for="email">Adresse e-mail</label>
                    <div class="champ">
                        <img src="<?= BASE_URL ?>/images/mail.png" alt="" class="ico">
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($profil['email']) ?>" required>
                    </div>
                </div>

                <div class="groupe pleine-largeur">
                    <label for="mdp">Mot de passe</label>
                    <div class="ligne-mdp">
                        <div class="champ">
                            <input type="password" id="mdp" value="••••••••" disabled>
                        </div>
                        <!-- À relier plus tard à la page de changement de mot de passe -->
                        <a href="#" class="btn-modifier">Modifier</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== COLONNE DE DROITE ========== -->
        <div class="colonne-droite">

            <!-- Sécurité du compte -->
            <section class="carte">
                <h2 class="carte-titre">
                    <span class="titre-icone"><img src="<?= BASE_URL ?>/images/bouclier.png" alt="" class="ico"></span>
                    Sécurité
                </h2>

                <p class="signature">
                    <img src="<?= BASE_URL ?>/images/coche.png" alt="" class="ico">
                    Dernière connexion : <?= htmlspecialchars($profil['derniere_connexion']) ?>
                </p>

                <p class="info-ligne">
                    <span>Adresse IP</span>
                    <strong><?= htmlspecialchars($profil['derniere_ip']) ?></strong>
                </p>

            </section>

            <!-- Alertes administrateur -->
            <section class="carte">
                <h2 class="carte-titre">
                    <span class="titre-icone"><img src="<?= BASE_URL ?>/images/cloche.png" alt="" class="ico"></span>
                    Alertes
                </h2>

                <label class="option">
                    <span>Échecs de connexion répétés</span>
                    <input type="checkbox" class="switch" name="alerte_echecs" <?= $alertes['echecs_connexion'] ? 'checked' : '' ?>>
                </label>

                <label class="option">
                    <span>Nouvelles demandes de suppression (RGPD)</span>
                    <input type="checkbox" class="switch" name="alerte_rgpd" <?= $alertes['demandes_rgpd'] ? 'checked' : '' ?>>
                </label>

                <label class="option">
                    <span>Rapport d'activité hebdomadaire</span>
                    <input type="checkbox" class="switch" name="alerte_rapport" <?= $alertes['rapport_hebdo'] ? 'checked' : '' ?>>
                </label>
            </section>

        </div>
    </div>

</form>
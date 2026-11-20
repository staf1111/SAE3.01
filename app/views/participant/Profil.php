<?php
/*
 * Vue : Mon profil
 *
 * Les données viennent de public/index.php (variables globales).
 * Cette vue est chargée dans une méthode du contrôleur, donc on les
 * déclare "global" pour pouvoir les utiliser ici.
 */
global $profil, $consentement, $langue;

// Initiales affichées dans le rond orange (ex : LB)
$initiales = mb_strtoupper(mb_substr($profil['prenom'], 0, 1) . mb_substr($profil['nom'], 0, 1));

// Choix possibles pour le genre
$genres = ['Femme', 'Homme', 'Autre', 'Ne souhaite pas répondre'];
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/css/participant/profil.css">

<!-- Un seul formulaire pour toute la page : le bouton "Enregistrer" envoie tout -->
<form class="page" method="post" action="" enctype="multipart/form-data">

    <!-- ========== EN-TÊTE ========== -->
    <header class="page-header">
        <div>
            <h1>Mon profil</h1>
            <p class="page-sous-titre">Participant · <?= htmlspecialchars($profil['prenom'] . ' ' . $profil['nom']) ?></p>
        </div>

        <div class="langue">
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
            <p><?= htmlspecialchars($profil['email']) ?> · inscrite depuis <?= htmlspecialchars($profil['inscription']) ?></p>
        </div>

        <div class="bandeau-stats">
            <div>
                <strong><?= (int) $profil['nb_participations'] ?></strong>
                <span>participations</span>
            </div>
            <div>
                <strong><?= (int) $profil['profil_complete'] ?> %</strong>
                <span>profil complété</span>
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
                        <!-- la valeur doit être au format AAAA-MM-JJ -->
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
                        <!-- CHANGE : lien vers la page de changement de mot de passe -->
                        <a href="#" class="btn-modifier">Modifier</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== COLONNE DE DROITE ========== -->
        <div class="colonne-droite">

            <!-- Consentement -->
            <section class="carte">
                <h2 class="carte-titre">
                    <span class="titre-icone"><img src="<?= BASE_URL ?>/images/bouclier.png" alt="" class="ico"></span>
                    Consentement
                </h2>

                <p class="signature">
                    <img src="<?= BASE_URL ?>/images/coche.png" alt="" class="ico">
                    Signé le <?= htmlspecialchars($consentement['signe_le']) ?> · valable jusqu'en <?= htmlspecialchars($consentement['valable_jusqua']) ?>
                </p>

                <label class="option">
                    <span>Recevoir les nouvelles expériences par e-mail</span>
                    <input type="checkbox" class="switch" name="notif_email" <?= $consentement['email'] ? 'checked' : '' ?>>
                </label>

                <label class="option">
                    <span>Rappel la veille d'un créneau</span>
                    <input type="checkbox" class="switch" name="notif_rappel" <?= $consentement['rappel_veille'] ? 'checked' : '' ?>>
                </label>

                <label class="option">
                    <span>Rappel par SMS</span>
                    <input type="checkbox" class="switch" name="notif_sms" <?= $consentement['sms'] ? 'checked' : '' ?>>
                </label>
            </section>

            <!-- Mes données (RGPD) -->
            <section class="carte">
                <h2 class="carte-titre">
                    <span class="titre-icone"><img src="<?= BASE_URL ?>/images/telecharger.png" alt="" class="ico"></span>
                    Mes données
                </h2>

                <p class="aide">Vous pouvez récupérer ou supprimer vos données à tout moment (RGPD).</p>

                <!-- À relier plus tard à de vraies actions -->
                <button type="button" class="btn-donnees btn-telecharger">
                    <img src="<?= BASE_URL ?>/images/telecharger-bleu.png" alt="" class="ico">
                    Télécharger mes données
                </button>

                <button type="button" class="btn-donnees btn-supprimer" popovertarget="confirmation-suppression">
                    <img src="<?= BASE_URL ?>/images/poubelle.png" alt="" class="ico">
                    Supprimer mon compte
                </button>
            </section>

        </div>
    </div>

</form>

<!-- ========== CONFIRMATION DE SUPPRESSION DU COMPTE ==========
     Fenêtre "popover" (s'ouvre avec le bouton "Supprimer mon compte", sans JavaScript).
     Elle est placée EN DEHORS du formulaire du profil (deux <form> ne peuvent pas s'imbriquer). -->
<div popover id="confirmation-suppression" class="confirmation">
    <h2>Êtes-vous sûr de vouloir supprimer le compte ?</h2>
    <p>Cette action est définitive : toutes vos données seront supprimées.</p>

    <form method="post" action="" class="actions-confirmation">
        <!-- CHANGE : le contrôleur doit reconnaître ce champ pour supprimer le compte -->
        <input type="hidden" name="supprimer_compte" value="1">

        <button type="button" class="btn-retour" popovertarget="confirmation-suppression" popovertargetaction="hide">
            Annuler
        </button>

        <!-- Les 2 boutons sont superposés :
             - pendant 5 secondes on voit le faux bouton avec le compte à rebours,
             - ensuite il disparaît et le vrai bouton "Supprimer" devient cliquable. -->
        <div class="zone-validation">
            <span class="btn-supprimer-final attente" aria-hidden="true">Supprimer</span>
            <button type="submit" class="btn-supprimer-final confirmer">Supprimer</button>
        </div>
    </form>
</div>

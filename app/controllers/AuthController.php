<?php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Journal.php';

class AuthController
{
    // rôle de la base => nom du rôle utilisé dans le site (navbar, droits d'accès)
    const ROLES = [
        'Administrateur' => 'admin',
        'Enseignant-chercheur' => 'enseignant',
        'Participant' => 'participant',
    ];

    // page à ouvrir après la connexion, selon le rôle
    const PAGES_ACCUEIL = [
        'admin' => 'accueil-admin',
        'enseignant' => 'dashboard',
        'participant' => 'accueil-participant',
    ];

    public function connexion()
    {
        // déjà connecté : pas besoin de revoir le formulaire
        if (isset($_SESSION['id_utilisateur'])) {
            $this->allerAccueil();
        }

        $erreur = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $motDePasse = $_POST['mot_de_passe'] ?? '';
            $ip = $_SERVER['REMOTE_ADDR'];

            $utilisateur = Utilisateur::getParEmail($email);

            // même message que l'e-mail soit inconnu ou le mot de passe faux :
            // on ne donne pas d'indice à quelqu'un qui essaie de deviner les comptes
            if ($utilisateur == false) {
                Journal::ajouter($ip, null, 'Identifiant inconnu');
                $erreur = 'Adresse e-mail ou mot de passe incorrect.';
            } elseif (!password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
                Journal::ajouter($ip, $utilisateur['id_utilisateur'], 'Mot de passe incorrect');
                $erreur = 'Adresse e-mail ou mot de passe incorrect.';
            } elseif ($utilisateur['statut_compte'] != 'actif') {
                Journal::ajouter($ip, $utilisateur['id_utilisateur'], 'Compte désactivé');
                $erreur = 'Ce compte est désactivé.';
            } else {
                $role = $this->choisirRole(Utilisateur::getRoles($utilisateur['id_utilisateur']));

                if ($role == null) {
                    Journal::ajouter($ip, $utilisateur['id_utilisateur'], 'Aucun rôle');
                    $erreur = 'Aucun rôle n\'est associé à ce compte.';
                } else {
                    // nouvel identifiant de session : protège contre le vol de session
                    session_regenerate_id(true);

                    $_SESSION['id_utilisateur'] = $utilisateur['id_utilisateur'];
                    $_SESSION['nom'] = $utilisateur['nom'];
                    $_SESSION['prenom'] = $utilisateur['prenom'];
                    $_SESSION['role'] = $role;
                    $_SESSION['id_log'] = Journal::ajouter($ip, $utilisateur['id_utilisateur'], null);

                    $this->allerAccueil();
                }
            }
        }

        require __DIR__ . '/../views/page_en_commun/connexion.php';
    }

    public function deconnexion()
    {
        if (isset($_SESSION['id_log'])) {
            Journal::terminer($_SESSION['id_log']);
        }

        // on vide la session puis on la supprime
        $_SESSION = [];
        session_destroy();

        header('Location: ' . BASE_URL . '/index.php?page=connexion');
        exit;
    }

    // un utilisateur peut avoir plusieurs rôles (ex : enseignant et participant)
    // on garde le plus important : administrateur, puis enseignant, puis participant
    private function choisirRole($rolesBase)
    {
        foreach (self::ROLES as $libelle => $role) {
            if (in_array($libelle, $rolesBase)) {
                return $role;
            }
        }

        return null;
    }

    private function allerAccueil()
    {
        header('Location: ' . BASE_URL . '/index.php?page=' . self::PAGES_ACCUEIL[$_SESSION['role']]);
        exit;
    }
}
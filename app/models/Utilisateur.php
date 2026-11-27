<?php

require_once __DIR__ . '/BaseDeDonnees.php';

class Utilisateur
{
    // renvoie le nom et le prénom d'un utilisateur
    public static function getParId($idUtilisateur)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('SELECT id_utilisateur, nom, prenom FROM UTILISATEUR WHERE id_utilisateur = :id');
        $requete->execute(['id' => $idUtilisateur]);

        return $requete->fetch();
    }

    // utilisé à la connexion : renvoie aussi le mot de passe (haché) et l'état du compte
    // false si aucun compte n'a cet e-mail
    public static function getParEmail($email)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('
            SELECT id_utilisateur, nom, prenom, mot_de_passe, statut_compte
            FROM UTILISATEUR
            WHERE email = :email
        ');
        $requete->execute(['email' => $email]);

        return $requete->fetch();
    }

    // renvoie la liste des rôles d'un utilisateur, par exemple ['Enseignant-chercheur', 'Participant']
    public static function getRoles($idUtilisateur)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('
            SELECT r.libelle_role
            FROM POSSEDER p
            JOIN ROLE r ON r.id_role = p.id_role
            WHERE p.id_utilisateur = :id
        ');
        $requete->execute(['id' => $idUtilisateur]);

        // FETCH_COLUMN : on récupère directement les valeurs de la colonne, pas des tableaux
        return $requete->fetchAll(PDO::FETCH_COLUMN);
    }
}
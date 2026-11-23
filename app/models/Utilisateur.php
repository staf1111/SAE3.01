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
}
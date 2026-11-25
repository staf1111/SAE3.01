<?php

require_once __DIR__ . '/BaseDeDonnees.php';

// table JOURNAL : historique des connexions, consulté par l'administrateur
class Journal
{
    // enregistre une tentative de connexion et renvoie son id
    // $idUtilisateur vaut null si l'e-mail n'existe pas
    // $erreur vaut null si la connexion a réussi
    public static function ajouter($adresseIp, $idUtilisateur, $erreur)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('
            INSERT INTO JOURNAL (adresse_ip, id_utilisateur, erreurs_connexion)
            VALUES (:ip, :utilisateur, :erreur)
        ');
        $requete->execute(['ip' => $adresseIp, 'utilisateur' => $idUtilisateur, 'erreur' => $erreur]);

        return $bdd->lastInsertId();
    }

    // note l'heure de déconnexion
    public static function terminer($idLog)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('UPDATE JOURNAL SET date_fin_connexion = NOW() WHERE id_log = :id');
        $requete->execute(['id' => $idLog]);
    }
}
<?php

// Connexion à la base de données, partagée par tous les modèles
class BaseDeDonnees
{
    private static $connexion = null;

    public static function getConnexion()
    {
        // on ne se connecte qu'une seule fois par page
        if (self::$connexion == null) {
            $hote = 'localhost';
            $base = 'sae';
            $utilisateur = 'root';
            $motDePasse = '';

            self::$connexion = new PDO('mysql:host=' . $hote . ';dbname=' . $base . ';charset=utf8mb4', $utilisateur, $motDePasse);

            // une erreur SQL arrête le script avec un message au lieu d'être ignorée
            self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // chaque ligne est un tableau avec le nom des colonnes : $ligne['nom']
            self::$connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return self::$connexion;
    }
}
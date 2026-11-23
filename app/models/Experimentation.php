<?php

require_once __DIR__ . '/BaseDeDonnees.php';

class Experimentation
{
    // libellé et couleur affichés pour chaque statut de la base
    const STATUTS = [
        'ouverte' => ['libelle' => 'En cours', 'couleur' => 'green'],
        'brouillon' => ['libelle' => 'Brouillon', 'couleur' => 'grey'],
        'clôturée' => ['libelle' => 'Clôturée', 'couleur' => 'yellow'],
        'archivée' => ['libelle' => 'Archivée', 'couleur' => 'grey'],
    ];

    // expérimentations dont l'utilisateur est responsable, de la plus récente à la plus ancienne
    // pour chacune on calcule aussi :
    // - nb_inscrits : inscriptions en attente ou validées (pas les refusées)
    // - capacite : total des places de tous ses créneaux
    // - prochain_creneau : date du premier créneau qui n'a pas encore commencé
    public static function getParResponsable($idResponsable)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare("
            SELECT e.id_experimentation, e.titre, e.statut_experimentation,
                (SELECT COUNT(*) FROM INSCRIPTION i
                 WHERE i.id_experimentation = e.id_experimentation
                 AND i.statut_inscription <> 'refusée') AS nb_inscrits,
                (SELECT SUM(c.capacite_maximale) FROM CRENEAU c
                 WHERE c.id_experimentation = e.id_experimentation) AS capacite,
                (SELECT MIN(c.date_heure_debut) FROM CRENEAU c
                 WHERE c.id_experimentation = e.id_experimentation
                 AND c.date_heure_debut > NOW()) AS prochain_creneau
            FROM EXPERIMENTATION e
            WHERE e.id_utilisateur = :id
            ORDER BY e.date_creation DESC
        ");
        $requete->execute(['id' => $idResponsable]);

        return $requete->fetchAll();
    }

    // renvoie toutes les informations d'une expérimentation, si elle appartient bien à ce responsable
    // (false sinon, par exemple si quelqu'un change l'id dans l'URL)
    public static function getParId($idExperimentation, $idResponsable)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('
            SELECT e.*, tr.libelle_retrib, eq.nom_equipe, m.titre_modele,
                (SELECT COUNT(*) FROM CRENEAU c
                 WHERE c.id_experimentation = e.id_experimentation) AS nb_creneaux,
                (SELECT COUNT(*) FROM INSCRIPTION i
                 WHERE i.id_experimentation = e.id_experimentation) AS nb_inscriptions
            FROM EXPERIMENTATION e
            JOIN TYPE_RETRIBUTION tr ON tr.id_type_retrib = e.id_type_retrib
            JOIN EQUIPE eq ON eq.id_equipe = e.id_equipe
            LEFT JOIN MODELE m ON m.id_modele = e.id_modele
            WHERE e.id_experimentation = :id AND e.id_utilisateur = :responsable
        ');
        $requete->execute(['id' => $idExperimentation, 'responsable' => $idResponsable]);

        return $requete->fetch();
    }

    public static function changerStatut($idExperimentation, $nouveauStatut)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('UPDATE EXPERIMENTATION SET statut_experimentation = :statut WHERE id_experimentation = :id');
        $requete->execute(['statut' => $nouveauStatut, 'id' => $idExperimentation]);
    }
}
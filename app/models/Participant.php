<?php

require_once __DIR__ . '/BaseDeDonnees.php';

// requêtes de l'espace participant
class Participant
{
    // expérimentations ouvertes auxquelles le participant n'est pas encore inscrit
    public static function getExperimentationsOuvertes($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('
            SELECT id_experimentation, titre, description_experimentation, duree_session
            FROM v_experimentations_ouvertes
            WHERE id_experimentation NOT IN (
                SELECT id_experimentation FROM INSCRIPTION WHERE id_utilisateur = :id
            )
            ORDER BY date_debut
        ');
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchAll();
    }

    // créneaux à venir d'une expérimentation, avec le nombre de places restantes
    public static function getCreneauxAVenir($idExperimentation)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('
            SELECT id_creneau, date_heure_debut, places_restantes
            FROM v_remplissage_creneaux
            WHERE id_experimentation = :id AND date_heure_debut > NOW()
            ORDER BY date_heure_debut
        ');
        $requete->execute(['id' => $idExperimentation]);

        return $requete->fetchAll();
    }

    // créneaux à venir du participant (choisis ou déjà validés par le responsable)
    public static function getProchainsCreneaux($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare("
            SELECT titre, date_heure_debut, date_heure_fin
            FROM v_inscriptions_participant
            WHERE id_utilisateur = :id
            AND date_heure_debut > NOW()
            AND statut_choix IN ('choisi', 'validé')
            ORDER BY date_heure_debut
        ");
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchAll();
    }

    // les 5 dernières séances passées (sauf celles annulées)
    public static function getHistorique($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare("
            SELECT titre, questionnaire, date_heure_debut, statut_choix
            FROM v_inscriptions_participant
            WHERE id_utilisateur = :id
            AND date_heure_debut <= NOW()
            AND statut_choix <> 'annulé'
            ORDER BY date_heure_debut DESC
            LIMIT 5
        ");
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchAll();
    }

    // demande d'inscription : la procédure vérifie tout (compte actif, profil complet, consentement,
    // expérimentation ouverte, pas de double inscription...) et lance une erreur sinon
    public static function inscrire($idParticipant, $idExperimentation, $consentement)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('CALL ps_s_inscrire(:participant, :experimentation, :consentement)');
        $requete->execute([
            'participant' => $idParticipant,
            'experimentation' => $idExperimentation,
            'consentement' => $consentement,
        ]);

        // la procédure renvoie un résultat (id et message) : on le libère avant la requête suivante
        $requete->closeCursor();
    }

    // rendez-vous à venir du participant (créneaux choisis ou validés)
    public static function getRendezVous($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare("
            SELECT pc.id_part_creneau, pc.statut_choix, pc.id_inscription,
                c.id_creneau, c.date_heure_debut, c.date_heure_fin,
                e.id_experimentation, e.titre
            FROM PART_CRENEAU pc
            JOIN INSCRIPTION i ON i.id_inscription = pc.id_inscription
            JOIN CRENEAU c ON c.id_creneau = pc.id_creneau
            JOIN EXPERIMENTATION e ON e.id_experimentation = c.id_experimentation
            WHERE i.id_utilisateur = :id
            AND c.date_heure_debut > NOW()
            AND pc.statut_choix IN ('choisi', 'validé')
            ORDER BY c.date_heure_debut
        ");
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchAll();
    }

    // inscriptions validées sur des expérimentations ouvertes
    // nb_choisis = créneaux déjà pris (sauf annulés), à comparer avec nombre_sessions
    public static function getInscriptionsValidees($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare("
            SELECT i.id_inscription, e.id_experimentation, e.titre, e.nombre_sessions,
                (SELECT COUNT(*) FROM PART_CRENEAU pc
                 WHERE pc.id_inscription = i.id_inscription
                 AND pc.statut_choix <> 'annulé') AS nb_choisis
            FROM INSCRIPTION i
            JOIN EXPERIMENTATION e ON e.id_experimentation = i.id_experimentation
            WHERE i.id_utilisateur = :id
            AND i.statut_inscription = 'validée'
            AND e.statut_experimentation = 'ouverte'
            ORDER BY e.titre
        ");
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchAll();
    }

    // créneaux déjà liés à une inscription, avec leur statut (pour savoir lesquels griser)
    public static function getChoixInscription($idInscription)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('SELECT id_creneau, statut_choix FROM PART_CRENEAU WHERE id_inscription = :id');
        $requete->execute(['id' => $idInscription]);

        return $requete->fetchAll();
    }

    // la procédure vérifie : inscription validée, expérimentation ouverte, créneau de la bonne expérimentation,
    // pas passé, pas déjà choisi, nombre de séances pas dépassé, pas complet, pas de chevauchement
    // (un créneau annulé peut être repris)
    public static function choisirCreneau($idInscription, $idCreneau)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('CALL ps_choisir_creneau(:inscription, :creneau)');
        $requete->execute(['inscription' => $idInscription, 'creneau' => $idCreneau]);
        $requete->closeCursor();
    }

    // la procédure vérifie que le créneau appartient bien au participant et que le délai d'annulation est respecté
    public static function annulerCreneau($idParticipant, $idInscription, $idCreneau)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('CALL ps_annuler_creneau(:participant, :inscription, :creneau)');
        $requete->execute(['participant' => $idParticipant, 'inscription' => $idInscription, 'creneau' => $idCreneau]);
        $requete->closeCursor();
    }

        // ---------- page Expérimentations ----------

    // toutes les inscriptions du participant, avec l'état de l'expérimentation,
    // le nombre de séances faites et la date du prochain créneau réservé
    public static function getMesExperimentations($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare("
            SELECT i.id_inscription, i.statut_inscription,
                e.titre, e.statut_experimentation, e.nombre_sessions,
                (SELECT COUNT(*) FROM PART_CRENEAU pc
                 WHERE pc.id_inscription = i.id_inscription
                 AND pc.statut_choix = 'présent') AS nb_presences,
                (SELECT MIN(c.date_heure_debut)
                 FROM PART_CRENEAU pc
                 JOIN CRENEAU c ON c.id_creneau = pc.id_creneau
                 WHERE pc.id_inscription = i.id_inscription
                 AND pc.statut_choix IN ('choisi', 'validé')
                 AND c.date_heure_debut > NOW()) AS prochain_creneau
            FROM INSCRIPTION i
            JOIN EXPERIMENTATION e ON e.id_experimentation = i.id_experimentation
            WHERE i.id_utilisateur = :id
            ORDER BY i.date_inscription DESC
        ");
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchAll();
    }

    // ---------- page Historique ----------

    // séances passées et créneaux annulés, du plus récent au plus ancien
    public static function getParticipations($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare("
            SELECT e.titre, c.date_heure_debut, pc.statut_choix
            FROM PART_CRENEAU pc
            JOIN INSCRIPTION i ON i.id_inscription = pc.id_inscription
            JOIN CRENEAU c ON c.id_creneau = pc.id_creneau
            JOIN EXPERIMENTATION e ON e.id_experimentation = c.id_experimentation
            WHERE i.id_utilisateur = :id
            AND (c.date_heure_debut <= NOW() OR pc.statut_choix = 'annulé')
            ORDER BY c.date_heure_debut DESC
        ");
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchAll();
    }

    // nombre de séances où le participant était présent et leur durée totale en minutes
    public static function getStatsPresences($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare("
            SELECT COUNT(*) AS nb_presences,
                COALESCE(SUM(TIMESTAMPDIFF(MINUTE, c.date_heure_debut, c.date_heure_fin)), 0) AS minutes
            FROM PART_CRENEAU pc
            JOIN INSCRIPTION i ON i.id_inscription = pc.id_inscription
            JOIN CRENEAU c ON c.id_creneau = pc.id_creneau
            WHERE i.id_utilisateur = :id
            AND pc.statut_choix = 'présent'
        ");
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetch();
    }

    // ---------- page Mon profil ----------

    public static function getProfil($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('
            SELECT nom, prenom, email, date_naissance, genre, porte_lunettes
            FROM UTILISATEUR
            WHERE id_utilisateur = :id
        ');
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetch();
    }

    public static function getToutesLesLangues()
    {
        $bdd = BaseDeDonnees::getConnexion();

        return $bdd->query('SELECT id_langue, libelle_langue FROM LANGUE ORDER BY libelle_langue')->fetchAll();
    }

    // id des langues parlées par le participant, par exemple [1, 2]
    public static function getLanguesParlees($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('SELECT id_langue FROM PARLER WHERE id_utilisateur = :id');
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchAll(PDO::FETCH_COLUMN);
    }

    // date du dernier consentement signé (à l'inscription à une expérimentation), null si aucun
    public static function getDernierConsentement($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('SELECT MAX(date_consentement) FROM INSCRIPTION WHERE id_utilisateur = :id');
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchColumn();
    }

    // met à jour les informations personnelles et remplace la liste des langues
    // $donnees contient : nom, prenom, email, date_naissance, genre, porte_lunettes
    public static function modifierProfil($idParticipant, $donnees, $langues)
    {
        $bdd = BaseDeDonnees::getConnexion();

        // tout ou rien : si une étape échoue, rien n'est modifié
        $bdd->beginTransaction();

        try {
            $requete = $bdd->prepare('
                UPDATE UTILISATEUR
                SET nom = :nom, prenom = :prenom, email = :email,
                    date_naissance = :naissance, genre = :genre, porte_lunettes = :lunettes
                WHERE id_utilisateur = :id
            ');
            $requete->execute([
                'nom' => $donnees['nom'],
                'prenom' => $donnees['prenom'],
                'email' => $donnees['email'],
                'naissance' => $donnees['date_naissance'],
                'genre' => $donnees['genre'],
                'lunettes' => $donnees['porte_lunettes'],
                'id' => $idParticipant,
            ]);

            // on efface les anciennes langues puis on ajoute celles cochées
            $requete = $bdd->prepare('DELETE FROM PARLER WHERE id_utilisateur = :id');
            $requete->execute(['id' => $idParticipant]);

            $requete = $bdd->prepare('INSERT INTO PARLER (id_utilisateur, id_langue) VALUES (:id, :langue)');
            foreach ($langues as $idLangue) {
                $requete->execute(['id' => $idParticipant, 'langue' => $idLangue]);
            }

            $bdd->commit();
        } catch (PDOException $e) {
            $bdd->rollBack();
            throw $e;
        }
    }

    // vrai si une demande de suppression du compte attend déjà d'être traitée
    public static function aDemandeSuppression($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare("
            SELECT COUNT(*) FROM DEMANDE_SUPPRESSION
            WHERE id_utilisateur_demandeur = :id AND statut_demande = 'en attente'
        ");
        $requete->execute(['id' => $idParticipant]);

        return $requete->fetchColumn() > 0;
    }

    // la demande est ensuite traitée par un administrateur (procédure ps_traiter_demande_suppression)
    public static function demanderSuppression($idParticipant)
    {
        $bdd = BaseDeDonnees::getConnexion();
        $requete = $bdd->prepare('INSERT INTO DEMANDE_SUPPRESSION (id_utilisateur_demandeur) VALUES (:id)');
        $requete->execute(['id' => $idParticipant]);
    }
}
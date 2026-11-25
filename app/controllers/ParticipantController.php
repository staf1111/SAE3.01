<?php

require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Participant.php';

class ParticipantController
{
    // pour afficher les dates en français
    const JOURS = ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'];
    const MOIS = ['JANV.', 'FÉVR.', 'MARS', 'AVR.', 'MAI', 'JUIN', 'JUIL.', 'AOÛT', 'SEPT.', 'OCT.', 'NOV.', 'DÉC.'];

    // valeur enregistrée dans la base => texte affiché dans la liste du profil
    const GENRES = [
        'femme' => 'Femme',
        'homme' => 'Homme',
        'autre' => 'Autre',
        'non précisé' => 'Ne souhaite pas répondre',
    ];

    // durées proposées dans le filtre de l'accueil (en minutes)
    const DUREES = [15, 30, 45, 60];

    public function accueil()
    {
        $idParticipant = $_SESSION['id_utilisateur'];
        $message = $this->prendreMessage();

        // formulaire de la pop-up "S'inscrire"
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idExperimentation = (int) ($_POST['projet_id'] ?? 0);

            // la case n'est envoyée par le navigateur que si elle est cochée
            if (isset($_POST['consentement'])) {
                $consentement = 1;
            } else {
                $consentement = 0;
            }

            try {
                Participant::inscrire($idParticipant, $idExperimentation, $consentement);

                // on recharge la page en GET pour qu'un F5 ne renvoie pas la demande
                header('Location: ' . BASE_URL . '/index.php?page=accueil-participant&demande=envoyee');
                exit;
            } catch (PDOException $e) {
                // 45000 = erreur prévue par la procédure, son message peut être affiché tel quel
                if ($e->getCode() == '45000') {
                    $message = ['type' => 'erreur', 'texte' => $e->errorInfo[2]];
                } else {
                    $message = ['type' => 'erreur', 'texte' => 'La demande n\'a pas pu être envoyée.'];
                }
            }
        }

        // affiche la 2e pop-up "Demande envoyée"
        $inscriptionEnvoyee = isset($_GET['demande']);

        $participant = Utilisateur::getParId($idParticipant);
        $langue = 'Français';

        // expérimentations ouvertes, avec leurs créneaux à venir
        $projets = [];
        foreach (Participant::getExperimentationsOuvertes($idParticipant) as $exp) {
            $creneaux = [];
            $placeLibre = false;
            foreach (Participant::getCreneauxAVenir($exp['id_experimentation']) as $cr) {
                $creneaux[] = [
                    'id' => $cr['id_creneau'],
                    'libelle' => $this->dateEnTexte($cr['date_heure_debut']),
                    'places' => $cr['places_restantes'],
                ];
                if ($cr['places_restantes'] > 0) {
                    $placeLibre = true;
                }
            }

            if (count($creneaux) > 0) {
                $prochainCreneau = $creneaux[0]['libelle'];
            } else {
                $prochainCreneau = 'aucun pour le moment';
            }

            $projets[] = [
                'id' => $exp['id_experimentation'],
                'titre' => $exp['titre'],
                'description' => $exp['description_experimentation'] ?? '',
                'duree' => (int) $exp['duree_session'],
                'creneau' => $prochainCreneau,
                'creneaux' => $creneaux,
                'place_libre' => $placeLibre,
            ];
        }

        // filtres (dans l'adresse) : &duree=30 pour la durée max, &dispo=1 pour les créneaux libres
        $dureeMax = (int) ($_GET['duree'] ?? 0);
        if (!in_array($dureeMax, self::DUREES)) {
            $dureeMax = 0;
        }
        $seulementDispo = isset($_GET['dispo']);

        $nbProjets = count($projets);
        $projetsGardes = [];
        foreach ($projets as $projet) {
            if ($dureeMax > 0 && $projet['duree'] > $dureeMax) {
                continue;
            }
            if ($seulementDispo && !$projet['place_libre']) {
                continue;
            }
            $projetsGardes[] = $projet;
        }
        $projets = $projetsGardes;

        // quel bouton de filtre est coloré
        if ($dureeMax == 0 && !$seulementDispo) {
            $filtreActif = 'toutes';
        } elseif ($dureeMax == 30 && !$seulementDispo) {
            $filtreActif = '30min';
        } else {
            $filtreActif = 'filtres';
        }
        $durees = self::DUREES;

        $prochainsCreneaux = [];
        foreach (Participant::getProchainsCreneaux($idParticipant) as $cr) {
            $debut = strtotime($cr['date_heure_debut']);
            $prochainsCreneaux[] = [
                'jour' => date('d', $debut),
                'mois' => self::MOIS[date('n', $debut) - 1],
                'titre' => $cr['titre'],
                'heure' => date('H:i', $debut) . ' – ' . date('H:i', strtotime($cr['date_heure_fin'])),
            ];
        }

        $currentPage = 'accueil';
        $contentView = __DIR__ . '/../views/participant/Accueil.php';

        require __DIR__ . '/../views/layout.php';
    }

    public function experimentation()
    {
        $idParticipant = $_SESSION['id_utilisateur'];
        $message = $this->prendreMessage();

        $participant = Utilisateur::getParId($idParticipant);
        $langue = 'Français';

        $experimentations = [];
        foreach (Participant::getMesExperimentations($idParticipant) as $exp) {
            // statut vu par le participant (les classes CSS sont celles de experimentation.css)
            if ($exp['statut_inscription'] == 'en attente') {
                $statut = 'En attente';
                $statutClasse = 'statut-brouillon';
            } elseif ($exp['statut_inscription'] == 'refusée') {
                $statut = 'Refusée';
                $statutClasse = 'statut-archive';
            } elseif ($exp['statut_experimentation'] == 'ouverte') {
                $statut = 'En cours';
                $statutClasse = 'statut-en-cours';
            } else {
                $statut = 'Terminée';
                $statutClasse = 'statut-archive';
            }

            // progression seulement pour une inscription acceptée
            if ($exp['statut_inscription'] == 'validée') {
                $progression = $exp['nb_presences'] . ' / ' . $exp['nombre_sessions'] . ' séance(s)';
            } else {
                $progression = '';
            }

            if ($exp['prochain_creneau'] == null) {
                $creneau = '';
            } else {
                $creneau = $this->dateEnTexte($exp['prochain_creneau']);
            }

            $experimentations[] = [
                'titre' => $exp['titre'],
                'statut' => $statut,
                'statut_classe' => $statutClasse,
                'progression' => $progression,
                'creneau' => $creneau,
            ];
        }

        $currentPage = 'experimentations';
        $contentView = __DIR__ . '/../views/participant/Experimentation.php';

        require __DIR__ . '/../views/layout.php';
    }

    public function creneaux()
    {
        $idParticipant = $_SESSION['id_utilisateur'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->traiterFormulaireCreneaux($idParticipant);
        }

        $message = $this->prendreMessage();
        $langue = 'Français';

        // rendez-vous à venir
        $creneauxAVenir = [];
        foreach (Participant::getRendezVous($idParticipant) as $rdv) {
            $debut = strtotime($rdv['date_heure_debut']);

            if ($rdv['statut_choix'] == 'validé') {
                $statut = 'Confirmé';
                $statutClasse = 'statut-confirme';
            } else {
                $statut = 'En attente';
                $statutClasse = 'statut-attente';
            }

            $creneauxAVenir[] = [
                'id' => $rdv['id_part_creneau'],
                'id_inscription' => $rdv['id_inscription'],
                'id_creneau' => $rdv['id_creneau'],
                'titre' => $rdv['titre'],
                'jour' => date('d', $debut),
                'mois' => self::MOIS[date('n', $debut) - 1],
                'debut' => date('H:i', $debut),
                'fin' => date('H:i', strtotime($rdv['date_heure_fin'])),
                'statut' => $statut,
                'statut_classe' => $statutClasse,
            ];
        }

        // inscriptions validées pour lesquelles il reste des séances à réserver
        $aChoisir = [];
        foreach (Participant::getInscriptionsValidees($idParticipant) as $inscription) {
            $restantes = $inscription['nombre_sessions'] - $inscription['nb_choisis'];
            if ($restantes > 0) {
                $inscription['restantes'] = $restantes;
                $aChoisir[] = $inscription;
            }
        }

        // panneau du bas : ouvert avec ?inscription=<id> (choisir) ou ?changer=<id du rendez-vous>
        $panneau = null;

        if (isset($_GET['changer'])) {
            foreach ($creneauxAVenir as $rdv) {
                if ($rdv['id'] == $_GET['changer']) {
                    $panneau = [
                        'mode' => 'changer',
                        'titre' => $rdv['titre'],
                        'id_inscription' => $rdv['id_inscription'],
                        'id_creneau_actuel' => $rdv['id_creneau'],
                        'max' => 1,
                    ];
                }
            }
        } elseif (isset($_GET['inscription'])) {
            foreach ($aChoisir as $inscription) {
                if ($inscription['id_inscription'] == $_GET['inscription']) {
                    $panneau = [
                        'mode' => 'choisir',
                        'titre' => $inscription['titre'],
                        'id_inscription' => $inscription['id_inscription'],
                        'id_creneau_actuel' => 0,
                        'max' => $inscription['restantes'],
                    ];
                }
            }
        }

        if ($panneau != null) {
            $panneau['creneaux'] = $this->creneauxDuPanneau($panneau['id_inscription']);
        }

        $currentPage = 'creneaux';
        $contentView = __DIR__ . '/../views/participant/Creneaux.php';

        require __DIR__ . '/../views/layout.php';
    }

    public function historique()
    {
        $idParticipant = $_SESSION['id_utilisateur'];
        $message = $this->prendreMessage();
        $langue = 'Français';

        $stats = Participant::getStatsPresences($idParticipant);

        // ex : 95 minutes => "1 h 35"
        $heures = intdiv($stats['minutes'], 60);
        $minutes = $stats['minutes'] % 60;
        if ($heures > 0) {
            $tempsTotal = $heures . ' h ' . str_pad($minutes, 2, '0', STR_PAD_LEFT);
        } else {
            $tempsTotal = $minutes . ' min';
        }

        $statsHistorique = [
            'nb_participations' => $stats['nb_presences'],
            'temps_total' => $tempsTotal,
        ];

        // texte et classe CSS (historique.css) pour chaque statut de la base
        $statuts = [
            'présent' => ['texte' => 'Présent', 'classe' => 'statut-valide'],
            'absent' => ['texte' => 'Absent', 'classe' => 'statut-absent'],
            'annulé' => ['texte' => 'Annulé', 'classe' => 'statut-annule'],
            // séance passée mais présence pas encore notée par le responsable
            'choisi' => ['texte' => 'Non renseigné', 'classe' => 'statut-annule'],
            'validé' => ['texte' => 'Non renseigné', 'classe' => 'statut-annule'],
        ];

        $participations = [];
        foreach (Participant::getParticipations($idParticipant) as $p) {
            $participations[] = [
                'titre' => $p['titre'],
                'date' => date('d/m/Y', strtotime($p['date_heure_debut'])),
                'statut' => $statuts[$p['statut_choix']]['texte'],
                'statut_classe' => $statuts[$p['statut_choix']]['classe'],
            ];
        }

        $currentPage = 'historique';
        $contentView = __DIR__ . '/../views/participant/Historique.php';

        require __DIR__ . '/../views/layout.php';
    }

    public function profil()
    {
        $idParticipant = $_SESSION['id_utilisateur'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['supprimer_compte'])) {
                $this->demanderSuppression($idParticipant);
            } else {
                $this->enregistrerProfil($idParticipant);
            }
        }

        $message = $this->prendreMessage();
        $langue = 'Français';

        $utilisateur = Participant::getProfil($idParticipant);
        $languesParlees = Participant::getLanguesParlees($idParticipant);
        $stats = Participant::getStatsPresences($idParticipant);

        // profil complété : 4 informations utiles aux expérimentations
        $remplis = 0;
        if ($utilisateur['date_naissance'] != null) {
            $remplis++;
        }
        if ($utilisateur['genre'] != null) {
            $remplis++;
        }
        if ($utilisateur['porte_lunettes'] !== null) {
            $remplis++;
        }
        if (count($languesParlees) > 0) {
            $remplis++;
        }

        // 1, 0 ou null (selon la version de PHP, la base peut renvoyer "1" en texte)
        if ($utilisateur['porte_lunettes'] === null) {
            $lunettes = null;
        } else {
            $lunettes = (int) $utilisateur['porte_lunettes'];
        }

        $profil = [
            'prenom' => $utilisateur['prenom'],
            'nom' => $utilisateur['nom'],
            'email' => $utilisateur['email'],
            'naissance' => $utilisateur['date_naissance'] ?? '',
            'genre' => $utilisateur['genre'],
            'lunettes' => $lunettes,
            'langues' => $languesParlees,
            'nb_participations' => $stats['nb_presences'],
            'profil_complete' => $remplis / 4 * 100,
        ];

        $genres = self::GENRES;
        $toutesLesLangues = Participant::getToutesLesLangues();

        $dateConsentement = Participant::getDernierConsentement($idParticipant);
        if ($dateConsentement == null) {
            $consentement = null;
        } else {
            $consentement = date('d/m/Y', strtotime($dateConsentement));
        }

        $suppressionDemandee = Participant::aDemandeSuppression($idParticipant);

        $currentPage = 'profil';
        $contentView = __DIR__ . '/../views/participant/Profil.php';

        require __DIR__ . '/../views/layout.php';
    }

    // ex : "Mer. 02/12 à 14:00"
    private function dateEnTexte($date)
    {
        $moment = strtotime($date);

        return self::JOURS[date('w', $moment)] . ' ' . date('d/m', $moment) . ' à ' . date('H:i', $moment);
    }

    // boutons "Annuler" et "Réserver" de la page Créneaux
    private function traiterFormulaireCreneaux($idParticipant)
    {
        $action = $_POST['action'] ?? '';
        $idInscription = (int) ($_POST['id_inscription'] ?? 0);

        try {
            if ($action == 'annuler') {
                Participant::annulerCreneau($idParticipant, $idInscription, (int) ($_POST['id_creneau'] ?? 0));
                $this->rediriger('creneaux-participant', 'succes', 'Le créneau a été annulé.');
            }

            if ($action == 'reserver') {
                // la procédure ps_choisir_creneau ne vérifie pas à qui est l'inscription :
                // on vérifie donc ici qu'elle appartient bien au participant connecté
                $inscription = null;
                foreach (Participant::getInscriptionsValidees($idParticipant) as $ligne) {
                    if ($ligne['id_inscription'] == $idInscription) {
                        $inscription = $ligne;
                    }
                }
                if ($inscription == null) {
                    $this->rediriger('creneaux-participant', 'erreur', 'Inscription introuvable.');
                }

                $choix = $_POST['creneaux'] ?? [];
                $idCreneauActuel = (int) ($_POST['id_creneau_actuel'] ?? 0);

                if (count($choix) == 0) {
                    $this->rediriger('creneaux-participant', 'erreur', 'Sélectionnez au moins un créneau.');
                }

                $bdd = BaseDeDonnees::getConnexion();

                if ($idCreneauActuel > 0) {
                    // changement : un seul nouveau créneau, qui remplace l'ancien
                    if (count($choix) != 1) {
                        $this->rediriger('creneaux-participant', 'erreur', 'Choisissez un seul créneau pour remplacer l\'ancien.');
                    }

                    // on annule l'ancien d'abord : sinon le nouveau serait refusé s'il chevauche l'ancien
                    // tout ou rien : si le nouveau est refusé (complet...), l'ancien n'est pas annulé
                    $bdd->beginTransaction();
                    Participant::annulerCreneau($idParticipant, $idInscription, $idCreneauActuel);
                    Participant::choisirCreneau($idInscription, (int) $choix[0]);
                    $bdd->commit();

                    $this->rediriger('creneaux-participant', 'succes', 'Créneau changé. Le responsable doit valider le nouveau créneau.');
                }

                // tout ou rien : si un des créneaux est refusé (complet, trop de séances...), aucun n'est réservé
                $bdd->beginTransaction();
                foreach ($choix as $idCreneau) {
                    Participant::choisirCreneau($idInscription, (int) $idCreneau);
                }
                $bdd->commit();

                $this->rediriger('creneaux-participant', 'succes', 'Demande envoyée. Le responsable doit valider vos créneaux.');
            }
        } catch (PDOException $e) {
            $bdd = BaseDeDonnees::getConnexion();
            if ($bdd->inTransaction()) {
                $bdd->rollBack();
            }

            // 45000 = erreur prévue par une procédure, son message peut être affiché tel quel
            if ($e->getCode() == '45000') {
                $this->rediriger('creneaux-participant', 'erreur', $e->errorInfo[2]);
            }
            $this->rediriger('creneaux-participant', 'erreur', 'L\'action n\'a pas pu être effectuée.');
        }
    }

    // créneaux à venir de l'expérimentation, avec leur état pour ce participant :
    // reserve (déjà à lui), complet, ou libre
    private function creneauxDuPanneau($idInscription)
    {
        // on retrouve l'expérimentation et les créneaux déjà liés à cette inscription
        $idExperimentation = null;
        foreach (Participant::getInscriptionsValidees($_SESSION['id_utilisateur']) as $ligne) {
            if ($ligne['id_inscription'] == $idInscription) {
                $idExperimentation = $ligne['id_experimentation'];
            }
        }

        // créneaux déjà réservés par le participant (un créneau annulé peut être repris)
        $dejaPris = [];
        foreach (Participant::getChoixInscription($idInscription) as $choix) {
            if ($choix['statut_choix'] != 'annulé') {
                $dejaPris[] = $choix['id_creneau'];
            }
        }

        $creneaux = [];
        foreach (Participant::getCreneauxAVenir($idExperimentation) as $cr) {
            if (in_array($cr['id_creneau'], $dejaPris)) {
                $etat = 'reserve';
            } elseif ($cr['places_restantes'] <= 0) {
                $etat = 'complet';
            } else {
                $etat = 'libre';
            }

            $creneaux[] = [
                'id' => $cr['id_creneau'],
                'libelle' => $this->dateEnTexte($cr['date_heure_debut']),
                'etat' => $etat,
            ];
        }

        return $creneaux;
    }

    // bouton "Enregistrer" du profil
    private function enregistrerProfil($idParticipant)
    {
        $donnees = [
            'prenom' => trim($_POST['prenom'] ?? ''),
            'nom' => trim($_POST['nom'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'date_naissance' => $_POST['naissance'] ?? '',
            'genre' => $_POST['genre'] ?? '',
            'porte_lunettes' => $_POST['lunettes'] ?? '',
        ];

        if ($donnees['prenom'] == '' || $donnees['nom'] == '' || mb_strlen($donnees['prenom']) > 50 || mb_strlen($donnees['nom']) > 50) {
            $this->rediriger('profil-participant', 'erreur', 'Le prénom et le nom sont obligatoires (50 caractères maximum).');
        }

        if (!filter_var($donnees['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($donnees['email']) > 100) {
            $this->rediriger('profil-participant', 'erreur', 'L\'adresse e-mail n\'est pas valide.');
        }

        // champs facultatifs : vide => NULL dans la base
        if ($donnees['date_naissance'] == '') {
            $donnees['date_naissance'] = null;
        } else {
            $date = DateTime::createFromFormat('Y-m-d', $donnees['date_naissance']);
            if ($date == false || $donnees['date_naissance'] > date('Y-m-d')) {
                $this->rediriger('profil-participant', 'erreur', 'La date de naissance n\'est pas valide.');
            }
        }

        if (!isset(self::GENRES[$donnees['genre']])) {
            $donnees['genre'] = null;
        }

        if ($donnees['porte_lunettes'] == '1') {
            $donnees['porte_lunettes'] = 1;
        } elseif ($donnees['porte_lunettes'] == '0') {
            $donnees['porte_lunettes'] = 0;
        } else {
            $donnees['porte_lunettes'] = null;
        }

        // id des langues cochées, en nombres
        $langues = [];
        foreach ($_POST['langues'] ?? [] as $idLangue) {
            $langues[] = (int) $idLangue;
        }

        try {
            Participant::modifierProfil($idParticipant, $donnees, $langues);
        } catch (PDOException $e) {
            // 23000 = contrainte non respectée : ici l'e-mail est déjà utilisé par un autre compte
            if ($e->getCode() == '23000') {
                $this->rediriger('profil-participant', 'erreur', 'Cette adresse e-mail est déjà utilisée.');
            }
            $this->rediriger('profil-participant', 'erreur', 'Le profil n\'a pas pu être enregistré.');
        }

        // le nom affiché ailleurs dans le site vient de la session
        $_SESSION['prenom'] = $donnees['prenom'];
        $_SESSION['nom'] = $donnees['nom'];

        $this->rediriger('profil-participant', 'succes', 'Profil enregistré.');
    }

    // bouton "Supprimer mon compte" : crée une demande, traitée ensuite par un administrateur
    private function demanderSuppression($idParticipant)
    {
        if (Participant::aDemandeSuppression($idParticipant)) {
            $this->rediriger('profil-participant', 'erreur', 'Une demande de suppression est déjà en cours.');
        }

        Participant::demanderSuppression($idParticipant);
        $this->rediriger('profil-participant', 'succes', 'Votre demande de suppression a été envoyée à un administrateur.');
    }

    // message laissé avant une redirection, affiché une seule fois
    private function prendreMessage()
    {
        $message = null;
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        return $message;
    }

    private function rediriger($page, $type, $texte)
    {
        $_SESSION['message'] = ['type' => $type, 'texte' => $texte];
        header('Location: ' . BASE_URL . '/index.php?page=' . $page);
        exit;
    }
}
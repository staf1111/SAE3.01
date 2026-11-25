<?php
/*
 * Vue : Mes expérimentations
 *
 * Les données sont préparées par ParticipantController::experimentation() :
 * $participant, $langue et $experimentations (titre, statut, statut_classe, progression, creneau)
 */

/*
 * Filtres : le filtre choisi est dans l'adresse (?filtre=en-cours).
 * Chaque bouton est un lien : au clic la page se recharge avec le bon filtre.
 * "classe" = statut_classe des expérimentations à garder (null = toutes).
 * Les inscriptions refusées ont la classe statut-archive : elles sont rangées avec les terminées.
 */
$filtres = [
    'toutes' => ['label' => 'Toutes', 'classe' => null],
    'en-attente' => ['label' => 'En attente', 'classe' => 'statut-brouillon'],
    'en-cours' => ['label' => 'En cours', 'classe' => 'statut-en-cours'],
    'terminees' => ['label' => 'Terminées', 'classe' => 'statut-archive'],
];

// Filtre demandé ("toutes" si absent ou inconnu)
$filtreActif = $_GET['filtre'] ?? 'toutes';
if (!isset($filtres[$filtreActif])) {
    $filtreActif = 'toutes';
}

// Nombre d'expérimentations pour chaque filtre (le chiffre entre parenthèses)
foreach ($filtres as $cle => $filtre) {
    $filtres[$cle]['nb'] = $filtre['classe'] === null
        ? count($experimentations)
        : count(array_filter($experimentations, fn($e) => $e['statut_classe'] === $filtre['classe']));
}

// Expérimentations à afficher
$classeVoulue = $filtres[$filtreActif]['classe'];
$affichees = $classeVoulue === null
    ? $experimentations
    : array_filter($experimentations, fn($e) => $e['statut_classe'] === $classeVoulue);
?>

<div class="page page-experimentations">

    <header class="page-header">
        <div>
            <h1>Mes expérimentations</h1>
            <p class="page-sous-titre">
                Participant · <?= htmlspecialchars($participant['prenom'] . ' ' . $participant['nom']) ?>
            </p>
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
        </div>
    </header>

    <!-- ========== FILTRES ========== -->
    <div class="filtres">
        <?php foreach ($filtres as $cle => $filtre): ?>
            <!-- la classe "actif" colore le filtre sélectionné -->
            <a class="filtre <?= $cle === $filtreActif ? 'actif' : '' ?>"
               href="<?= BASE_URL ?>/index.php?page=experimentations-participant&amp;filtre=<?= $cle ?>"
               <?= $cle === $filtreActif ? 'aria-current="true"' : '' ?>>
                <?= htmlspecialchars($filtre['label']) ?> (<?= (int) $filtre['nb'] ?>)
            </a>
        <?php endforeach; ?>
    </div>

    <!-- ========== LISTE ========== -->
    <?php if (empty($affichees)): ?>
        <p class="vide">Aucune expérimentation dans cette catégorie.</p>
    <?php else: ?>
        <div class="cartes">
            <?php foreach ($affichees as $exp): ?>
                <article class="carte">
                    <div class="carte-haut">
                        <div class="carte-titre">
                            <span class="carte-icone">
                                <img src="<?= BASE_URL ?>/images/fiole.png" alt="">
                            </span>
                            <h2><?= htmlspecialchars($exp['titre']) ?></h2>
                        </div>
                        <span class="statut <?= htmlspecialchars($exp['statut_classe']) ?>">
                            <?= htmlspecialchars($exp['statut']) ?>
                        </span>
                    </div>

                    <div class="progression">
                        <p class="progression-titre">
                            <img src="<?= BASE_URL ?>/images/stats.png" alt="" class="icone-petite">
                            Progression
                        </p>
                        <p class="progression-valeur"><?= htmlspecialchars($exp['progression'] ?: '—') ?></p>
                    </div>

                    <p class="carte-creneau">
                        <img src="<?= BASE_URL ?>/images/horloge.png" alt="" class="icone-petite">
                        Prochain créneau :
                        <strong><?= htmlspecialchars($exp['creneau'] ?: 'Aucun créneau prévu') ?></strong>
                    </p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

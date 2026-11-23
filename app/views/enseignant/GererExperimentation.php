<?php
$statut = Experimentation::STATUTS[$exp['statut_experimentation']];

if ($exp['description_experimentation'] == null) {
    $description = 'Aucune description.';
} else {
    $description = $exp['description_experimentation'];
}

if ($exp['titre_modele'] == null) {
    $modele = 'Aucun';
} else {
    $modele = $exp['titre_modele'];
}
?>

<p class="sub"><a class="lien" href="<?= BASE_URL ?>/index.php?page=experimentations">← Mes expérimentations</a></p>

<div class="page-head">
  <div>
    <h1>
      <?= htmlspecialchars($exp['titre']) ?>
      <span class="tag tag-<?= $statut['couleur'] ?>"><?= $statut['libelle'] ?></span>
    </h1>
    <p class="sub">
      Du <?= date('d/m/Y', strtotime($exp['date_debut'])) ?> au <?= date('d/m/Y', strtotime($exp['date_fin'])) ?>
      · <?= htmlspecialchars($exp['nom_equipe']) ?>
    </p>
  </div>
</div>

<div class="grid g-main">
  <div class="card">
    <h2>Description</h2>
    <p><?= nl2br(htmlspecialchars($description)) ?></p>
  </div>

  <div class="card">
    <h2>Paramètres</h2>
    <dl class="details">
      <dt>Sessions</dt>
      <dd><?= $exp['nombre_sessions'] ?> par participant</dd>

      <dt>Durée d'une session</dt>
      <dd><?= $exp['duree_session'] ?> min</dd>

      <dt>Rétribution</dt>
      <dd><?= htmlspecialchars(ucfirst($exp['libelle_retrib'])) ?></dd>

      <dt>Modèle d'origine</dt>
      <dd><?= htmlspecialchars($modele) ?></dd>

      <dt>Créée le</dt>
      <dd><?= date('d/m/Y', strtotime($exp['date_creation'])) ?></dd>

      <dt>Créneaux</dt>
      <dd><?= $exp['nb_creneaux'] ?></dd>

      <dt>Inscriptions</dt>
      <dd><?= $exp['nb_inscriptions'] ?></dd>
    </dl>
  </div>
</div>
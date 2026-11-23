<?php
// données en dur en attendant la base de données
$experimentations = [
    ['titre' => 'Perception des couleurs en réalité virtuelle', 'statut' => 'En cours', 'couleur' => 'green', 'inscrits' => 24, 'places' => 30, 'creneau' => 'Auj. 14:00 · Salle B-104'],
    ['titre' => 'Mémoire de travail et bilinguisme', 'statut' => 'En cours', 'couleur' => 'green', 'inscrits' => 22, 'places' => 40, 'creneau' => 'Mer. 10:00 · Salle A-012'],
    ['titre' => 'Temps de réaction et fatigue', 'statut' => 'Brouillon', 'couleur' => 'grey', 'inscrits' => 0, 'places' => 30, 'creneau' => 'Aucun créneau'],
    ['titre' => 'Suivi oculaire et lecture sur écran', 'statut' => 'Recrutement', 'couleur' => 'yellow', 'inscrits' => 6, 'places' => 20, 'creneau' => 'Jeu. 09:30 · Eye-tracker'],
];
?>

<div class="page-head">
  <div>
    <h1>Mes expérimentations</h1>
    <p class="sub">Enseignant-chercheur · Serveau Damien</p>
  </div>
  <div class="tools">
    <span class="btn">Français ▾</span>
    <span class="btn">☾</span>
  </div>
</div>

<div class="pills">
  <span class="pill on">Toutes (4)</span>
  <span class="pill">En cours (2)</span>
  <span class="pill">Brouillons (1)</span>
  <span class="pill">Archivées (1)</span>
</div>

<div class="grid g2">
  <?php foreach ($experimentations as $exp): ?>
    <?php $pourcentage = round($exp['inscrits'] / $exp['places'] * 100); ?>
    <article class="card">
      <div class="exp-head">
        <span class="exp-icon">
          <svg class="ico" viewBox="0 0 24 24"><path d="M9 3h6M10 3v6L4.5 19a1.5 1.5 0 0 0 1.3 2.2h12.4a1.5 1.5 0 0 0 1.3-2.2L14 9V3M7.5 15h9"/></svg>
        </span>
        <h3><?= htmlspecialchars($exp['titre']) ?></h3>
        <span class="tag tag-<?= $exp['couleur'] ?>"><?= $exp['statut'] ?></span>
      </div>

      <div class="exp-boxes">
        <div class="box">
          <span class="muted">Participants</span>
          <strong><?= $exp['inscrits'] ?> / <?= $exp['places'] ?></strong>
          <div class="bar"><i style="width:<?= $pourcentage ?>%"></i></div>
        </div>
        <div class="box">
          <span class="muted">Progression</span>
          <strong>—</strong>
        </div>
      </div>

      <p class="muted">Prochain créneau : <b style="color:#1a1d2e"><?= htmlspecialchars($exp['creneau']) ?></b></p>

      <div class="exp-actions">
        <a class="btn btn-navy" href="#">→ Gérer</a>
        <a class="btn" href="#">Modifier</a>
        <a class="btn" href="#">Archiver</a>
      </div>
    </article>
  <?php endforeach; ?>
</div>
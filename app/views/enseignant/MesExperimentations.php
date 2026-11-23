<?php
$exps = [
    ['Perception des couleurs en réalité virtuelle', 'En cours',    'green',  24, 30, 'Auj. 14:00 · Salle B-104'],
    ['Mémoire de travail et bilinguisme',            'En cours',    'green',  22, 40, 'Mer. 10:00 · Salle A-012'],
    ['Temps de réaction et fatigue',                 'Brouillon',   'grey',    0, 30, 'Aucun créneau'],
    ['Suivi oculaire et lecture sur écran',          'Recrutement', 'yellow',  6, 20, 'Jeu. 09:30 · Eye-tracker'],
];
?>
<div class="page-head">
  <div>
    <h1>Mes expérimentations</h1>
    <p class="sub">Enseignant-chercheur · Serveau Damien</p>
  </div>
  <div class="tools"><span class="btn">Français ▾</span><span class="btn">☾</span></div>
</div>

<div class="pills">
  <span class="pill on">Toutes (4)</span><span class="pill">En cours (2)</span>
  <span class="pill">Brouillons (1)</span><span class="pill">Archivées (1)</span>
</div>

<div class="grid g2">
<?php foreach ($exps as [$titre, $statut, $couleur, $n, $max, $creneau]): ?>
  <article class="card">
    <div class="exp-head">
      <span class="exp-icon"><svg class="ico" viewBox="0 0 24 24"><path d="M9 3h6M10 3v6L4.5 19a1.5 1.5 0 0 0 1.3 2.2h12.4a1.5 1.5 0 0 0 1.3-2.2L14 9V3M7.5 15h9"/></svg></span>
      <h3><?= htmlspecialchars($titre) ?></h3>
      <span class="tag tag-<?= $couleur ?>"><?= $statut ?></span>
    </div>
    <div class="exp-boxes">
      <div class="box"><span class="muted">Participants</span>
        <strong><?= $n ?> / <?= $max ?></strong>
        <div class="bar"><i style="width:<?= round($n / $max * 100) ?>%"></i></div></div>
      <div class="box"><span class="muted">Progression</span><strong>—</strong></div>
    </div>
    <p class="muted">Prochain créneau : <b style="color:#1a1d2e"><?= htmlspecialchars($creneau) ?></b></p>
    <div class="exp-actions">
      <a class="btn btn-navy" href="#">→ Gérer</a>
      <a class="btn" href="#">✎ Modifier</a>
      <a class="btn" href="#">Archiver</a>
    </div>
  </article>
<?php endforeach; ?>
</div>
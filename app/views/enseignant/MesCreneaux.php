<?php
$creneaux = [
    ['30', 'sept.', 'Perception des couleurs en réalité virtuelle', '10:00 – 10:45', 'Salle B-104'],
    ['07', 'oct.',  'Perception des couleurs en réalité virtuelle', '14:00 – 14:45', 'Salle B-104'],
    ['15', 'oct.',  'Mémoire de travail et bilinguisme',            '09:00 – 10:00', 'Salle A-012'],
];
?>
<h1>Mes créneaux</h1>
<p class="sub" style="margin-bottom:24px">Vos rendez-vous pour les expérimentations auxquelles vous êtes inscrit.</p>

<div class="card">
  <h2>À venir</h2>
  <?php foreach ($creneaux as [$jour, $mois, $titre, $heure, $salle]): ?>
    <div class="list-row">
      <div class="date"><?= $jour ?><small><?= mb_strtoupper($mois) ?></small></div>
      <div class="grow"><strong><?= $titre ?></strong><span class="muted">🕙 <?= $heure ?> · 📍 <?= $salle ?></span></div>
      <a class="btn" href="#">✎ Changer</a>
      <a class="btn btn-danger" href="#">✕ Annuler</a>
    </div>
  <?php endforeach; ?>
</div>
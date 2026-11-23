<?php
// données en dur en attendant la base de données
$creneaux = [
    ['jour' => '30', 'mois' => 'SEPT.', 'titre' => 'Perception des couleurs en réalité virtuelle', 'heure' => '10:00 – 10:45', 'salle' => 'Salle B-104'],
    ['jour' => '07', 'mois' => 'OCT.', 'titre' => 'Perception des couleurs en réalité virtuelle', 'heure' => '14:00 – 14:45', 'salle' => 'Salle B-104'],
    ['jour' => '15', 'mois' => 'OCT.', 'titre' => 'Mémoire de travail et bilinguisme', 'heure' => '09:00 – 10:00', 'salle' => 'Salle A-012'],
];
?>

<h1>Mes créneaux</h1>
<p class="sub" style="margin-bottom:24px">Vos rendez-vous pour les expérimentations auxquelles vous êtes inscrit.</p>

<div class="card">
  <h2>À venir</h2>
  <?php foreach ($creneaux as $creneau): ?>
    <div class="list-row">
      <div class="date"><?= $creneau['jour'] ?><small><?= $creneau['mois'] ?></small></div>
      <div class="grow">
        <strong><?= htmlspecialchars($creneau['titre']) ?></strong>
        <span class="muted"><?= $creneau['heure'] ?> · <?= $creneau['salle'] ?></span>
      </div>
      <a class="btn" href="#">Changer</a>
      <a class="btn btn-danger" href="#">Annuler</a>
    </div>
  <?php endforeach; ?>
</div>
<?php
// données en dur en attendant la base de données
$indicateurs = [
    ['titre' => 'Inscrits', 'valeur' => '86 / 120', 'detail' => '72 % des places remplies', 'couleur' => 'green'],
    ['titre' => 'Taux de participation', 'valeur' => '78 %', 'detail' => '+ 4 pts vs semestre dernier', 'couleur' => 'green'],
    ['titre' => 'Absences / annulations', 'valeur' => '7', 'detail' => '8 % des inscrits', 'couleur' => 'red'],
    ['titre' => 'Rétributions versées', 'valeur' => '42', 'detail' => '610 € · 5 en attente', 'couleur' => 'muted'],
];

// pas de nom $profil : il est déjà utilisé dans navigation.php
$profilParticipants = [
    'Âge' => ['18 – 25 ans' => 62, '26 – 35 ans' => 24, '36 – 50 ans' => 10, '+ 50 ans' => 4],
    'Genre' => ['Femme' => 54, 'Homme' => 44, 'Autre / NC' => 2],
    'Langue' => ['Français' => 71, 'Anglais' => 18, 'Autre' => 11],
];

$details = [
    ['titre' => 'Perception des couleurs en VR', 'inscrits' => 24, 'places' => 30, 'participation' => 78, 'creneaux' => '14 / 16'],
    ['titre' => 'Mémoire de travail et bilinguisme', 'inscrits' => 22, 'places' => 40, 'participation' => 64, 'creneaux' => '9 / 18'],
    ['titre' => 'Suivi oculaire et lecture sur écran', 'inscrits' => 6, 'places' => 20, 'participation' => null, 'creneaux' => '1 / 10'],
    ['titre' => 'Temps de réaction et fatigue', 'inscrits' => 0, 'places' => 30, 'participation' => null, 'creneaux' => '0 / 0'],
];
?>

<div class="page-head">
  <div>
    <h1>Statistiques</h1>
    <p class="sub">Enseignant-chercheur · mes expérimentations</p>
  </div>
  <div class="tools">
    <span class="btn">Toutes mes expérimentations ▾</span>
    <span class="btn">Ce semestre ▾</span>
  </div>
</div>

<div class="grid g4">
  <?php foreach ($indicateurs as $indicateur): ?>
    <div class="card kpi">
      <span class="label"><?= $indicateur['titre'] ?></span>
      <strong><?= $indicateur['valeur'] ?></strong>
      <small class="<?= $indicateur['couleur'] ?>"><?= $indicateur['detail'] ?></small>
    </div>
  <?php endforeach; ?>
</div>

<div class="card" style="max-width:350px;margin-bottom:16px">
  <h2>Profil des participants</h2>
  <?php foreach ($profilParticipants as $categorie => $valeurs): ?>
    <div class="group">
      <h3><?= $categorie ?></h3>
      <?php foreach ($valeurs as $nom => $pourcentage): ?>
        <div class="row-bar">
          <span><?= $nom ?></span>
          <div class="bar"><i style="width:<?= $pourcentage ?>%"></i></div>
          <span><?= $pourcentage ?> %</span>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>

<div class="card">
  <h2>Détail par expérimentation</h2>
  <table>
    <tr>
      <th>Expérimentation</th>
      <th>Inscrits</th>
      <th>Participation</th>
      <th>Créneaux remplis</th>
    </tr>
    <?php foreach ($details as $detail): ?>
      <?php $remplissage = round($detail['inscrits'] / $detail['places'] * 100); ?>
      <tr>
        <td><?= htmlspecialchars($detail['titre']) ?></td>
        <td>
          <div class="bar"><i style="width:<?= $remplissage ?>%"></i></div>
          <?= $detail['inscrits'] ?> / <?= $detail['places'] ?>
        </td>
        <td>
          <div class="bar green"><i style="width:<?= (int) $detail['participation'] ?>%"></i></div>
          <?php if ($detail['participation'] === null): ?>
            —
          <?php else: ?>
            <?= $detail['participation'] ?> %
          <?php endif; ?>
        </td>
        <td><?= $detail['creneaux'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
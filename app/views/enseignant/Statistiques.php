<?php
$kpis = [
    ['Inscrits', '86 / 120', '72 % des places remplies', 'green'],
    ['Taux de participation', '78 %', '+ 4 pts vs semestre dernier', 'green'],
    ['Absences / annulations', '7', '8 % des inscrits', 'red'],
    ['Rétributions versées', '42', '610 € · 5 en attente', 'muted'],
];
$profil = [
    'Âge'    => [['18 – 25 ans', 62], ['26 – 35 ans', 24], ['36 – 50 ans', 10], ['+ 50 ans', 4]],
    'Genre'  => [['Femme', 54], ['Homme', 44], ['Autre / NC', 2]],
    'Langue' => [['Français', 71], ['Anglais', 18], ['Autre', 11]],
];
$detail = [
    ['Perception des couleurs en VR',      24, 30, 78,   '14 / 16'],
    ['Mémoire de travail et bilinguisme',  22, 40, 64,   '9 / 18'],
    ['Suivi oculaire et lecture sur écran', 6, 20, null, '1 / 10'],
    ['Temps de réaction et fatigue',        0, 30, null, '0 / 0'],
];
?>
<div class="page-head">
  <div>
    <h1>Statistiques</h1>
    <p class="sub">Enseignant-chercheur · mes expérimentations</p>
  </div>
  <div class="tools"><span class="btn">Toutes mes expérimentations ▾</span><span class="btn">Ce semestre ▾</span></div>
</div>

<div class="grid g4">
<?php foreach ($kpis as [$label, $val, $note, $cls]): ?>
  <div class="card kpi"><span class="label"><?= $label ?></span><strong><?= $val ?></strong><small class="<?= $cls ?>"><?= $note ?></small></div>
<?php endforeach; ?>
</div>

<div class="card" style="max-width:350px;margin-bottom:16px">
  <h2>Profil des participants</h2>
  <?php foreach ($profil as $titre => $lignes): ?>
    <div class="group"><h3><?= $titre ?></h3>
    <?php foreach ($lignes as [$nom, $pct]): ?>
      <div class="row-bar"><span><?= $nom ?></span><div class="bar"><i style="width:<?= $pct ?>%"></i></div><span><?= $pct ?> %</span></div>
    <?php endforeach; ?></div>
  <?php endforeach; ?>
</div>

<div class="card">
  <h2>Détail par expérimentation</h2>
  <table>
    <tr><th>Expérimentation</th><th>Inscrits</th><th>Participation</th><th>Créneaux remplis</th></tr>
    <?php foreach ($detail as [$nom, $n, $max, $part, $slots]): ?>
      <tr>
        <td><?= $nom ?></td>
        <td><div class="bar"><i style="width:<?= round($n / $max * 100) ?>%"></i></div><?= $n ?> / <?= $max ?></td>
        <td><div class="bar green"><i style="width:<?= (int) $part ?>%"></i></div><?= $part !== null ? $part . ' %' : '—' ?></td>
        <td><?= $slots ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
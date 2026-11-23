<?php
$kpis = [['4', 'Expérimentations actives'], ['86', 'Participants inscrits au total'], ['70 %', 'Taux de tâches effectuées']];
$exps = [
    ['Perception des couleurs', 'En cours', 12, 'Auj. 14h/14h45'],
    ['Mémoire de travail et bilinguisme', 'En cours', 55, 'Mer. 10h/11h'],
    ['Suivi oculaire et lecture', 'Recrutement', 30, 'Jeu. 09h30/10h15'],
];
$inscrits = [['Amaury Bernard', 'participation VR'], ['Camille Martin', 'mémoire de travail'], ['Léa Dubois', 'suivi oculaire']];
?>
<div class="page-head">
  <div>
    <h1>Tableau de bord</h1>
    <p class="sub">Enseignant-chercheur · Serveau Damien</p>
  </div>
  <div class="tools"><span class="btn">Français ▾</span><span class="btn">☾</span><a class="btn btn-accent" href="#">+ Nouvelle expérimentation</a></div>
</div>

<div class="grid g3">
<?php foreach ($kpis as [$val, $label]): ?>
  <div class="card kpi"><strong><?= $val ?></strong><span class="label"><?= $label ?></span></div>
<?php endforeach; ?>
</div>

<div class="grid g-main">
  <div class="card">
    <h2>Dernières expérimentations</h2>
    <table>
      <tr><th>Expérimentation</th><th>Statut</th><th>Progression</th><th>Prochain créneau</th></tr>
      <?php foreach ($exps as [$nom, $statut, $pct, $slot]): ?>
        <tr>
          <td><?= $nom ?></td>
          <td><span class="tag <?= $statut === 'En cours' ? 'tag-green' : 'tag-yellow' ?>"><?= $statut ?></span></td>
          <td><div class="bar"><i style="width:<?= $pct ?>%"></i></div></td>
          <td><?= $slot ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <div class="card">
    <h2>Dernières inscriptions <a href="#" style="color:var(--accent);font-size:12px;float:right">voir tout ›</a></h2>
    <?php foreach ($inscrits as [$nom, $exp]): ?>
      <div class="list-row">
        <span class="avatar"><?= mb_substr($nom, 0, 1) ?></span>
        <div class="grow"><strong><?= $nom ?></strong><span class="muted"><?= $exp ?></span></div>
        <span class="green">✔</span><span class="red">✖</span>
      </div>
    <?php endforeach; ?>
  </div>
</div>
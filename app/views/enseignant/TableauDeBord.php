<?php
// données en dur en attendant la base de données
$chiffres = [
    ['valeur' => '4', 'texte' => 'Expérimentations actives'],
    ['valeur' => '86', 'texte' => 'Participants inscrits au total'],
    ['valeur' => '70 %', 'texte' => 'Taux de tâches effectuées'],
];

$experimentations = [
    ['titre' => 'Perception des couleurs', 'statut' => 'En cours', 'progression' => 12, 'creneau' => 'Auj. 14h/14h45'],
    ['titre' => 'Mémoire de travail et bilinguisme', 'statut' => 'En cours', 'progression' => 55, 'creneau' => 'Mer. 10h/11h'],
    ['titre' => 'Suivi oculaire et lecture', 'statut' => 'Recrutement', 'progression' => 30, 'creneau' => 'Jeu. 09h30/10h15'],
];

$inscriptions = [
    ['nom' => 'Amaury Bernard', 'experimentation' => 'participation VR'],
    ['nom' => 'Camille Martin', 'experimentation' => 'mémoire de travail'],
    ['nom' => 'Léa Dubois', 'experimentation' => 'suivi oculaire'],
];
?>

<div class="page-head">
  <div>
    <h1>Tableau de bord</h1>
    <p class="sub">Enseignant-chercheur · Serveau Damien</p>
  </div>
  <div class="tools">
    <span class="btn">Français ▾</span>
    <span class="btn">☾</span>
    <a class="btn btn-accent" href="#">+ Nouvelle expérimentation</a>
  </div>
</div>

<div class="grid g3">
  <?php foreach ($chiffres as $chiffre): ?>
    <div class="card kpi">
      <strong><?= $chiffre['valeur'] ?></strong>
      <span class="label"><?= $chiffre['texte'] ?></span>
    </div>
  <?php endforeach; ?>
</div>

<div class="grid g-main">
  <div class="card">
    <h2>Dernières expérimentations</h2>
    <table>
      <tr>
        <th>Expérimentation</th>
        <th>Statut</th>
        <th>Progression</th>
        <th>Prochain créneau</th>
      </tr>
      <?php foreach ($experimentations as $exp): ?>
        <?php
        if ($exp['statut'] === 'En cours') {
            $couleur = 'tag-green';
        } else {
            $couleur = 'tag-yellow';
        }
        ?>
        <tr>
          <td><?= htmlspecialchars($exp['titre']) ?></td>
          <td><span class="tag <?= $couleur ?>"><?= $exp['statut'] ?></span></td>
          <td><div class="bar"><i style="width:<?= $exp['progression'] ?>%"></i></div></td>
          <td><?= $exp['creneau'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <div class="card">
    <h2>
      Dernières inscriptions
      <a href="#" style="color:var(--accent);font-size:12px;float:right">voir tout ›</a>
    </h2>
    <?php foreach ($inscriptions as $inscription): ?>
      <div class="list-row">
        <span class="avatar"><?= mb_substr($inscription['nom'], 0, 1) ?></span>
        <div class="grow">
          <strong><?= htmlspecialchars($inscription['nom']) ?></strong>
          <span class="muted"><?= htmlspecialchars($inscription['experimentation']) ?></span>
        </div>
        <span class="green">✔</span>
        <span class="red">✖</span>
      </div>
    <?php endforeach; ?>
  </div>
</div>
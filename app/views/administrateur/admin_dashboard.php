<?php
// Valeurs par défaut (évitent les avertissements de VS Code)
$chiffres     = $chiffres ?? [];
$raccourcis   = $raccourcis ?? [];
$demandesRgpd = $demandesRgpd ?? [];
$evenements   = $evenements ?? [];
$modeles      = $modeles ?? [];
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/css/administrateur_css/dashboard.css">

<!-- ========== EN-TÊTE ========== -->
<div class="page-head">
  <div>
    <h1>Tableau de bord</h1>
    <p class="sub">Administrateur · <?= htmlspecialchars(($_SESSION['prenom'] ?? '') . ' ' . ($_SESSION['nom'] ?? '')) ?></p>
  </div>
  <div class="tools">
    <button type="button" class="langue-connexion">
      <img src="<?= BASE_URL ?>/images/globe.png" alt="" class="icone">
      Français
      <img src="<?= BASE_URL ?>/images/fleche.png" alt="" class="icone-fleche">
    </button>

    <button type="button" class="night" aria-label="Mode sombre">
      <img src="<?= BASE_URL ?>/images/dark.png" alt="" class="icone-night">
    </button>

    <a class="btn btn-accent" href="<?= lien('admin-utilisateurs') ?>">+ Créer un compte</a>
  </div>
</div>

<!-- ========== CHIFFRES CLÉS ========== -->
<div class="grid g4">
  <?php foreach ($chiffres as $chiffre): ?>
    <div class="card kpi">
      <span class="label"><?= htmlspecialchars($chiffre['texte']) ?></span>
      <strong><?= htmlspecialchars($chiffre['valeur']) ?></strong>
      <small class="<?= $chiffre['couleur'] ?>"><?= htmlspecialchars($chiffre['detail']) ?></small>
    </div>
  <?php endforeach; ?>
</div>

<!-- ========== ACCÈS RAPIDES ========== -->
<div class="card bloc-raccourcis">
  <h2>Gestion de l'application</h2>
  <div class="raccourcis">
    <?php foreach ($raccourcis as $r): ?>
      <a class="raccourci" href="<?= htmlspecialchars($r['lien']) ?>">
        <strong><?= htmlspecialchars($r['titre']) ?></strong>
        <span class="muted"><?= htmlspecialchars($r['texte']) ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<div class="grid g-main">

  <!-- ========== SÉCURITÉ ========== -->
  <div class="card">
    <h2>
      Derniers événements de sécurité
      <a href="<?= lien('admin-journaux') ?>" class="voir-tout">voir les journaux ›</a>
    </h2>
    <table>
      <tr>
        <th>Heure</th>
        <th>Événement</th>
        <th>État</th>
      </tr>
      <?php foreach ($evenements as $e): ?>
        <tr>
          <td><?= htmlspecialchars($e['heure']) ?></td>
          <td><?= htmlspecialchars($e['texte']) ?></td>
          <td><span class="tag <?= $e['couleur'] ?>"><?= htmlspecialchars($e['etat']) ?></span></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <!-- ========== RGPD ========== -->
  <div class="card" id="rgpd">
    <h2>Demandes RGPD en attente</h2>
    <?php foreach ($demandesRgpd as $d): ?>
      <div class="list-row">
        <span class="avatar"><?= htmlspecialchars(mb_substr($d['nom'], 0, 1)) ?></span>
        <div class="grow">
          <strong><?= htmlspecialchars($d['nom']) ?></strong>
          <span class="muted"><?= htmlspecialchars($d['type']) ?> · <?= htmlspecialchars($d['date']) ?></span>
        </div>
        <!-- À relier plus tard à ps_traiter_demande_suppression -->
        <form method="post" class="actions-rgpd">
          <button type="submit" name="traiter" value="1" class="btn btn-icone green" title="Traiter la demande" aria-label="Traiter la demande de <?= htmlspecialchars($d['nom']) ?>">✔</button>
          <button type="submit" name="rejeter" value="1" class="btn btn-icone red" title="Rejeter la demande" aria-label="Rejeter la demande de <?= htmlspecialchars($d['nom']) ?>">✖</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>

</div>

<!-- ========== MODÈLES GLOBAUX ========== -->
<div class="card">
  <h2>
    Modèles globaux d'expérimentations
    <a href="#" class="voir-tout">+ nouveau modèle</a>
  </h2>
  <table>
    <tr>
      <th>Modèle</th>
      <th>Utilisations</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($modeles as $m): ?>
      <tr>
        <td><?= htmlspecialchars($m['titre']) ?></td>
        <td><?= (int) $m['utilisations'] ?> expérimentations</td>
        <td>
          <a href="#" class="btn">Modifier</a>
          <a href="#" class="btn btn-danger">Supprimer</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
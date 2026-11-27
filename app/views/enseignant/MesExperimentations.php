<?php
// texte des boutons de filtre
$filtres = [
    'ouverte' => 'En cours',
    'brouillon' => 'Brouillons',
    'clôturée' => 'Clôturées',
    'archivée' => 'Archivées',
];

$lienPage = BASE_URL . '/index.php?page=experimentations';
?>

<div class="page-head">
  <div>
    <h1>Mes expérimentations</h1>
    <p class="sub">Enseignant-chercheur · <?= htmlspecialchars($utilisateur['prenom'] . ' ' . $utilisateur['nom']) ?></p>
  </div>
  <div class="tools">
    <span class="btn">Français ▾</span>
    <span class="btn">☾</span>
  </div>
</div>

<div class="pills">
  <a class="pill <?= $filtre == null ? 'on' : '' ?>" href="<?= $lienPage ?>">Toutes (<?= $total ?>)</a>
  <?php foreach ($filtres as $statut => $texte): ?>
    <a class="pill <?= $filtre == $statut ? 'on' : '' ?>" href="<?= $lienPage ?>&statut=<?= urlencode($statut) ?>">
      <?= $texte ?> (<?= $compteurs[$statut] ?>)
    </a>
  <?php endforeach; ?>
</div>

<?php if ($total == 0): ?>
  <p class="muted">Vous n'avez pas encore d'expérimentation.</p>
<?php elseif (count($experimentations) == 0): ?>
  <p class="muted">Aucune expérimentation dans cette catégorie.</p>
<?php endif; ?>

<div class="grid g2">
  <?php foreach ($experimentations as $exp): ?>
    <?php
    $statut = Experimentation::STATUTS[$exp['statut_experimentation']];

    // pas de créneau = pas de places, on évite la division par zéro
    $capacite = (int) $exp['capacite'];
    if ($capacite > 0) {
        $pourcentage = round($exp['nb_inscrits'] / $capacite * 100);
    } else {
        $pourcentage = 0;
    }

    if ($exp['prochain_creneau'] == null) {
        $prochainCreneau = 'Aucun créneau à venir';
    } else {
        $prochainCreneau = date('d/m/Y à H:i', strtotime($exp['prochain_creneau']));
    }
    ?>
    <article class="card">
      <div class="exp-head">
        <span class="exp-icon">
          <svg class="ico" viewBox="0 0 24 24"><path d="M9 3h6M10 3v6L4.5 19a1.5 1.5 0 0 0 1.3 2.2h12.4a1.5 1.5 0 0 0 1.3-2.2L14 9V3M7.5 15h9"/></svg>
        </span>
        <h3><?= htmlspecialchars($exp['titre']) ?></h3>
        <span class="tag tag-<?= $statut['couleur'] ?>"><?= $statut['libelle'] ?></span>
      </div>

      <div class="exp-boxes">
        <div class="box">
          <span class="muted">Participants</span>
          <strong><?= $exp['nb_inscrits'] ?> / <?= $capacite ?></strong>
          <div class="bar"><i style="width:<?= min($pourcentage, 100) ?>%"></i></div>
        </div>
        <div class="box">
          <span class="muted">Remplissage</span>
          <strong><?= $pourcentage ?> %</strong>
        </div>
      </div>

      <p class="muted">Prochain créneau : <b style="color:#1a1d2e"><?= $prochainCreneau ?></b></p>

      <div class="exp-actions">
        <a class="btn btn-navy" href="<?= BASE_URL ?>/index.php?page=experimentation&id=<?= $exp['id_experimentation'] ?>">→ Gérer</a>
        <a class="btn" href="#">Modifier</a>
        <?php if ($exp['statut_experimentation'] == 'ouverte'): ?>
          <form method="post" action="<?= BASE_URL ?>/index.php?page=changer-statut">
            <input type="hidden" name="id_experimentation" value="<?= $exp['id_experimentation'] ?>">
            <button class="btn btn-full" name="action" value="cloturer" onclick="return confirm('Clôturer cette expérimentation ? Les inscriptions seront fermées.')">Clôturer</button>
          </form>
        <?php elseif ($exp['statut_experimentation'] != 'archivée'): ?>
          <form method="post" action="<?= BASE_URL ?>/index.php?page=changer-statut">
            <input type="hidden" name="id_experimentation" value="<?= $exp['id_experimentation'] ?>">
            <button class="btn btn-full" name="action" value="archiver" onclick="return confirm('Archiver cette expérimentation ?')">Archiver</button>
          </form>
        <?php endif; ?>
      </div>
    </article>
  <?php endforeach; ?>
</div>
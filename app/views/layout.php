<?php
// Squelette commun à toutes les pages : navbar + contenu de la page
// Le contrôleur définit avant : $currentPage (onglet actif), $badges, $message et $contentView (vue à afficher)

if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$navigation = require __DIR__ . '/../controllers/navigation.php';
$role = $_SESSION['role'] ?? '';
$liens = $navigation[$role] ?? [];

if (!isset($currentPage)) {
    $currentPage = '';
}
if (!isset($badges)) {
    $badges = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Expérimentations</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/NavBar.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/pages.css">
  <?php if ($role == 'participant'): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/participant.css">
  <?php endif; ?>
</head>
<body>

<header class="navbar">
  <a class="brand" href="<?= BASE_URL ?>/index.php">
    <img class="brand-logo" src="<?= BASE_URL ?>/images/logo.png" alt="Logo Le Mans Université">
    <span class="brand-name">Le Mans Université</span>
  </a>

  <nav>
    <ul class="nav-links">
      <?php foreach ($liens as $cle => $lien): ?>
        <li>
          <a class="nav-link" href="<?= htmlspecialchars($lien['href']) ?>" <?= $cle === $currentPage ? 'aria-current="page"' : '' ?>>
            <svg viewBox="0 0 24 24"><?= $lien['icon'] ?></svg>
            <?= htmlspecialchars($lien['label']) ?>
            <?php if (!empty($badges[$cle])): ?>
              <span class="badge"><?= (int) $badges[$cle] ?></span>
            <?php endif; ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>

  <a class="logout" href="<?= BASE_URL ?>/index.php?page=deconnexion">Se déconnecter</a>
</header>

<main>
  <?php if (!empty($message)): ?>
    <p class="flash flash-<?= $message['type'] ?>"><?= htmlspecialchars($message['texte']) ?></p>
  <?php endif; ?>

  <?php
  if (!empty($contentView)) {
      require $contentView;
  }
  ?>
</main>

</body>
</html>
<?php
/**
 * Layout commun : navbar (selon le rôle), contenu, footer.
 * Fichier : app/views/layout.php
 *
 * Variables attendues, à définir avant le require :
 *   $currentPage : clé de l'onglet actif (ex. 'experimentations')
 *   $badges      : (facultatif) compteurs par clé, ex. ['creneaux' => 5]
 *   $contentView : (facultatif) chemin de la vue à afficher dans <main>
 *
 * Le rôle vient de $_SESSION['role'] : participant, enseignant ou admin.
 * 
* <?php
* session_start();
*
*define('BASE_URL', '/SAE3.01/public'); // XAMPP
*
*TEST uniquement : simule un utilisateur connecté (participant, enseignant ou admin).
*$_SESSION['role'] = 'enseignant';
*
*require_once __DIR__ . '/../app/controllers/EnseignantController.php';
*
*(new EnseignantController())->mesExperimentations();
 */
if (!defined('BASE_URL')) {
  define('BASE_URL', '');
}
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$navigation  = require __DIR__ . '/../controllers/navigation.php';
$role        = $_SESSION['role'] ?? '';
$links       = $navigation[$role] ?? [];
$currentPage = $currentPage ?? '';
$badges      = $badges ?? [];
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
</head>
<body>

<header class="navbar">
<a class="brand" href="<?= BASE_URL ?>/index.php">
  <img class="brand-logo" src="<?= BASE_URL ?>/images/logo.png" alt="Logo Le Mans Université">
  <span class="brand-name">Le Mans Université</span>
</a>

<nav aria-label="Navigation principale">
  <ul class="nav-links">
    <?php foreach ($links as $key => $link): ?>
      <li>
        <a class="nav-link"
           href="<?= htmlspecialchars($link['href']) ?>"
           <?= $key === $currentPage ? 'aria-current="page"' : '' ?>>
          <svg viewBox="0 0 24 24" aria-hidden="true"><?= $link['icon'] ?></svg>
          <?= htmlspecialchars($link['label']) ?>
          <?php if (!empty($badges[$key])): ?>
            <span class="badge"><?= (int) $badges[$key] ?></span>
          <?php endif; ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>

<a class="logout" href="#">Se déconnecter</a>
</header>

<main>
<?php if (!empty($contentView)) require $contentView; ?>
</main>

<!-- Footer : à ajouter ici -->

</body>
</html>
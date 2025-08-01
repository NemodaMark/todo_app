<?php
require_once(__DIR__ . '/../config/config.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do app</title>

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</head>
<body class="background-light">

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= BASE_URL ?>/index.php">To-Do App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>index.php">Főoldal</a>
        </li>

        <?php if (empty($_SESSION['user_id'])): ?>
          <!-- Ha nincs bejelentkezve -->
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>view/register.php">Regisztráció</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>view/login.php">Bejelentkezés</a>
          </li>
        <?php else: ?>
          <!-- Ha be van jelentkezve -->
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>view/dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASE_URL ?>process/process_logout.php">Kijelentkezés</a>
          </li>
        <?php endif; ?>
      </ul>

      <?php if (!empty($_SESSION['user_name'])): ?>
        <span class="navbar-text ms-auto me-2">
          Üdv, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>!
        </span>
      <?php endif; ?>
    </div>
  </div>
</nav>

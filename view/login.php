<?php require_once("../includes/header.php"); 

if (isset($_SESSION['user_id'])) {
    // Ha be van jelentkezve, ne maradjon itt
    header("Location: " . BASE_URL . "view/dashboard.php");
    exit;
}

if (isset($_SESSION['message'])) {
    $color = ($_SESSION['type'] === 'error') ? 'red' : 'green';
    echo "<p style='color: $color; font-weight: bold; text-align:center; margin-top: 20px;'>{$_SESSION['message']}</p>";
    unset($_SESSION['message'], $_SESSION['type']);
}
?>

  <h2>Bejelentkezés</h2>
  <form action="<?= BASE_URL ?>/process/process_login.php" method="post">

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Jelszó:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Bejelentkezés</button>
  </form>

<?php require_once("../includes/footer.php"); ?>
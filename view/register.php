<?php require_once("../includes/header.php"); 

if (isset($_SESSION['message'])) {
    $color = ($_SESSION['type'] === 'error') ? 'red' : 'green';
    echo "<p style='color: $color; font-weight: bold; text-align:center; margin-top: 20px;'>{$_SESSION['message']}</p>";
    unset($_SESSION['message'], $_SESSION['type']);
}
?>

  <h2>Regisztráció</h2>
  <form action="<?= BASE_URL ?>/process/process_login.php" method="post">
    <label>Teljes név:</label><br>
    <input type="text" name="userName" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Jelszó:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Jelszó ismét:</label><br>
    <input type="password" name="password_repeat" required><br><br>

    <label>
      <input type="checkbox" name="terms" required>
      Elfogadom a feltételeket
    </label><br><br>

    <button type="submit">Regisztrálok</button>
  </form>

<?php require_once("../includes/footer.php"); ?>
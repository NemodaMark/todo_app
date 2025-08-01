<?php
require_once '../includes/header.php';
require_once __DIR__ . '/../config/db.php';

// Csak belépett felhasználók használhatják
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<h2 style="text-align:center;">📝 Új feladat hozzáadása</h2>

<form action="../process/process_new_task.php" method="post">

    <label for="title">Cím:</label>
    <input type="text" id="title" name="title" required><br>

    <label for="description">Leírás:</label>
    <textarea id="description" name="description" required></textarea><br>

    <button type="submit">Hozzáadás</button>
</form>

<?php require_once '../includes/footer.php'; ?>

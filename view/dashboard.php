<?php require_once("../includes/header.php");

if (isset($_SESSION['message'])) {
    $color = ($_SESSION['type'] === 'error') ? 'red' : 'green';
    echo "<p style='color: $color; font-weight: bold; text-align:center; margin-top: 20px;'>{$_SESSION['message']}</p>";
    unset($_SESSION['message'], $_SESSION['type']);
}
require_once __DIR__ . '/../config/db.php';

// Bejelentkezés ellenőrzés
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "view/login.php");
    exit;
}

// Aktuális user feladatainak lekérdezése
$stmt = $pdo->prepare("
    SELECT t.taskID, t.taskTitle, t.taskDescr
    FROM tasks t
    INNER JOIN user_task ut ON t.taskID = ut.taskID
    WHERE ut.userID = ?
");
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll();

?>

<div style="text-align: center; margin-top: 20px;">
    <a href="new_task.php">
        <button style="padding: 10px 20px; font-size: 16px;">➕ Új feladat</button>
    </a>
</div>


<h2 class="text-center">🎯 Feladataim</h2>

<table border="1" cellpadding="10" cellspacing="0" style="margin:auto;">
    <tr>
        <th>Cím</th>
        <th>Részletek</th>
        <th>Státusz</th>
    </tr>
    <?php foreach ($tasks as $task): ?>
    <tr>
        <td><?= htmlspecialchars($task['taskTitle']) ?></td>
        <td>
            <form action="task_detail.php" method="get">
                <input type="hidden" name="id" value="<?= $task['taskID'] ?>">
                <button type="submit">🔍 Részletek</button>
            </form>
        </td>
        <td>
            <form action="../process/process_mark_done.php" method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?= $task['taskID'] ?>">
                <button type="submit">✅ Kész</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require_once('../includes/footer.php'); ?>

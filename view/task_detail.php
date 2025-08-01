<?php
require_once __DIR__ . '/../config/db.php';
session_start();

// Ha nincs bejelentkezve a user, irány a login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$taskID = $_GET['id'] ?? null;
$userID = $_SESSION['user_id'];

if (!$taskID) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Hiányzó feladat-azonosító!';
    header("Location: dashboard.php");
    exit;
}

// Ellenőrizzük, hogy a feladat valóban ehhez a userhez tartozik
$stmt = $pdo->prepare("
    SELECT t.taskTitle, t.taskDescr, t.taskCreated
    FROM tasks t
    INNER JOIN user_task ut ON t.taskID = ut.taskID
    WHERE t.taskID = ? AND ut.userID = ?
");
$stmt->execute([$taskID, $userID]);
$task = $stmt->fetch();

if (!$task) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Nincs jogosultságod ehhez a feladathoz!';
    header("Location: dashboard.php");
    exit;
}
?>

<?php require_once '../includes/header.php'; ?>

<div style="max-width: 600px; margin: auto;">
    <h2>📝 Feladat részletei</h2>
    <p><strong>Cím:</strong> <?= htmlspecialchars($task['taskTitle']) ?></p>
    <p><strong>Leírás:</strong><br><?= nl2br(htmlspecialchars($task['taskDescr'])) ?></p>
    <p><strong>Létrehozva:</strong> <?= $task['taskCreated'] ?></p>
    
    <a href="dashboard.php">
        <button>⬅ Vissza a listához</button>
    </a>
</div>

<?php require_once '../includes/footer.php'; ?>

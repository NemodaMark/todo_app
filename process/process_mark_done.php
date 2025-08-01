<?php
require_once __DIR__ . '/../config/db.php';
session_start();

$taskID = $_POST['id'] ?? null;
$userID = $_SESSION['user_id'] ?? null;

if (!$taskID || !$userID) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '⚠️ Hibás adat!';
    header("Location: ../view/dashboard.php");
    exit;
}

// Ellenőrizzük, hogy a felhasználóhoz tartozik-e a feladat
$stmt = $pdo->prepare("SELECT * FROM user_task WHERE userID = ? AND taskID = ?");
$stmt->execute([$userID, $taskID]);

if (!$stmt->fetch()) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Nem rendelhető hozzád ez a feladat!';
    header("Location: ../view/dashboard.php");
    exit;
}

// Megnézzük, hogy már el van-e mentve a completed_tasks táblába
$stmt = $pdo->prepare("SELECT * FROM completed_tasks WHERE taskID = ? AND completed_by = ?");
$stmt->execute([$taskID, $userID]);

if ($stmt->fetch()) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '⚠️ Ez a feladat már el van végezve!';
    header("Location: ../view/dashboard.php");
    exit;
}

// Lekérdezzük a feladat adatait a beszúráshoz
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE taskID = ?");
$stmt->execute([$taskID]);
$task = $stmt->fetch();

if (!$task) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Nem található a feladat!';
    header("Location: ../view/dashboard.php");
    exit;
}

// Beszúrjuk a completed_tasks táblába
$stmt = $pdo->prepare("INSERT INTO completed_tasks (taskID, taskTitle, taskDescr, taskCreated, completed_by, completed_at) 
                       VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->execute([
    $task['taskID'],
    $task['taskTitle'],
    $task['taskDescr'],
    $task['taskCreated'],
    $userID
]);

// Feladat eltávolítása a user_task táblából (így eltűnik a dashboardról)
$stmt = $pdo->prepare("DELETE FROM user_task WHERE userID = ? AND taskID = ?");
$stmt->execute([$userID, $taskID]);

$stmt = $pdo->prepare("DELETE FROM tasks WHERE taskID = ?");
$stmt->execute([$taskID]);

$_SESSION['type'] = 'success';
$_SESSION['message'] = '✅ Feladat elvégezve!';
header("Location: ../view/dashboard.php");
exit;

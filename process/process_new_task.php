<?php
require_once __DIR__ . '/../config/config.php'; // BASE_URL definiálásához
require_once __DIR__ . '/../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Belépés ellenőrzés
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "view/login.php");
    exit;
}

// 2. Adatok átvétele és tisztítása
$title = trim($_POST['title'] ?? '');
$desc  = trim($_POST['description'] ?? '');

// 3. Validáció
if (empty($title) || empty($desc)) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Minden mezőt ki kell tölteni!';
    header("Location: " . BASE_URL . "view/new_task.php");
    exit;
}

try {
    // 4. Feladat beszúrása
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO tasks (taskTitle, taskDescr, taskCreated) VALUES (?, ?, NOW())");
    $stmt->execute([$title, $desc]);

    $taskID = $pdo->lastInsertId();

    // 5. Felhasználóhoz rendelés
    $stmt = $pdo->prepare("INSERT INTO user_task (userID, taskID) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $taskID]);

    $pdo->commit();

    $_SESSION['type'] = 'success';
    $_SESSION['message'] = '✅ Új feladat sikeresen hozzáadva!';
    header("Location: " . BASE_URL . "view/dashboard.php");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Hiba történt a mentés során!';
    header("Location: " . BASE_URL . "view/new_task.php");
    exit;
}

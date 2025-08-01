<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// 1. Adatok átvétele
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// 2. Alap validáció
if (!$email || !$password) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Minden mezőt ki kell tölteni!';
    header("Location: ../view/login.php");
    exit;
}

// 3. Felhasználó keresése email alapján
$stmt = $pdo->prepare("SELECT userID, userName, userPasswd FROM users WHERE userEmail = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Nincs ilyen email regisztrálva!';
    header("Location: ../view/login.php");
    exit;
}

// 4. Jelszó ellenőrzés
if (!password_verify($password, $user['userPasswd'])) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Hibás jelszó!';
    header("Location: ../view/login.php");
    exit;
}

// 5. Sikeres bejelentkezés – session adatok beállítása
$_SESSION['user_id'] = $user['userID'];
$_SESSION['user_name'] = $user['userName'];

$_SESSION['type'] = 'success';
$_SESSION['message'] = '✅ Sikeres bejelentkezés, üdv: ' . $user['userName'];
header("Location: ../view/dashboard.php"); // vagy dashboard.php, ha van
exit;

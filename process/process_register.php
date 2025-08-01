<?php
require_once __DIR__ . '/../config/db.php';
session_start();

// Adatok átvétele
$name     = trim($_POST['userName'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$repeat   = $_POST['password_repeat'] ?? '';
$terms    = isset($_POST['terms']);

// 1. Validáció
if (!$name || !$email || !$password || !$repeat || !$terms) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Minden mezőt ki kell tölteni, és el kell fogadni a feltételeket!';
    header("Location: ../view/register.php");
    exit;
}

// 2. Jelszó ellenőrzés
if ($password !== $repeat) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ A jelszavak nem egyeznek!';
    header("Location: ../view/register.php");
    exit;
}

// 3. Email duplikáció ellenőrzés
$stmt = $pdo->prepare("SELECT userID FROM users WHERE userEmail = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    $_SESSION['type'] = 'error';
    $_SESSION['message'] = '❌ Ez az email már regisztrálva van!';
    header("Location: ../view/register.php");
    exit;
}

// 4. Jelszó hashelése
$hashed = password_hash($password, PASSWORD_DEFAULT);

// 5. Adatok mentése
$stmt = $pdo->prepare("INSERT INTO users (userName, userEmail, userPasswd) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $hashed]);

// 6. Sikeres regisztráció
$_SESSION['type'] = 'success';
$_SESSION['message'] = '✅ Sikeres regisztráció! Most már bejelentkezhetsz.';
header("Location: ../view/register.php");
exit;

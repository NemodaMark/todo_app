<?php
require_once __DIR__ . '/../config/config.php';

// Minden session változó törlése
session_unset();

// A session teljes megsemmisítése
session_destroy();

// (Opcionálisan) cookie is törölhető:
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Visszairányítás a login oldalra
header("Location: " . BASE_URL . "view/login.php");
exit;

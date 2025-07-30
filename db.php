<?php
/*database informaions*/
$host = 'localhost';
$port = 3307;
$db = 'todo_app';
$user = 'root';
$pass = '';

try {
    /*PDO connection*/
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",$user,$pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
        );
} catch (PDOException $e) {
    die("Adatkapcsolati hiba: - ". $e->getMessage());
}
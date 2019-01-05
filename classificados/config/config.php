<?php
session_start();

$dsn = 'mysql:dbname=bd_classificados;host=localhost';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo 'Falhouu: '.$e->getMessage();
}


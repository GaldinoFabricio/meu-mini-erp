<?php
$host = '192.168.0.3';
$db = 'meu_mini_erp';
$user = 'cebraco';
$pass = '*0cArb&d*';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

<?php
session_start();

$base = "http://localhost/devsbookoo";
$db_name = "devsbook";
$db_host = "localhost";
$db_user = "root";
$db_pass = "root";

try {
    $pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);
} catch (PDOException $e) {
    echo "Erro BD: " . $e->getMessage();
}
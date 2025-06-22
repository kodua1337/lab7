<?php
$host = 'localhost';
$db = 'library_db';
$user = 'root';
$pass = '';
$port = '3306'; // не змінюй навіть якщо у тебе localhost:8080

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}
?>

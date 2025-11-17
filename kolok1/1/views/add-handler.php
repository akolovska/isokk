<?php
session_start();
require '../jwt_helper.php';
require '../database/db.php';
if (!isset($_SESSION['jwt']) && !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../auth/login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = connectDatabase();
    $name = trim($_POST['name']);
    $date = trim($_POST['date']);
    $price = floatval($_POST['price']);
    $type = $_POST['type'];
    $stmt = $db->prepare("INSERT INTO expenses (name, date, type, price) VALUES (:name, :date, :type, :price)");
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':date', $date, SQLITE3_TEXT);
    $stmt->bindValue(':type', $type, SQLITE3_TEXT);
    $stmt->bindValue(':price', $price, SQLITE3_FLOAT);
    $result = $stmt->execute();
    $db->close();

    header("Location: ../index.php");
    exit;
}
else
    die("error");
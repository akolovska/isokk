<?php
session_start();
require 'jwt_helper.php';
require 'db.php';
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = connectDatabase();
    $name = $_POST['name'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $price = intval($_POST['price']);
    $type = $_POST['type'];

    $stmt = $db->prepare("INSERT INTO cameras (name, location, date, price, type) VALUES (:name, :location, :date, :price, :type)");
    $stmt->bindValue(":name", $name, SQLITE3_TEXT);
    $stmt->bindValue(":location", $location, SQLITE3_TEXT);
    $stmt->bindValue(":date", $date, SQLITE3_TEXT);
    $stmt->bindValue(":price", $price, SQLITE3_INTEGER);
    $stmt->bindValue(":type", $type, SQLITE3_TEXT);
    $stmt->execute();
    $db->close();

    header("Location: index.php");
    exit();
}
else {
    echo "error";
}


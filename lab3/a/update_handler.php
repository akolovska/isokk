<?php
session_start();
require 'db.php';
require 'jwt_helper.php';

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $db = connectDatabase();
    $id = intval($_GET['id']);
    $name = $_POST['name'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $price = intval($_POST['price']);
    $type = $_POST['type'];

    $stmt = $db->prepare("UPDATE cameras SET name = :name, location = :location, date = :date, price = :price, type = :price WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->bindValue(":name", $name, SQLITE3_TEXT);
    $stmt->bindValue(":location", $location, SQLITE3_TEXT);
    $stmt->bindValue(":date", $date, SQLITE3_TEXT);
    $stmt->bindValue(":price", $price, SQLITE3_INTEGER);
    $stmt->bindValue(":type", $type, SQLITE3_TEXT);

    $result = $stmt->execute();
    $exercise = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();
}
else {
    echo "error";
}

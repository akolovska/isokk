<?php
session_start();
require 'jwt_helper.php';
require 'db.php';
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $db = connectDatabase();
    $id = intval($_POST['id']);

    $stmt = $db->prepare("DELETE FROM cameras WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();

    header("Location: index.php");
    exit();
}
else {
    echo "error";
}



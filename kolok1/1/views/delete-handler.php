<?php
session_start();
require '../jwt_helper.php';
require '../database/db.php';
if (!isset($_SESSION['jwt']) && !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../auth/login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $db = connectDatabase();
    $id = intval($_POST['id']);
    $stmt = $db->prepare("DELETE FROM expenses WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_TEXT);
    $result = $stmt->execute();
    $expense = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();
    header("Location: ../index.php");
    exit;
}
else
    die("error");
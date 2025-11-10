<?php
include "database_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = connectDatabase();
    $title = $_POST['title'];
    $date = $_POST['date'];
    $priority = intval($_POST['priority']);
    $status = $_POST['status'];

    $stmt = $db->prepare("INSERT INTO exercises (title, date, priority, status) VALUES (:title, :date, :priority, :status)");
    $stmt->bindValue(":title", $title, SQLITE3_TEXT);
    $stmt->bindValue(":date", $date, SQLITE3_TEXT);
    $stmt->bindValue(":priority", $priority, SQLITE3_INTEGER);
    $stmt->bindValue(":status", $status, SQLITE3_TEXT);
    $stmt->execute();
    $db->close();

    header("Location: index.php");
    exit();
}
else {
    echo "error";
}

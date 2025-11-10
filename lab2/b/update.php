<?php
include "database_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $db = connectDatabase();
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $date = $_POST['date'];
    $priority = intval($_POST['priority']);
    $status = $_POST['status'];

    $stmt = $db->prepare("UPDATE exercises SET title = :title, date = :date, priority = :priority, status = :status WHERE id = :id");
    $stmt->bindValue(":title", $title, SQLITE3_TEXT);
    $stmt->bindValue(":date", $date, SQLITE3_TEXT);
    $stmt->bindValue(":priority", $priority, SQLITE3_INTEGER);
    $stmt->bindValue(":status", $status, SQLITE3_TEXT);
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();

    header("Location: index.php");
    exit();
}
else {
    echo "error";
}

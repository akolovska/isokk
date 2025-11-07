<?php
include "database_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = connectDatabase();
    $stmt = $db->prepare("DELETE FROM users WHERE id=:id");
    $stmt->bindValue(":id", $id, SQLITE3_TEXT);
    $stmt->execute();
    $db->close();
    header("Location:index.php");
    exit();
}
else {
    echo "error";
}
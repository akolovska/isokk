<?php
include "database_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $db = connectDatabase();
    $id = intval($_POST['id']);

    $stmt = $db->prepare("DELETE FROM exercises WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();

    header("Location: index.php");
    exit();
} else {
    echo "error";
}

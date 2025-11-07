<?php

include "database_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $age = (int)$_POST['age'] ?? "";
    $db = connectDatabase();
    $stmt = $db->prepare("UPDATE users SET name = :name, email = :email, age = :age WHERE id=:id");
    $stmt->bindValue(":id", $id, SQLITE3_TEXT);
    $stmt->bindValue(":name", $name, SQLITE3_TEXT);
    $stmt->bindValue(":email", $email, SQLITE3_TEXT);
    $stmt->bindValue(":age", $age, SQLITE3_TEXT);
    $stmt->execute();
    $db->close();
    header("Location:index.php");
    exit();
} else {
    echo "error";
}
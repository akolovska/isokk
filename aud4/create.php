<?php

include "database_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = connectDatabase();
    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $age = (int) $_POST['age'] ?? "";
    $stmt = $db -> prepare("INSERT INTO users (name, email, age) VALUES (:name, :email, :age)");
    $stmt->bindValue(":name", $name, SQLITE3_TEXT);
    $stmt->bindValue(":email", $email, SQLITE3_TEXT);
    $stmt->bindValue(":age", $age, SQLITE3_TEXT);
    $result = $stmt->execute();
    if ($result)
        header("Location: index.php");
}
else
    echo "error";
$name = "ana";
$email = "neso";
$age = 22;



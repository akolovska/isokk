<?php
session_start();
require '../database/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $db = connectDatabase();
    $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), SQLITE3_TEXT);
    try {
        $result = $stmt->execute();
        echo "Success <a href='login.php'>Login</a>";
    }
    catch (Exception $e){
        die($e->getMessage());
    }
}
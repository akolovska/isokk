 <?php
 session_start();
 require 'db.php';

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $username = trim($_POST['username']);
     $password = $_POST['password'];
     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

     $db = connectDatabase();
     $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, 'user')");
     $stmt->bindValue(":username", $username, SQLITE3_TEXT);
     $stmt->bindValue(":password", $password, SQLITE3_TEXT);

     try {
         $stmt->execute();
         echo "Register success! <a href='login.php'>Log in here</a>";
     } catch (Exception $e) {
         die("Error: " . $e->getMessage());
     }
 }
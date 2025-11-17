<?php
session_start();
require '../jwt_helper.php';
require '../database/db.php';
if (isset($_SESSION['jwt']) && decodeJWT($_SESSION['jwt'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<form method="post" action="login-handler.php">
    <label for="username">Username</label>
    <input id="username" type="text" required name="username">
    <br>
    <label for="password">Password</label>
    <input id="password" type="password" required name="password">
    <button type="submit">Submit</button>
</form>
<button><a href="register.php">Register</a> </button>
</body>
</html>

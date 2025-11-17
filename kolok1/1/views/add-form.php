<?php
session_start();
require '../jwt_helper.php';
if (!isset($_SESSION['jwt']) && !decodeJWT($_SESSION['jwt'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form action="add-handler.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <br />
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <br />
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" required>
    <br />
    <label for="type">Payment type</label>
    <select name="type" id="type">
        <option value="cash">cash</option>
        <option value="card">card</option>
    </select>
    <br />
    <button type="submit">Add Expense</button>
</form>
</body>
</html>
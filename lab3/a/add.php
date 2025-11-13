<?php
include "db.php";
session_start();
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Camera</title>
</head>
<body>
<form action="add_handler.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required>
    <br />
    <label for="location">Location:</label>
    <input type="text" name="location" id="location" required>
    <br />
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <br />
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" required>
    <br />
    <label for="type">Type:</label>
    <select name="type" id="type" class="form-control">
        <option value="indoor">Indoor</option>
        <option value="outdoor">Outdoor</option>
    </select>
    <br />
    <button type="submit">Add Camera</button>
</form>
</body>
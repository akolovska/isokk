<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $year = intval($_POST['year']);
    $db = connectDatabase();

    $stmt = $db->prepare("INSERT INTO films (title, genre, year) VALUES (:title, :genre, :year)");
    $stmt->bindValue(":title", $title, SQLITE3_TEXT);
    $stmt->bindValue(":genre", $genre, SQLITE3_TEXT);
    $stmt->bindValue(":year", $year, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();

    header("Location: index.php");
    exit();
}
else {
    echo "error";
}

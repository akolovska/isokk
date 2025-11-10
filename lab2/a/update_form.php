<?php
include "database_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $db = connectDatabase();
    $id = intval($_GET['id']);

    $stmt = $db->prepare("SELECT * FROM films WHERE id = :id");
    $stmt->bindValue(":id", $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $film = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();
}
else {
    die("No film ID provided.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Film</title>
</head>
<body>
<h1>Update Film</h1>

<?php if ($film): ?>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($film['id']); ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($film['title']); ?>" required><br><br>
        <label for="genre">Genre:</label>
        <input type="text" name="genre" value="<?php echo htmlspecialchars($film['genre']); ?>" required><br><br>
        <label for="year">Year:</label>
        <input type="number" name="year" value="<?php echo htmlspecialchars($film['year']); ?>" required><br><br>
        <button type="submit">Update Student</button>
    </form>
<?php else: ?>
    <p>Film not found.</p>
<?php endif; ?>
</body>
</html>
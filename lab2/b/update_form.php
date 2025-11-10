<?php
include "database_connection.php";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $db = connectDatabase();
    $id = intval($_GET['id']);

    $stmt = $db->prepare("SELECT * FROM exercises WHERE id = :id");
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $exercise = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();
} else {
    die("No exercise id provided");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Exercise</title>
</head>
<body>
<h1>Update Exercise</h1>

<?php if ($exercise): ?>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($exercise['id']); ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($exercise['title']); ?>" required><br><br>
        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($exercise['date']); ?>" required><br><br>
        <label for="priority">Priority:</label>
        <input type="number" name="priority" value="<?php echo htmlspecialchars($exercise['priority']); ?>" required><br><br>
        <label for="status">Status:</label>
        <input type="text" name="status" value="<?php echo htmlspecialchars($exercise['status']); ?>" required><br><br>
        <button type="submit">Update Exercise</button>
    </form>
<?php else: ?>
    <p>Status not found.</p>
<?php endif; ?>
</body>
</html>
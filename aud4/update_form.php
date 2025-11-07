<?php
include "database_connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $db = connectDatabase();
    $stmt = $db->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->bindValue(":id", $id, SQLITE3_TEXT);
    $result = $stmt->execute();
    $student = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();
}
else {
    echo "error";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Student</title>
</head>
<body>
<h1>Update Student</h1>

<?php if ($student): ?>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br><br>
        <label for="age">Age:</label>
        <input type="number" name="age" value="<?php echo htmlspecialchars($student['age']); ?>" required><br><br>
        <button type="submit">Update Student</button>
    </form>
<?php else: ?>
    <p>Student not found.</p>
<?php endif; ?>
</body>
</html>
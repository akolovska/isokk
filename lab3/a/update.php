<?php
session_start();
require 'db.php';
require 'jwt_helper.php';

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: login.php");
    exit;
}
$db = connectDatabase();
$id = intval($_GET['id']);

$stmt = $db->prepare("SELECT * FROM cameras WHERE id = :id");
$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
$result = $stmt->execute();
$camera = $result->fetchArray(SQLITE3_ASSOC);
$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Camera</title>
</head>
<body>
<h1>Update Camera</h1>

<?php if ($camera): ?>
    <form action="update_handler.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($camera['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($camera['name']); ?>" required><br><br>
        <label for="name">Location:</label>
        <input type="text" name="location" value="<?php echo htmlspecialchars($camera['location']); ?>" required><br><br>
        <label for="date">Date:</label>
        <input type="date" name="date" value="<?php echo htmlspecialchars($camera['date']); ?>" required><br><br>
        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo htmlspecialchars($camera['price']); ?>" required><br><br>
        <label for="type">Type:</label>
        <input type="text" name="type" value="<?php echo htmlspecialchars($camera['type']); ?>" required><br><br>
        <button type="submit">Update Camera</button>
    </form>
<?php else: ?>
    <p>Camera not found.</p>
<?php endif; ?>
</body>
</html>
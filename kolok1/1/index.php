<?php
session_start();
require 'jwt_helper.php';
require 'database/db.php';
if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: auth/login.php");
    exit;
}
$db = connectDatabase();
$result = $db->query("SELECT * FROM expenses")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<button><a href="views/add-form.php">Add an expense</a></button>
<table>
    <thead>
    <tr>
        <td>Id</td>
        <td>Name</td>
        <td>Date</td>
        <td>Price</td>
        <td>Type</td>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['id']);?></td>
        <td><?php echo htmlspecialchars($row['name']);?></td>
        <td><?php echo htmlspecialchars($row['date']);?></td>
        <td><?php echo htmlspecialchars($row['price']);?></td>
        <td><?php echo htmlspecialchars($row['type']);?></td>
        <td>
            <form action="views/edit-form.php" method="get">
                <input type="hidden" value="<?php echo $row['id']; ?>" name="id">
                <button type="submit">Edit</button>
            </form>
        </td>
        <td>
            <?php if ($row['price'] < 100): ?>
            <form action="views/delete-handler.php" method="post">
                <input type="hidden" value="<?php echo $row['id']; ?>" name="id">
                <button type="submit">Delete</button>
            </form>
            <?php else:
            echo "Cannot delete";
            endif ?>
        </td>
    </tr>
    </tbody>
<?php endwhile; ?>
</table>

</body>
</html>

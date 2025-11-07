<?php
include "database_connection.php";
$db = connectDatabase();
$query = "SELECT * FROM films";
$result = $db->query($query);
if (!$result) {
    die("Error fetching students: " . $db->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
<div style="display: flex; align-items: center; justify-content: space-between">
    <h1>Film List</h1>
    <a href="create_form.php">
        Add Film
    </a>
</div>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Genre</th>
        <th>Year</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result): ?>
        <?php while ($film = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($film['id']); ?></td>
                <td><?php echo htmlspecialchars($film['title']); ?></td>
                <td><?php echo htmlspecialchars($film['genre']); ?></td>
                <td><?php echo htmlspecialchars($film['year']); ?></td>
                <td>
                    <form action="delete.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $film['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form action="update_form.php" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $film['id']; ?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No films found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>
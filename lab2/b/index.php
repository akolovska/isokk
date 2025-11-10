<?php
include "database_connection.php";
$db = connectDatabase();
$filter = $_GET['filter'] ?? 'id';
$query = "SELECT * FROM exercises ORDER BY $filter COLLATE NOCASE";
$result = $db->query($query);
if (!$result) {
    die("Error fetching exercises: " . $db->lastErrorMsg());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Exercises</title>
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
    <h1>Exercises List</h1>
    <a href="create_form.php">Add Exercise</a>

    <form method="get">
        <label for="filter">Sort by:
            <select name="filter" id="filter" onchange="this.form.submit()">
                <option value="id" <?= $filter === 'id' ?>>Id</option>
                <option value="title" <?= $filter === 'title' ?>>Title</option>
                <option value="date" <?= $filter === 'date' ?>>Date</option>
                <option value="priority" <?= $filter === 'priority' ?>>Priority</option>
                <option value="status" <?= $filter === 'status' ?>>Status</option>
            </select>
        </label>
    </form>
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Date</th>
        <th>Priority</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($exercise = $result->fetchArray(SQLITE3_ASSOC)): ?>
        <tr>
            <td><?= htmlspecialchars($exercise['id']); ?></td>
            <td><?= htmlspecialchars($exercise['title']); ?></td>
            <td><?= htmlspecialchars($exercise['date']); ?></td>
            <td><?= htmlspecialchars($exercise['priority']); ?></td>
            <td><?= htmlspecialchars($exercise['status']); ?></td>
            <td>
                <form action="delete.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $exercise['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
                <form action="update_form.php" method="get" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $exercise['id']; ?>">
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</body>
</html>

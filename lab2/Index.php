<?php
require 'db.php';

// Бришење на задача
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $db->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// Селектирање на сите задачи
$stmt = $db->query("SELECT * FROM tasks ORDER BY id DESC");
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <title>Листа на задачи</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        a.button { background: #4CAF50; color: white; padding: 6px 10px; text-decoration: none; border-radius: 4px; }
        a.delete { background: #f44336; }
        .add-btn { margin: 20px; display: inline-block; background: #2196F3; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Листа на задачи</h2>

<a class="add-btn" href="create.php">+ Додади нова задача</a>

<table>
    <tr>
        <th>Наслов</th>
        <th>Рок</th>
        <th>Приоритет</th>
        <th>Статус</th>
        <th>Акции</th>
    </tr>
    <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['due_date']) ?></td>
            <td><?= htmlspecialchars($task['priority']) ?></td>
            <td><?= htmlspecialchars($task['status']) ?></td>
            <td>
                <a class="button" href="update.php?id=<?= $task['id'] ?>">Ажурирај</a>
                <a class="button delete" href="index.php?delete=<?= $task['id'] ?>" onclick="return confirm('Дали сте сигурни дека сакате да ја избришете задачата?');">Избриши</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Film</title>
</head>
<body>
<form action="create.php" method="POST">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required>
    <br />
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <br />
    <label for="priority">Priority:</label>
    <input type="number" name="priority" id="priority" required>
    <br />
    <label for="status">Status:</label>
    <input type="text" name="status" id="status" required>
    <br />
    <button type="submit">Add Exercise</button>
</form>
</body>
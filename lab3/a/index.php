<?php
session_start();
require 'jwt_helper.php';

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $db = connectDatabase();
    $query = "SELECT * FROM cameras";
    $result = $db->query($query);
    if (!$result) {
        die("Error fetching cameras: " . $db->lastErrorMsg());
    }
}
else {
    die("error");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cameras</title>
    <!-- Link to Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 font-sans">

<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-semibold text-center text-green-600 mb-4">Welcome</h1>
        <a href="add.php" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add a new camera</a>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Date</th>
                <th>Price</th>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($camera = $result->fetchArray(SQLITE3_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($camera['id']); ?></td>
                    <td><?= htmlspecialchars($camera['name']); ?></td>
                    <td><?= htmlspecialchars($camera['location']); ?></td>
                    <td><?= htmlspecialchars($camera['date']); ?></td>
                    <td><?= htmlspecialchars($camera['price']); ?></td>
                    <td><?= htmlspecialchars($camera['type']); ?></td>
                    <td>
                        <form action="delete.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $camera['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                        <form action="update.php" method="get" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $camera['id']; ?>">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>

        <div class="text-center">
            <a href="logout_handler.php" class="text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md text-lg">
                Logout
            </a>
        </div>
    </div>
</div>

</body>

</html>

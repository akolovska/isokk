<?php
try {
    $dsn = 'sqlite:' . __DIR__ . '/database.sqlite';
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        password TEXT NOT NULL,
        role TEXT NOT NULL
    )";
    $pdo->exec($query);
}
catch (PDOException $e) {
    die("Neuspesno povrzuvanje so baza " . $e->getMessage());
}

<?php
$db = new SQLite3('/database/mydb.db');
$db->exec('
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        age INTEGER
    )
');
if ($db)
    echo "Database connected";
else
    echo "Database not connected " . $db->lastErrorMsg();

function connectDatabase(): SQLite3 {
    return new SQLite3(__DIR__ . '/database/mydb.db');
}

$db->close();

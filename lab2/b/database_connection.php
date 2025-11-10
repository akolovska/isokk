<?php

$db = new SQLite3('../../database/exercises.sqlite');

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS exercise (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    date DATE NOT NULL,
    priority INTEGER NOT NULL,
    status TEXT NOT NULL
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();
function connectDatabase(): SQLite3
{
    return new SQLite3('../../database/exercises.sqlite');
}
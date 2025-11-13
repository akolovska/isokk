<?php

try {
    $db = new SQLite3(__DIR__ . '/../../database/cameras.sqlite');
    $query = "CREATE TABLE IF NOT EXISTS cameras (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    location TEXT NOT NULL,
    date DATE NOT NULL,
    price FLOAT NOT NULL,
    type TEXT NOT NULL CHECK ( type IN ('indoor', 'outdoor') )
)";
    $db->exec($query);
}
catch (Exception $e) {
    die($e->getMessage());
}
function connectDatabase(): SQLite3
{
    return new SQLite3('../../database/cameras.sqlite');
}
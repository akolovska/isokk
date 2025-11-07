<?php

//function connectDatabase(): SQLite3 {
//    $path = __DIR__ . '/database/lab1.sqlite';
//    $db = new SQLite3($path);
//    $db->exec("CREATE TABLE IF NOT EXISTS films (
//        id INTEGER PRIMARY KEY AUTOINCREMENT,
//        title TEXT NOT NULL,
//        genre TEXT NOT NULL,
//        year INTEGER NOT NULL
//    )");
//    return $db;
//}

$db = new SQLite3(__DIR__ . '/database/films.sqlite');

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS films (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    genre TEXT NOT NULL,
    year INTEGER NOT NULL
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();
function connectDatabase(): SQLite3 {
    return new SQLite3(__DIR__ . '/database/films.sqlite');
}
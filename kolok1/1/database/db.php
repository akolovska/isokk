<?php
$db = new SQLite3(__DIR__ . '/app.sqlite');

$db->exec("CREATE TABLE IF NOT EXISTS expenses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    date DATE NOT NULL,
    price FLOAT NOT NULL,
    type TEXT NOT NULL CHECK (type in ('cash', 'card'))
)");
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    password TEXT NOT NULL
)");

function connectDatabase() {
    return new SQLite3(__DIR__ . '/app.sqlite');
}
<?php

$dbPath = __DIR__ . '/db.sqlite';
$pdo = new PDO("sqlite:{$dbPath}");

$pdo->exec("CREATE TABLE IF NOT EXISTS videos (id INTEGER PRIMARY KEY, url TEXT, title TEXT );");
$pdo->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, email TEXT, password TEXT);");
$pdo->exec("ALTER TABLE videos ADD COLUMN image_path TEXT;");

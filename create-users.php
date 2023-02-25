<?php

$dbPath = __DIR__ . '/db.sqlite';
$pdo = new PDO("sqlite:{$dbPath}");

$email = $argv[1];
$password = $argv[2];

$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$hash = password_hash($password, PASSWORD_ARGON2I);

if (!$email) {
    echo "E-mail inválido!" . PHP_EOL;
    return;
}

$query = "INSERT INTO users (email, password) VALUES (?, ?);";
$stmt = $pdo->prepare($query);
$stmt->bindValue(1, $email);
$stmt->bindValue(2, $hash);
$resp = $stmt->execute();

if ($resp) {
    echo "Usuário Cadastrado com Sucesso!" . PHP_EOL;
} else {
    echo "Erro ao Cadastrar um Usuário" . PHP_EOL;
}



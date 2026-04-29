<?php
require 'config.php';

if (!$conn) {
    exit("Błąd połączenia z bazą.");
}

$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$age = $_POST['age'];

if ($age < 18) {
    exit("Musisz mieć minimum 18 lat.");
}

$check = pg_query_params($conn,
"SELECT id FROM table001 WHERE email = $1",
[$email]);

if (pg_num_rows($check) > 0) {
    exit("Email już istnieje.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$result = pg_query_params($conn,
"INSERT INTO table001 (name, surname, email, password, age)
 VALUES ($1,$2,$3,$4,$5) RETURNING id",
[$name, $surename, $email, $hashedPassword, $age]);

$user = pg_fetch_assoc($result);
$user_id = $user['id'];

$code = strtoupper(substr(md5(rand()),0,8));

pg_query_params($conn,
"INSERT INTO qr_codes (user_id, code)
 VALUES ($1,$2)",
[$user_id, $code]);

header("Location: index.html");
exit();
?>
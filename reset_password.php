<?php
require 'config.php';

$email = $_GET['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!isset($_POST['password'])) {
    exit("Brak hasła.");
}

$newPassword = trim($_POST['password']);
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);

    $update = "UPDATE table001 SET password = $1 WHERE email = $2";
    pg_query_params($conn, $update, [$hash, $email]);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Nowe Hasło</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Nowe Hasło</h1>

<form method="POST">

<input type="password" name="password" placeholder="Nowe hasło" required><br><br>

<button type="submit">Zmień</button>

</form>

</body>
</html>
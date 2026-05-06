<?php
require 'config.php';

if (!isset($_GET['token'])) {
    exit("Brak tokena");
}

$token = $_GET['token'];

// ищем токен
$query = pg_query_params($conn,
    "SELECT * FROM password_resets WHERE token = $1",
    [$token]
);

$data = pg_fetch_assoc($query);

if (!$data) {
    exit("Nieprawidłowy token");
}

// проверка времени
if ($data['expires_at'] < date('Y-m-d H:i:s')) {
    exit("Token wygasł");
}

$email = $data['email'];


if (isset($_POST['new_password'])) {

    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    pg_query_params($conn,
        "UPDATE table001 SET password = $1 WHERE email = $2",
        [$new_password, $email]
    );

    echo "Hasło zmienione!";
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


</body>
</html>
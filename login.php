<?php
session_start();

require 'config.php';

if (!$conn) {
    exit("Błąd połączenia z bazą.");
}

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    exit("Brak danych.");
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$query = "SELECT * FROM table001 WHERE email = $1";
$result = pg_query_params($conn, $query, [$email]);

if ($result && pg_num_rows($result) > 0) {

    $user = pg_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {

        $_SESSION['user'] = $email;
        header("Location: dashboard.php");
        exit();

    } else {
        echo "Nieprawidłowe hasło.";
    }

} else {
    echo "Nie znaleziono użytkownika.";
}
?>
<?php
require 'config.php';

if (isset($_POST['email'])) {

    $email = trim($_POST['email']);

//проверяем есть ли пользователь
    $check = pg_query_params($conn,
        "SELECT id FROM table001 WHERE email = $1",
        [$email]
    );

    if (pg_num_rows($check) == 0) {
        exit("Nie znaleziono użytkownika");
    }

    // генерируем токен
    $token = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    pg_query_params($conn,
        "INSERT INTO password_resets (email, token, expires_at)
         VALUES ($1, $2, $3)",
        [$email, $token, $expires]
    );

    // пока просто выводим ссылку (вместо email)
    echo "Kliknij link:<br>";
    echo "<a href='reset_password.php?token=$token'>Resetuj hasło</a>";
}
?>
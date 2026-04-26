<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");

// подключение к PostgreSQL
$conn = pg_connect("host=127.0.0.1 port=5432 dbname=postgres user=postgres password=1234");

if (!$conn) {
    echo "Ошибка подключения к базе";
    exit;
}

// проверяем есть ли данные
if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // безопасный запрос
    $query = "SELECT * FROM table001 WHERE email = $1 AND password = $2";
    $result = pg_query_params($conn, $query, array($email, $password));

    if ($result && pg_num_rows($result) > 0) {

        // сохраняем пользователя в сессию
        $_SESSION['user'] = $email;

        // переход на страницу
        header("Location: dashboard.php");
        exit;

    } else {
        echo "NIE PRAWIDLOWE HASLO LUB EMAIL";
    }

} else {
    echo "Нет данных";
}
?>
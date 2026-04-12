<?php
header("Content-Type: text/html; charset=UTF-8");

// подключение к PostgreSQL
$conn = pg_connect("host=localhost dbname=postgres user=postgres password=Jojoklar1!");

// проверка подключения
if (!$conn) {
    echo "Ошибка подключения к базе";
    exit;
}

// проверяем есть ли данные
if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // запрос к базе
    $query = "SELECT * FROM table001 WHERE email='$email' AND password='$password'";
    $result = pg_query($conn, $query);

    if (pg_num_rows($result) > 0) {
        echo "УСПЕШНЫЙ ВХОД";
    } else {
        echo "НЕПРАВИЛЬНЫЙ EMAIL ИЛИ ПАРОЛЬ";
    }

} else {
    echo "Нет данных";
}
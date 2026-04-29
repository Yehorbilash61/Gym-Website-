<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}

require 'config.php';

$email = $_SESSION['user'];

if (!isset($_POST['type'])) {
    exit("Brak typu abonamentu");
}

$type = $_POST['type'];

// найти пользователя
$user_query = "SELECT * FROM table001 WHERE email = $1";
$user_result = pg_query_params($conn, $user_query, [$email]);
$user = pg_fetch_assoc($user_result);

$user_id = $user['id'];

// проверить есть ли абонемент
$check_query = "SELECT * FROM memberships WHERE user_id = $1";
$check_result = pg_query_params($conn, $check_query, [$user_id]);
$membership = pg_fetch_assoc($check_result);
if ($membership) {

    $today = date('Y-m-d');
    $end = $membership['end_date'];

    if ($end >= $today) {

        $days_left = floor((strtotime($end) - strtotime($today)) / 86400);

        if ($days_left > 30) {
            echo "Za wcześnie na przedłużenie abonamentu!";
            exit();
        }
    }
}

if ($type == "monthly") {
    $new_end = date('Y-m-d', strtotime('+1 month'));
} else {
    $new_end = date('Y-m-d', strtotime('+1 year'));
}
if ($membership) {

    $old_end = $membership['end_date'];
    $today = date('Y-m-d');

    // если абонемент еще активен
    if ($old_end >= $today) {

        if ($type == "monthly") {
            $new_end = date('Y-m-d', strtotime($old_end . ' +1 month'));
        } else {
            $new_end = date('Y-m-d', strtotime($old_end . ' +1 year'));
        }

        $update = "UPDATE memberships 
                   SET end_date = $1, type = $2
                   WHERE user_id = $3";

        pg_query_params($conn, $update, [$new_end, $type, $user_id]);

    } else {

        // если закончился
        $start = $today;

        if ($type == "monthly") {
            $new_end = date('Y-m-d', strtotime('+1 month'));
        } else {
            $new_end = date('Y-m-d', strtotime('+1 year'));
        }

        $update = "UPDATE memberships 
                   SET start_date = $1, end_date = $2, type = $3
                   WHERE user_id = $4";

        pg_query_params($conn, $update, [$start, $new_end, $type, $user_id]);
    }

} else {

    $start = date('Y-m-d');

    if ($type == "monthly") {
        $new_end = date('Y-m-d', strtotime('+1 month'));
    } else {
        $new_end = date('Y-m-d', strtotime('+1 year'));
    }

    $insert = "INSERT INTO memberships (user_id, type, start_date, end_date)
               VALUES ($1, $2, $3, $4)";

    pg_query_params($conn, $insert, [$user_id, $type, $start, $new_end]);
}
header("Location: dashboard.php");
exit();
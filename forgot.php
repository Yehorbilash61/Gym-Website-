<?php
require 'config.php';

if (!isset($_POST['email'])) {
    exit("Brak danych.");
}

$email = trim($_POST['email']);

$query = "SELECT * FROM table001 WHERE email = $1";
$result = pg_query_params($conn, $query, [$email]);

if (pg_num_rows($result) > 0) {

    header("Location: reset_password.php?email=$email");
    exit();

}

 else {
header("Location: forgot.html");
exit();

}
?>
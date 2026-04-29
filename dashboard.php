<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}

$conn = pg_connect("host=127.0.0.1 port=5432 dbname=postgres user=postgres password=1234");

$email = $_SESSION['user'];

// получаем пользователя
$query = "SELECT * FROM table001 WHERE email = $1";
$result = pg_query_params($conn, $query, [$email]);

$user = pg_fetch_assoc($result);

$user_id = $user['id'];

// ищем абонемент
$membership_query = "SELECT * FROM memberships WHERE user_id = $1";
$membership_result = pg_query_params($conn, $membership_query, [$user_id]);

$membership = pg_fetch_assoc($membership_result);

$status = "Brak abonamentu";
$days_left = 0;

if ($membership) {

    $today = date('Y-m-d');
    $end = $membership['end_date'];

    if ($end >= $today) {
        $status = "ACTIVE";

        $diff = strtotime($end) - strtotime($today);
        $days_left = floor($diff / 86400);

    } else {
        $status = "EXPIRED";
    }
}


?>

<h2>Witaj, <?php echo $user['name']; ?> 👋</h2>

<p>Email: <?php echo $user['email']; ?></p>
<p>Wiek: <?php echo $user['age']; ?></p>


<h3>Abonament</h3>
<p>Status: <?php echo $status; ?></p>

<?php if ($status == "ACTIVE"): ?>
<p>Pozostało dni: <?php echo $days_left; ?></p>
<?php endif; ?>

<?php if ($membership): ?>
    <p>Typ: <?php echo $membership['type']; ?></p>
    <p>Start: <?php echo $membership['start_date']; ?></p>
    <p>Koniec: <?php echo $membership['end_date']; ?></p>
<?php else: ?>
    <p>Brak abonamentu</p>
<?php endif; ?>

<form action="logout.php" method="POST">
    <button type="submit">Wyloguj się</button>
</form>

<h3>Kup abonament</h3>

<form action="buy_membership.php" method="POST">
    <select name="type">
        <option value="monthly">Monthly</option>
        <option value="yearly">Yearly</option>
    </select>
    <button type="submit">Kup</button>
</form>
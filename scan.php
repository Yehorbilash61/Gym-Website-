<?php
$conn = pg_connect("host=127.0.0.1 port=5432 dbname=postgres user=postgres password=1234");

if (isset($_POST['code'])) {

    $code = $_POST['code'];

    $query = "SELECT * FROM qr_codes WHERE code = $1";
    $result = pg_query_params($conn, $query, [$code]);

    $qr = pg_fetch_assoc($result);

    if ($qr) {

        $user_id = $qr['user_id'];

        $membership_query = "SELECT * FROM memberships WHERE user_id = $1";
        $membership_result = pg_query_params($conn, $membership_query, [$user_id]);

        $membership = pg_fetch_assoc($membership_result);

        if ($membership && $membership['end_date'] >= date('Y-m-d')) {
            $message = "ACCESS GRANTED ✅";
        } else {
            $message = "NO ACTIVE MEMBERSHIP ❌";
        }

    } else {
        $message = "INVALID QR CODE ❌";
    }
}
?>

<h1>QR Scanner</h1>

<form method="POST">
    <input type="text" name="code" placeholder="Enter QR code">
    <button type="submit">Scan</button>
</form>

<?php if (isset($message)): ?>
<h2><?php echo $message; ?></h2>
<?php endif; ?>
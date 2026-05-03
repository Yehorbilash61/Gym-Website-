<?php
require 'config.php';

$message = "";

if (isset($_POST['code'])) {

    $code = trim($_POST['code']);

    $query = "SELECT * FROM qr_codes WHERE code = $1";
    $result = pg_query_params($conn, $query, [$code]);

    if ($result && pg_num_rows($result) > 0) {

        $qr = pg_fetch_assoc($result);
        $user_id = $qr['user_id'];

        $qr_query = "SELECT * FROM qr_codes WHERE user_id = $1";
$qr_result = pg_query_params($conn, $qr_query, [$user_id]);
$qr = pg_fetch_assoc($qr_result);

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
<h2><?php echo $message; ?></h2><?php endif; ?>
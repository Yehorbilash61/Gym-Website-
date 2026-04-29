<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}

$conn = pg_connect("host=127.0.0.1 port=5432 dbname=postgres user=postgres password=1234");

$query = "SELECT * FROM table001 ORDER BY id";
$result = pg_query($conn, $query);
?>

<h1>Admin Panel</h1>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Age</th>
</tr>

<?php while ($row = pg_fetch_assoc($result)): ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['age']; ?></td>
</tr>
<?php endwhile; ?>

</table>
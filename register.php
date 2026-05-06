<?php
require 'config.php';

$error = "";

// если форма отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $age = $_POST['age'];

    if ($age < 18) {
        $error = "Musisz mieć minimum 18 lat";
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        pg_query_params($conn,
            "INSERT INTO table001 (name, surname, email, password, age)
             VALUES ($1,$2,$3,$4,$5)",
            [$name, $surname, $email, $hashedPassword, $age]
        );

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Rejestracja</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<h1>Zarejestruj się</h1>

<form method="POST">

<input type="text" name="name" placeholder="Imię" required><br><br>

<input type="text" name="surname" placeholder="Nazwisko" required><br><br>

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Hasło" required><br><br>

<input type="number" name="age" placeholder="Wiek" required><br><br>

<button type="submit">Zarejestruj się</button>

<a href="index.php">Powrót do logowania</a>

<?php if ($error): ?>
<p style="color:darkred;"><?php echo $error; ?></p>
<?php endif; ?>

</form>


</body>
</html>
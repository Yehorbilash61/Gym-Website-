

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   
<h1>polyfwl gym</h1>

<form action="login.php" method="POST">

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Haslo:</label><br>
    

<div class="password-box">
    <input type="password" name="password" id="password" required>
    <button type="button" onclick="togglePassword()">👁</button>
</div>

<br>

<a href="forgot.html">Zapomniałeś hasła?</a>
<br><br>

  <button type="submit">Zaloguj sie</button>

  <?php if (isset($_GET['error'])): ?>
    <p style="color:lightcoral;">Nieprawidłowe hasło lub email</p>
  <?php endif; ?>

  <a href="register.php">Rejestracja</a>

</form>



<script>
function togglePassword() {
    let password = document.getElementById("password");

    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}
</script>



</body>
</html>


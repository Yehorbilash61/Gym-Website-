<?php
// Pobranie danych z formularza
$name = $_POST['name'] ?? '';
$trainer = isset($_POST['trainer']) ? 'Tak' : 'Nie';
$payment = $_POST['payment'] ?? '';

// Wyświetlenie informacji dla użytkownika
echo "<h1>Dziękujemy za zapisanie się!</h1>";
echo "<p>Imię i nazwisko: $name</p>";
echo "<p>Trener: $trainer</p>";
echo "<p>Metoda płatności: $payment</p>";
?>

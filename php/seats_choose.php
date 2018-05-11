<?php #Jeśli użytkownik zalogowany
session_start();

if(!isset($_SESSION['zalogowany'])){
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Wybór miejsca</title>

    <link rel="stylesheet" href="./style.css" type="text/css"/>
</head>

<body>
    <div class = "header" ><img src="logo.png" /><h1>System rezerwacji biletów lotniczych</h1></div>
    <div class = "navbar" ><ul>
        <li><p>Witaj <?php echo $_SESSION['imie'].' '.$_SESSION['nazwisko'] ?>!</p></li>
        <li><a href="user_s_account.php">Panel klienta</a></li>
        <li><a href="history.php">Moje rezerwacje</a></li>
        <li><a href="Rezerwacja.php">Szukaj lotu</a></li>
        <li><a href="logout.php">Wylogowanie</a></li>
    </ul></div>
<?php

$idlotu = $_GET['id'];

echo<<<END
<br>
<div class="standardframe">
<h3>Rezerwacja miejsca</h3>
<p>Lot nr $idlotu</p>
<form action="booking.php" method="post">
	<p>Numer miejsca:
	<input type="number" name="numer_miejsca" />
	<input type="hidden" name="idlotu" value="$idlotu"/>
	<input type="submit" value="Rezerwuj"/>
    </p>
</form>
</div>
END;

?>

</body>
</html>
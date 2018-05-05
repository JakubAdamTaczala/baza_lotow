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

<?php
echo '<p>Witaj '.$_SESSION['imie'].' '.$_SESSION['nazwisko'].' [<a href="logout.php">Wyloguj się!</a>]<p/>';
echo '<p>E-mail: '.$_SESSION['mail'].'<p/>';
echo '<p>Tele.: '.$_SESSION['telefon'].'<p/>';

?>


<?php
ini_set("display_errors", 1);
require_once 'connect.php';
$polaczenie = mysqli_connect($host, $db_user, $db_password);
mysqli_query($polaczenie, "SET CHARSET utf8");
mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
mysqli_select_db($polaczenie, $db_name);
$idlotu = $_GET['id'];
$rezultat=$polaczenie->query("SELECT WOLNE_MIEJSCA FROM LOTY WHERE ID_LOTU='$idlotu'");
$row = mysqli_fetch_assoc($rezultat);

$zera = "";
while(strlen($zera) < 18)
    $zera = "0".$zera;
echo $zera;

echo<<<END
<br>
<form action="booking.php" method="post">
	<label>Wpisz numer miejsca które chcesz zarezerwować:</label>
	<input type="number" name="numer_miejsca" />
	<input type="hidden" name="idlotu" value="$idlotu"/>
	<input type="submit" value="Rezerwuj"/>
</form>

END;
$polaczenie->close();
?>

[<a href="/Rezerwacja.php">Szukaj lotów</a>]
[<a href="/user_s_account.php">Panel klienta</a>]
</body>
</html>
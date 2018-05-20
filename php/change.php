<?php #Jeśli użytkownik zalogowany
session_start();

if(!isset($_SESSION['zalogowany'])){
    header('Location: index.php');
    exit();
}

if($_SESSION['USER'] == "STAFF"){
    header('Location: staff_s_account.php');
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Status rezerwacji</title>

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
if(!isset($_SESSION['zmiany'])){
    header('Location: user_s_account.php');
}

if($_SESSION['zmiany'] == "OPERACJA UDANA"){
    echo '<div class = "standardframe" style="background: #8cf49d">';
    $comment="Zmiany zostały zachowane.";
}
else{
    echo '<div class = "standardframe" style="background: #fb8787">';
    $comment="Brak uprawnień!";
}

?>

<h3>Status: <?php echo $_SESSION['zmiany']?></h3>
<p><?php echo $comment ?></p>
<?php
    unset($_SESSION['zmiany']);
    echo "<p><a href=user_s_account.php>Powrót</a></p>";
?>
</div>

</body>
</html>
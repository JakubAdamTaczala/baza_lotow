<?php
/**
 * Created by PhpStorm.
 * User: Jakub Taczała
 * Date: 22.04.2018
 * Time: 15:31
 */
?>

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
    <title>Rezerwacja biletów lotniczych</title>

    <link rel="stylesheet" href="./style.css" type="text/css"/>
</head>

<body>
<?php
    echo '<p>Witaj '.$_SESSION['imie'].' '.$_SESSION['nazwisko'].' [<a href="logout.php">Wyloguj się!</a>]<p/>';
    echo '<p>E-mail: '.$_SESSION['mail'].'<p/>';
    echo '<p>Tele.: '.$_SESSION['telefon'].'<p/>';
    echo "to jest panel user";

?>
</body>
</html>
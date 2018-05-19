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

    <title>Rezerwacja biletów lotniczych</title>

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
<div class = "content">

    <div class="standardframe">
    <h3>Moje dane</h3>
<table>
<?php
    echo '<tr><td>Imię: </td><td>'.$_SESSION['imie'].'</td></tr>';
    echo '<tr><td>Nazwisko: </td><td>'.$_SESSION['nazwisko'].'</td></tr>';
    echo '<tr><td>E-mail: </td><td>'.$_SESSION['mail'].'</td></tr>';
    echo '<tr><td>Numer telefonu: </td><td>'.$_SESSION['telefon'].'</td></tr>';

?>
</table>
</div>
    <h3>Edycja danych: TODO</h3>

</div>
</body>
</html>
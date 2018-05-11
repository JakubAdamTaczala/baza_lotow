<?php
/**
 * Created by PhpStorm.
 * User: Jakub Taczała
 * Date: 03.05.2018
 * Time: 16:25
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

<div class ="content">
<?php
ini_set("display_errors", 0);
require_once 'connect.php';
$polaczenie = mysqli_connect($host, $db_user, $db_password);
mysqli_query($polaczenie, "SET CHARSET utf8");
mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
mysqli_select_db($polaczenie, $db_name);

$rezultat=@$polaczenie->query("SELECT NAZWA_LINII, ID_LOTU, SKAD, DATA_ODLOTU, GODZINA_ODLOTU, DOKAD, DATA_PRZYLOTU, CZAS_PRZYLOTU, WOLNE_MIEJSCA, Uwagi FROM LOTY, LINIE_LOTNICZE, SAMOLOTY WHERE SAMOLOTY.ID_LINII=LINIE_LOTNICZE.ID_LINII AND LOTY.ID_SAMOLOTU=SAMOLOTY.ID_SAMOLOTU");
$ile=$rezultat->num_rows;

echo<<<END
        <div class="standardform">
    <h3>Szukaj lotu</h3>
    <form action="Rezerwacja.php" method="post">
        Miasto startu:      <br><input type="text" name="m_startu"/> <br>
        Miasto lądowania:   <br><input type="text" name="m_ladowania"/><br>
        Start dnia:         <br><input type="date" name="m_ladowania"/><br>
        Lądowanie dnia:     <br><input type="date" name="m_ladowania"/> <br>
    <br/><input type="submit" value="Szukaj"/>

    </form>
    </div>
    <div class="flightinfo">
    <h2>Propozycje</h2>
    <table>
    <thead>
    <tr>
    <td>Lot nr</td> <td>Linia lotnicza</td> <td>Miejsce startu</td> <td>Data startu</td> <td>Godzina startu</td> <td>Miejsce lądowania</td> <td>Data lądowania</td> <td>Godzina lądowania</td> <td>Uwagi</td> <td>Rezerwuj</td>
    </tr>
    </thead>
    <tbody>
END;

for ($i = 1; $i <= $ile; $i++)
{
    $row = mysqli_fetch_assoc($rezultat);
    $id = $row['ID_LOTU'];
    $linia_lotnicza = $row['NAZWA_LINII'];
    $miejsce_startu = $row['SKAD'];
    $data_startu = $row['DATA_ODLOTU'];
    $godzina_startu = $row['GODZINA_ODLOTU'];
    $miejsce_ladowania = $row['DOKAD'];
    $data_ladowania = $row['DATA_PRZYLOTU'];
    $godzina_ladowania  = $row['CZAS_PRZYLOTU'];
    $uwagi= $row['Uwagi'];

    echo<<<END

    <tr>
    <td>$id</td> <td>$linia_lotnicza</td> <td>$miejsce_startu</td> <td>$data_startu</td> <td>$godzina_startu</td> <td>$miejsce_ladowania</td> <td>$data_ladowania</td> <td>$godzina_ladowania</td> <td>$uwagi</td> <td><a href="seats_choose.php?id=$id">Rezerwuj</a></td>
    </tr>
END;
}

echo<<<END
    </tbody>
    </table></div>

END;

$polaczenie->close();
?>
</div>
</body>
</html>
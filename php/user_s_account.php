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

?>

<?php
    ini_set("display_errors", 0);
    require_once 'connect.php';
    $polaczenie = mysqli_connect($host, $db_user, $db_password);
    mysqli_query($polaczenie, "SET CHARSET utf8");
    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
    mysqli_select_db($polaczenie, $db_name);

    $rezultat=@$polaczenie->query("SELECT ID_REZERWACJI, REZERWACJE.ID_LOTU, SKAD, DATA_ODLOTU, GODZINA_ODLOTU, DOKAD, DATA_PRZYLOTU, CZAS_PRZYLOTU, NUMER_MIEJSCA, STATUS, Uwagi FROM REZERWACJE, LOTY WHERE LOTY.ID_LOTU=REZERWACJE.ID_LOTU AND ID_KLIENTA=1 ORDER BY `REZERWACJE`.`ID_REZERWACJI` DESC");
    $ile=$rezultat->num_rows;

echo<<<END

    <h2>Historia rezerwacji</h2>
    <table border="1" cellpadding="10" cellspacing="1">
    <tr>
    <td>Nr rezerwacji</td> <td>Nr lotu</td> <td>Miejsce startu</td> <td>Data startu</td> <td>Godzina startu</td> <td>Miejsce lądowania</td> <td>Data lądowania</td> <td>Godzina lądowania</td> <td>Miejsce</td> <td>Status</td> <td>Uwagi</td> <td>Anuluj rezerwację</td>
    </tr>
END;

    for ($i = 1; $i <= $ile; $i++)
    {
        $row = mysqli_fetch_assoc($rezultat);
        $rezerwacja = $row['ID_REZERWACJI'];
        $id = $row['ID_LOTU'];
        $miejsce_startu = $row['SKAD'];
        $data_startu = $row['DATA_ODLOTU'];
        $godzina_startu = $row['GODZINA_ODLOTU'];
        $miejsce_ladowania = $row['DOKAD'];
        $data_ladowania = $row['DATA_PRZYLOTU'];
        $godzina_ladowania  = $row['CZAS_PRZYLOTU'];
        $numer_miejsca = $row['NUMER_MIEJSCA'];
        $status = $row['STATUS'];
        $uwagi= $row['Uwagi'];

echo<<<END
    <tr>
    <td>$rezerwacja</td> <td>$id</td> <td>$miejsce_startu</td> <td>$data_startu</td> <td>$godzina_startu</td> <td>$miejsce_ladowania</td> <td>$data_ladowania</td> <td>$godzina_ladowania</td> <td>$numer_miejsca</td> <td>$status</td> <td>$uwagi</td> <td><a href="anuluj.php">Anuluj</a></td>
    </tr>
END;
    }

echo<<<END
    </table>
END;

    $polaczenie->close();
?>

    <br/>[<a href="Rezerwacja.php">Rezerwacja</a>]

</body>
</html>
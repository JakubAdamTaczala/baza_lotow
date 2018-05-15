<?php
/**
 * Created by PhpStorm.
 * User: Jakub Taczała
 * Date: 25.04.2018
 * Time: 14:59
 */
?>

<?php #Jeśli użytkownik zalogowany
    session_start();

    if(!isset($_SESSION['zalogowany'])){
        header('Location: index.php');
        exit();
    }

    if($_SESSION['USER'] == "USER"){
        header('Location: user_s_account.php');
        exit();
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>System rezerwacji biletów lotniczych</title>

    <link rel="stylesheet" href="./style.css" type="text/css"/>
    <style>
        .header {
            border-bottom: 2px solid #be1bc5;
            background: linear-gradient(to bottom right, #77c9d4, #cb6fff );      
        }
    </style>
</head>

<body>
    <div class = "header" ><img src="logo.png" /><h1>Zarządzanie systemem rezerwacji biletów lotniczych</h1></div>
    <div class = "navbar" ><ul>
        <li><p>Witaj <?php echo $_SESSION['imie'].' '.$_SESSION['nazwisko'] ?>!</p></li>
        <li><a href="staff_s_account.php">Panel pracownika</a></li>
        <li><a href="logout.php">Wylogowanie</a></li>
    </ul></div>

    <?php 

        $id = $_POST['id'];
        $action = $_POST['action'];

        ini_set("display_errors", 0);
            require_once 'connect.php';
            $polaczenie = mysqli_connect($host, $db_user, $db_password);
            mysqli_query($polaczenie, "SET CHARSET utf8");
            mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
            mysqli_select_db($polaczenie, $db_name);
        
        if($action == "change"){
            $m_start = $_POST['m_start'];
            $m_ladowania = $_POST['m_ladowania'];
            $d_start = date("Y-m-d", strtotime($_POST['d_start']));
            $d_ladowania = date("Y-m-d", strtotime($_POST['d_ladowania']));
            $t_start = $_POST['t_start'];
            $t_ladowania = $_POST['t_ladowania'];

            $polaczenie->query("SET AUTOCOMMIT=0");
            $polaczenie->query("START TRANSACTION");
            $rezultat=$polaczenie->query("SELECT * FROM LOTY WHERE ID_LOTU = $id FOR UPDATE");
            if($rezultat->num_rows > 0){
                $sql = "UPDATE LOTY SET SKAD='$m_start', DATA_ODLOTU='$d_start', GODZINA_ODLOTU='$t_start', DOKAD='$m_ladowania', DATA_PRZYLOTU='$d_ladowania', CZAS_PRZYLOTU='$t_ladowania', Uwagi='ZMIANA' WHERE ID_LOTU=$id";
                $polaczenie->query($sql);
                $polaczenie->query("COMMIT");
                $status = "POWODZENIE";
                $comment = "Lot został zaktualizowany.";
            }else{
                $polaczenie->query("ROLLBACK");
                $status = "NIEPOWODZENIE";
                $comment = "Błędny lot.";
            }
         }else if($action == "cancel"){
            $polaczenie->query("SET AUTOCOMMIT=0");
            $polaczenie->query("START TRANSACTION");
            $rezultat=$polaczenie->query("SELECT * FROM LOTY WHERE ID_LOTU = $id FOR UPDATE");
            if($rezultat->num_rows > 0){
                
                $params = $rezultat->fetch_assoc();
                $idSamolotu = $params['ID_SAMOLOTU'];
                $wersjasql = $polaczenie->query("SELECT ID_WERSJI_SAMOLOTU FROM SAMOLOTY WHERE ID_SAMOLOTU=$idSamolotu");
                $wersjaassoc = mysqli_fetch_assoc($wersjasql);
                $wersja = $wersjaassoc['ID_WERSJI_SAMOLOTU'];

                $pojemnoscsql = $polaczenie->query("SELECT ILOSC_MIEJSC FROM POJEMNOSC_SAMOLOTU WHERE ID_WERSJI_SAMOLOTU=$wersja");
                $pojemnoscassoc = mysqli_fetch_assoc($pojemnoscsql);
                $pojemnosc = $pojemnoscassoc['ILOSC_MIEJSC'];

                $lancuchzer = '';
                $ilosczer = 0;
                if($pojemnosc % 4 == 0)
                    $ilosczer = $pojemnosc/4;
                else
                    $ilosczer = intval($pojemnosc/4) + 1;
    

                while(strlen($lancuchzer) < $ilosczer)
                    $lancuchzer = "0".$lancuchzer;

                $polaczenie->query("UPDATE LOTY SET WOLNE_MIEJSCA='$lancuchzer' WHERE ID_LOTU=$id");
                $polaczenie->query("UPDATE LOTY SET Uwagi='ODWOŁANY' WHERE ID_LOTU=$id"); 
                $polaczenie->query("UPDATE REZERWACJE SET STATUS='ANULOWANA' WHERE ID_LOTU=$id");
                   
                $polaczenie->query("COMMIT");

                    $status = "POWODZENIE";
                    $comment = "Lot został odwołany.";
            }else{
                $polaczenie->query("ROLLBACK");
                $status = "NIEPOWODZENIE";
                $comment = "Błędny lot.";
            }
            $polaczenie->query("ROLLBACK");
        }else{
            $status = "NIEPOWODZENIE";
            $comment = "Błąd aplikacji.";
        }        

    ?>

    <?php
    if($status == "POWODZENIE"){
        echo '<div class = "standardframe" style="background: #8cf49d">';
    }else{
        echo '<div class = "standardframe" style="background: #fb8787">';
    }

    ?>

    <h3>Status modyfikacji: <?php echo $status ?></h3>
    <p><?php echo $comment ?></p>

    <p><a href=/staff_s_account.php>Powrót</a></p>

    </div>

</body>

</html>
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
        <li><a href="staff_s_account.php">Podgląd lotów</a></li>
        <li><a href="add_flight.php">Doddaj lot</a></li>
        <li><a href="logout.php">Wylogowanie</a></li>
    </ul></div>

<?php
ini_set("display_errors", 0);
require_once 'connect.php';
$polaczenie = mysqli_connect($host, $db_user, $db_password);
mysqli_query($polaczenie, "SET CHARSET utf8");
mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
mysqli_select_db($polaczenie, $db_name);

    $jest_OK=true;

    $id_samolotu = $_POST['id_samolotu'];
    $m_start = $_POST['m_start'];
    $m_ladowania = $_POST['m_ladowania'];
    $d_start = date("Y-m-d", strtotime($_POST['d_start']));
    $d_ladowania = date("Y-m-d", strtotime($_POST['d_ladowania']));
    $t_start = $_POST['t_start'];
    $t_ladowania = $_POST['t_ladowania'];

    //Czy id lotu zajete ???????????
    /*
    $rezultat=@$polaczenie->query("SELECT ID_SAMOLOTU FROM LOTY WHERE");
    $ile_takich_lotow = $rezultat->num_rows;
    if($ile_takich_lotow>0)
    {
        $jest_OK=false;
    }

    $rezultat->close();
    $polaczenie->close();
    */

    if($d_start>=$d_ladowania){
        $status = "NIEPOWODZENIE";
        $comment = "Błędne dane.";
    }

    else if($jest_OK==true) {
        $polaczenie->query("SET AUTOCOMMIT=0");
        $polaczenie->query("START TRANSACTION");

        $sql = "INSERT INTO LOTY VALUES(NULL, '$id_samolotu', '$m_start', '$d_start', '$t_start', '$m_ladowania', '$d_ladowania', '$t_ladowania', '00', '-BRAK-')";
        $polaczenie->query($sql);
        $polaczenie->query("COMMIT");
        $status = "POWODZENIE";
        $comment = "Lot został dodany.";
    }

    else{
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

<p><a href=add_flight.php>Powrót</a></p>

</div>

</body>

</html>
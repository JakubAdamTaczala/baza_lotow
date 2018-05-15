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

        $id = $_GET['id'];

    ?>


    <div class="standardform" style="width: 50%">
        <h3>Zarządzanie lotem nr <?php echo $id ?></h3>
        <?php
            ini_set("display_errors", 0);
            require_once 'connect.php';
            $polaczenie = mysqli_connect($host, $db_user, $db_password);
            mysqli_query($polaczenie, "SET CHARSET utf8");
            mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
            mysqli_select_db($polaczenie, $db_name);

            $rezultat=@$polaczenie->query("SELECT * FROM LOTY WHERE ID_LOTU = $id");
            $params = mysqli_fetch_assoc($rezultat);
        ?>

        <form method="post" action="edit_flight.php">
            <table>
                <input type="hidden" name="id" value="<?php echo $id ?>" />
                <input type="hidden" name="action" value="change" />
                <tr><td>Miasto startu:      </td><td><input type="text" name="m_start" value="<?php echo $params['SKAD']?>"/></td></tr>
                <tr><td>Miasto lądowania:   </td><td><input type="text" name="m_ladowania" value="<?php echo $params['DOKAD']?>"/></td></tr>
                <tr><td>Start dnia:         </td><td><input type="date" name="d_start" value="<?php echo $params['DATA_ODLOTU']?>"/></td></tr>
                <tr><td>Lądowanie dnia:     </td><td><input type="date" name="d_ladowania" value="<?php echo $params['DATA_PRZYLOTU']?>"/></td></tr>
                <tr><td>Godzina startu:     </td><td><input type="time" name="t_start" value="<?php echo $params['GODZINA_ODLOTU']?>"/></td></tr>
                <tr><td>Godzina lądowania:  </td><td><input type="time" name="t_ladowania" value="<?php echo $params['CZAS_PRZYLOTU']?>"/></td></tr>
            </table>

            <input type="submit" value="Zaakceptuj" />
        </form>
    </div>

    <div class="standardform" style="width: 50%; border-color: red">
        <h3>Odwołaj lot</h3>
        <form method="post" action="edit_flight.php">
            <input type="hidden" name="action" value="cancel" />
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <input type="submit" value="Anuluj lot" />
        </form>
    </div>


</body>
</html>
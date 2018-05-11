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
</body>
</html>
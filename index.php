<?php
/**
 * Created by PhpStorm.
 * User: Jakub Taczała
 * Date: 22.04.2018
 * Time: 12:32
 */
?>

<?php
    session_start();

    if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)){
        if($_SESSION['USER'] == "USER"){
            header('Location: user_s_account.php');
        }else if($_SESSION['USER'] == "STAFF"){
            header('Location: staff_s_account.php');
        }else{
            header('Location: google.com');
        }
        
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
    if(isset($_SESSION['blad_bazy_usr'])){
        echo '<div class="error">'.$_SESSION['blad_bazy_usr'].'</div>';
        unset($_SESSION['blad_bazy_usr']);
    }

    if(isset($_SESSION['blad_bazy_dev'])){
        echo $_SESSION['blad_bazy_dev'];
        unset($_SESSION['blad_bazy_dev']);
    }
    ?>
    <div class = "header" ><img src="logo.png" /><h1>System rezerwacji biletów lotniczych</h1></div>
    <div class = "content">
<br/>
    

    <h2>Witamy na stronie Systemu rezerwacji biletów lotniczych!</h2>

    <div class = "loginregisterform">

    <h3>Logowanie</h3>

    <form action="zaloguj.php" method="post">
        E-mail: <br/><input type="text" name="login"/><br/>
        Hasło: <br/><input type="password" name="haslo"/><br/>

        <?php
        if(isset($_SESSION['blad'])){
            echo '<div class="error">'.$_SESSION['blad'].'</div>';
            unset($_SESSION['blad']);
        }
        ?>

        <br/><input type="submit" value="Zaloguj się"/>

    </form><br>
    <a href="rejestracja.php">Rejestracja</a>
    </div>
    </div>

    <div class="footer">
        <p>Copyleft 2018 - Michał Ślusarczyk, Jakub Taczała</p>
    </div>
</body>
</html>
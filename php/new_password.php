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

if(isset($_POST['s_haslo'])) {
    $wszystko_OK = true; //zalozenie, iz zmiana powiodla sie

    $n1_haslo = $_POST['n1_haslo'];
    $n2_haslo = $_POST['n2_haslo'];
    $s_haslo  = $_POST['s_haslo'];
    //Sprawdź poprawność hasła
    if ((strlen($n1_haslo)<8) || (strlen($n1_haslo)>26))
    {
        $wszystko_OK=false;
        $_SESSION['e_n1_haslo']="Hasło musi posiadać od 8 do 26 znaków.";
    }

    if ($n1_haslo==$s_haslo)
    {
        $wszystko_OK=false;
        $_SESSION['e_n1_haslo']="Nowe i stare hasło nie mogą być takie same.";
    }

    if ($n1_haslo!=$n2_haslo)
    {
        $wszystko_OK=false;
        $_SESSION['e_n2_haslo']="Podane hasła nie są identyczne.";
    }

    $haslo_hash = password_hash($n1_haslo, PASSWORD_DEFAULT); //echo $haslo_hash; exit();

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try{
        $polaczenie=new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        }

        else{
            //Czy stare haslo jest poprawne?
            $u_id=$_SESSION['id'];
            $rezultat=@$polaczenie->query("SELECT HASLO FROM KLIENCI WHERE KLIENCI.ID='$u_id'");
            if (!$rezultat) throw new Exception($polaczenie->error);
            $ile_takich_hasel = $rezultat->num_rows;
            if($ile_takich_hasel==1)
            {
                $tab=$rezultat->fetch_assoc();
                if(password_verify($_POST['s_haslo'], $tab['HASLO'])==false){
                    $wszystko_OK=false;
                    $_SESSION['e_s_haslo']="Błędne hasło.";
                }
            }
            else{
                $wszystko_OK=false;
                $_SESSION['zmiany'] = "OPERACJA ODRZUCONA";
                header('Location: change.php');
            }

            if($wszystko_OK==true){
                //Dodanie do bazy
                if($polaczenie->query("UPDATE KLIENCI SET KLIENCI.HASLO='$haslo_hash' WHERE KLIENCI.ID='$u_id'")){
                    $_SESSION['zmiany'] = "OPERACJA UDANA";
                    header('Location: change.php');
                }
                else{
                    throw new Exception($polaczenie->error);
                }
            }

            $rezultat->close();
            $polaczenie->close();
        }

    }
    catch(Exception $e) {
        $_SESSION['blad_bazy_usr']='Błąd połączenia z serwerem!';
        //$_SESSION['blad_bazy_dev']='Informacja developerska'.$e;
    }
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
        <h3>Zmiana hasła</h3>
        <center>
        <form method="post">

            Obecne hasło: <br/><input type="password" name="s_haslo"/><br/>
            <?php
            if (isset($_SESSION['e_s_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_s_haslo'].'</div>';
                unset($_SESSION['e_s_haslo']);
            }
            ?>

            Nowe hasło: <br/><input type="password" name="n1_haslo"/><br/>
            <?php
            if (isset($_SESSION['e_n1_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_n1_haslo'].'</div>';
                unset($_SESSION['e_n1_haslo']);
            }
            ?>

            Powtórz nowe hasło: <br/><input type="password" name="n2_haslo"/><br/>
            <?php
            if (isset($_SESSION['e_n2_haslo']))
            {
                echo '<div class="error">'.$_SESSION['e_n2_haslo'].'</div>';
                unset($_SESSION['e_n2_haslo']);
            }
            ?>

            <br/><input type="submit" value="Zmień"/>

        </form>
        </center>
    </div>
</div>
</body>
</html>
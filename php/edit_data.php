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

if(isset($_POST['n_imie'])) {
    $wszystko_OK = true; //zalozenie, iz zmiana powiodla sie

    $n_imie=$_POST['n_imie'];
    //sprawdzenie czy jest imie, min 2 znaki
    if (strlen($n_imie)<2){
        $wszystko_OK=false;
        $_SESSION['e_n_imie']="Imię musi posiadać przynajmniej dwa znaki.";
    }

    $n_nazwisko=$_POST['n_nazwisko'];
    //sprawdzenie czy jest nazwisko, min 2 znaki
    if (strlen($n_nazwisko)<2){
        $wszystko_OK=false;
        $_SESSION['e_n_nazwisko']="Nazwisko musi posiadać przynajmniej dwa znaki.";
    }

    $n_numer=$_POST['n_numer'];
    //sprawdzenie poprawności numeru
    if (ctype_digit($n_numer)==false){
        $wszystko_OK=false;
        $_SESSION['e_n_numer']="Numer musi składać się wyłącznie z cyfr."; //inne kraje maja rozne dlugosci tele
    }

    $n_mail=$_POST['n_mail'];
    //sprawdzenie poprawności adresu e-mail
    $mailB = filter_var($n_mail, FILTER_SANITIZE_EMAIL);

    if ((filter_var($mailB, FILTER_VALIDATE_EMAIL)==false) || ($mailB!=$n_mail)) {
        $wszystko_OK=false;
        $_SESSION['e_n_mail']="Błędny adres e-mail.";
    }

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try{
        $polaczenie=new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0){
            throw new Exception(mysqli_connect_errno());
        }

        else{
            //Czy email już istnieje?
            $u_id=$_SESSION['id'];
            $rezultat=@$polaczenie->query("SELECT ID FROM KLIENCI WHERE MAIL='$n_mail' AND KLIENCI.ID!='$u_id' UNION SELECT ID FROM PRACOWNICY WHERE MAIL='$n_mail'");
            if (!$rezultat) throw new Exception($polaczenie->error);
            $ile_takich_maili = $rezultat->num_rows;
            if($ile_takich_maili>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_n_mail']="Istnieje już konto przypisane do tego adresu e-mail!";
            }

            if($wszystko_OK==true){
                //Dodanie do bazy
                if($polaczenie->query("UPDATE KLIENCI SET KLIENCI.IMIE='$n_imie', KLIENCI.NAZWISKO='$n_nazwisko', KLIENCI.MAIL='$n_mail', KLIENCI.TELEFON='$n_numer' WHERE KLIENCI.ID='$u_id'")){
                    $_SESSION['nazwisko'] = $n_nazwisko;
                    $_SESSION['imie'] = $n_imie;
                    $_SESSION['mail'] = $n_mail;
                    $_SESSION['telefon'] = $n_numer;
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
        <h3>Edycja danych</h3>
        <center>
        <form method="post">

            Imię:<br/><input type="text" name="n_imie" value="<?php echo$_SESSION['imie']?>"/><br/>
            <?php
            if (isset($_SESSION['e_n_imie'])){
                echo '<tr><td><div class="error">'.$_SESSION['e_n_imie'].'</div></td></tr>';
                unset($_SESSION['e_n_imie']);
            }
            ?>

            Nazwisko:<br/><input type="text" name="n_nazwisko" value="<?php echo$_SESSION['nazwisko']?>"/><br/>
            <?php
            if (isset($_SESSION['e_n_nazwisko'])){
                echo '<div class="error">'.$_SESSION['e_n_nazwisko'].'</div>';
                unset($_SESSION['e_n_nazwisko']);
            }
            ?>

            E-mail:<br/><input type="text" name="n_mail" value="<?php echo$_SESSION['mail']?>"/><br/>
            <?php
            if (isset($_SESSION['e_n_mail'])){
                echo '<div class="error">'.$_SESSION['e_n_mail'].'</div>';
                unset($_SESSION['e_n_mail']);
            }
            ?>

            Numer telefonu:<br/><input type="text" name="n_numer" value="<?php echo$_SESSION['telefon']?>"/><br/>
            <?php
            if (isset($_SESSION['e_n_numer'])){
                echo '<div class="error">'.$_SESSION['e_n_numer'].'</div>';
                unset($_SESSION['e_n_numer']);
            }
            ?>

            <br/><input type="submit" value="Zmień"/>

        </form>
        </center>
    </div>
</div>
</body>
</html>
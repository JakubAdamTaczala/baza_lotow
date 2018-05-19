<?php
/**
 * Created by PhpStorm.
 * User: Jakub Taczała
 * Date: 24.04.2018
 * Time: 19:28
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


if(isset($_POST['imie'])){
    $wszystko_OK=true; //zalozenie, iz rejestracja sie powiodla

    $imie=$_POST['imie'];
    //sprawdzenie czy jest imie, min 2 znaki
    if (strlen($imie)<2){
        $wszystko_OK=false;
        $_SESSION['e_imie']="Imię musi posiadać przynajmniej dwa znaki.";
    }

    $nazwisko=$_POST['nazwisko'];
    //sprawdzenie czy jest nazwisko, min 2 znaki
    if (strlen($imie)<2){
        $wszystko_OK=false;
        $_SESSION['e_nazwisko']="Nazwisko musi posiadać przynajmniej dwa znaki.";
    }

    $numer=$_POST['numer'];
    //sprawdzenie poprawności numeru
    if (ctype_digit($numer)==false){
        $wszystko_OK=false;
        $_SESSION['e_numer']="Numer musi składać się wyłącznie z cyfr."; //inne kraje maja rozne dlugosci tele
    }

    $mail=$_POST['mail'];
    //sprawdzenie poprawności adresu e-mail
    $mailB = filter_var($mail, FILTER_SANITIZE_EMAIL);

    if ((filter_var($mailB, FILTER_VALIDATE_EMAIL)==false) || ($mailB!=$mail)) {
        $wszystko_OK=false;
        $_SESSION['e_mail']="Błędny adres e-mail.";
    }

    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];
    //Sprawdź poprawność hasła
    if ((strlen($haslo1)<8) || (strlen($haslo1)>26))
    {
        $wszystko_OK=false;
        $_SESSION['e_haslo1']="Hasło musi posiadać od 8 do 26 znaków.";
    }

    if ($haslo1!=$haslo2)
    {
        $wszystko_OK=false;
        $_SESSION['e_haslo2']="Podane hasła nie są identyczne.";
    }

    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT); //echo $haslo_hash; exit();

    //Akceptacja regulaminu?
    if (!isset($_POST['regulamin']))
    {
        $wszystko_OK=false;
        $_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
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
            $rezultat=@$polaczenie->query("SELECT ID FROM KLIENCI WHERE MAIL='$mail' UNION SELECT ID FROM PRACOWNICY WHERE MAIL='$mail'");
            if (!$rezultat) throw new Exception($polaczenie->error);
            $ile_takich_maili = $rezultat->num_rows;
            if($ile_takich_maili>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_mail']="Istnieje już konto przypisane do tego adresu e-mail!";
            }

            if($wszystko_OK==true){
                //Dodanie do bazy
                if($polaczenie->query("INSERT INTO KLIENCI VALUES (NULL, '$nazwisko', '$imie', '$haslo_hash', '$mail', '$numer')")){
                    $_SESSION['udanarejestracja']=true;
                    header('Location: witamy.php');
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

    <link rel="stylesheet" href="./style.css"" type="text/css"/>

</head>

<body>
    <div class = "header" ><a href="index.php"><img src="logo.png" /></a><h1>System rezerwacji biletów lotniczych</h1></div>
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


<div class="loginregisterform">

    <h3>Rejestracja</h3>

<form method="post">

    Imię: <br/><input type="text" name="imie"/><br/>
    <?php
    if (isset($_SESSION['e_imie']))
    {
        echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
        unset($_SESSION['e_imie']);
    }
    ?>

    Nazwisko: <br/><input type="text" name="nazwisko"/><br/>
    <?php
    if (isset($_SESSION['e_nazwisko']))
    {
        echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
        unset($_SESSION['e_nazwisko']);
    }
    ?>

    Nr kom.: <br/><input type="text" name="numer"/><br/>
    <?php
    if (isset($_SESSION['e_numer']))
    {
        echo '<div class="error">'.$_SESSION['e_numer'].'</div>';
        unset($_SESSION['e_numer']);
    }
    ?>

    E-mail: <br/><input type="text" name="mail"/><br/>
    <?php
    if (isset($_SESSION['e_mail']))
    {
        echo '<div class="error">'.$_SESSION['e_mail'].'</div>';
        unset($_SESSION['e_mail']);
    }
    ?>

    Hasło: <br/><input type="password" name="haslo1"/><br/>
    <?php
    if (isset($_SESSION['e_haslo1']))
    {
        echo '<div class="error">'.$_SESSION['e_haslo1'].'</div>';
        unset($_SESSION['e_haslo1']);
    }
    ?>

    Powtórz hasło: <br/><input type="password" name="haslo2"/><br/>
    <?php
    if (isset($_SESSION['e_haslo2']))
    {
        echo '<div class="error">'.$_SESSION['e_haslo2'].'</div>';
        unset($_SESSION['e_haslo2']);
    }
    ?>

    <label>
        <input type="checkbox" name="regulamin"/> Akceptuję <a href="regulamin.html">regulamin</a><br/>
    </label>
        <?php
        if (isset($_SESSION['e_regulamin']))
        {
            echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
            unset($_SESSION['e_regulamin']);
        }
        ?>

        <br/><input type="submit" value="Zarejestruj się"/>

</form>

</div>
</body>
</html>
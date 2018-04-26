<?php
/**
 * Created by PhpStorm.
 * User: Jakub Taczała
 * Date: 22.04.2018
 * Time: 13:41
 */
?>

<?php
    session_start();
    if((!isset($_POST['login'])) || (!isset($_POST['haslo']))){
        header('Location: index.php');
        exit();
    }

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try{
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    if ($polaczenie->connect_errno!=0){
        throw new Exception(mysqli_connect_errno());
    }

    else{
        $login=$_POST['login'];
        $haslo=$_POST['haslo'];

        $login=htmlentities($login, ENT_QUOTES, "UTF-8");

        if($rezultat=@$polaczenie->query(sprintf("SELECT  * FROM KLIENCI WHERE MAIL='%s' UNION SELECT * FROM PRACOWNICY WHERE MAIL='%s'",
            mysqli_real_escape_string($polaczenie, $login), mysqli_real_escape_string($polaczenie, $login)))){

            $ilu_uzytkownikow=$rezultat->num_rows;

            if($ilu_uzytkownikow>0){
                $wiersz=$rezultat->fetch_assoc();

                if(password_verify($haslo, $wiersz['HASLO'])){

                    $_SESSION['zalogowany'] = true;

                    $_SESSION['id'] = $wiersz['ID'];
                    $_SESSION['nazwisko'] = $wiersz['NAZWISKO'];
                    $_SESSION['imie'] = $wiersz['IMIE'];
                    $_SESSION['mail'] = $wiersz['MAIL'];
                    $_SESSION['telefon'] = $wiersz['TELEFON'];

                    unset($_SESSION['blad']);

                    $rezultat->close();

                    $mail=$_SESSION['mail'];
                    $rezultat=@$polaczenie->query("SELECT ID FROM KLIENCI WHERE MAIL='$mail'");
                    $ile_takich_maili = $rezultat->num_rows;
                    if($ile_takich_maili>0) header('Location: user_s_account.php');

                    $rezultat=@$polaczenie->query("SELECT ID FROM PRACOWNICY WHERE MAIL='$mail'");
                    $ile_takich_maili = $rezultat->num_rows;
                    if($ile_takich_maili>0) header('Location: staff_s_account.php');

                    $rezultat->close();

                }

                else{
                    $_SESSION['blad']='Nieprawidłowy login lub hasło!';
                    header('Location: index.php');
                }
            }

            else{
                $_SESSION['blad']='Nieprawidłowy login lub hasło!';
                header('Location: index.php');
            }
        }

        $polaczenie->close();
    }

}
catch(Exception $e) {
    $_SESSION['blad_bazy_usr']='Błąd połączenia z serwerem!';
    //$_SESSION['blad_bazy_dev']='Informacja developerska'.$e;
    header('Location: index.php');
}

?>

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

    if (!isset($_SESSION['udanarejestracja'])){
        header('Location: index.php');
        exit();
    }

    unset($_SESSION['udanarejestracja']);

    //Usuwanie błędów rejestracji
    if (isset($_SESSION['e_imie'])) unset($_SESSION['e_imie']);
    if (isset($_SESSION['e_nazwisko'])) unset($_SESSION['e_nazwisko']);
    if (isset($_SESSION['e_numer'])) unset($_SESSION['e_numer']);
    if (isset($_SESSION['e_mail'])) unset($_SESSION['e_mail']);
    if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
    if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);

    header('Location: witamy.html');

?>

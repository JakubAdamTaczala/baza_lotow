<?php
/**
 * Created by PhpStorm.
 * User: Jakub Taczała
 * Date: 22.04.2018
 * Time: 16:20
 */
?>

<?php
    session_start();

    session_unset();

    header('Location: index.php');
?>

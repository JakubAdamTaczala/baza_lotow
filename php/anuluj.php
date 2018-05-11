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
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Anulowanie biletów lotniczych</title>

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
	<?php
	    ini_set("display_errors", 0);
	    require_once 'connect.php';
	    $polaczenie = mysqli_connect($host, $db_user, $db_password);
	    mysqli_query($polaczenie, "SET CHARSET utf8");
	    mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	    mysqli_select_db($polaczenie, $db_name);

	    $idrezerwacji = $_GET['id'];
	    $rezerwacje = $polaczenie->query("SELECT * FROM REZERWACJE WHERE ID_REZERWACJI = $idrezerwacji");
	    $rezerwacja = mysqli_fetch_assoc($rezerwacje);
	    $iduzytkownika = $_SESSION['id'];
	    $idlotu = $rezerwacja['ID_LOTU'];
	    $miejsce = $rezerwacja['NUMER_MIEJSCA'];
    	if($iduzytkownika == $rezerwacja['ID_KLIENTA']){
		    if($rezerwacja['STATUS'] == "REZERWACJA"){
		    	$polaczenie->query("START TRANSACTION");
		    	$lot = $polaczenie->query("SELECT * FROM LOTY WHERE ID_LOTU='$idlotu' FOR UPDATE");
		    	$rowAll = mysqli_fetch_assoc($lot);
		    	$row = $rowAll['WOLNE_MIEJSCA'];
				$row = str_split($row);
				$rowLen = count($row);
				$segment = floor($miejsce/4.0);
				$seats = $row[$segment];
				$seats = base_convert ($seats, 16, 2);
				while(strlen($seats) < 4)
					$seats = "0".$seats;
				$seats = str_split($seats);
				$pozycja = $miejsce%4;
				if($seats[$pozycja] == "1"){
					$seats[$pozycja] = "0";
					$seats = implode("", $seats);
					$seats = base_convert ($seats, 2, 16);
					$row[$segment] = $seats;
					$row = implode("", $row);
					$polaczenie->query("UPDATE LOTY SET WOLNE_MIEJSCA='$row' WHERE ID_LOTU='$idlotu'");
		    		$polaczenie->query("UPDATE REZERWACJE SET STATUS='ANULOWANA' WHERE ID_REZERWACJI = $idrezerwacji");
		    		$polaczenie->query("COMMIT");

		    		$status = "POWODZENIE";
		    		$comment = "Rezerwacja o numerze $idrezerwacji została anulowana!";
		    	}else{
		    		$polaczenie->query("ROLLBACK");
		    		$status = "BŁĄD SPÓJNOŚCI";
		    		$comment = "BŁĄD BAZY - MIEJSCE ZOSTAŁO JUŻ ZWOLNIONE";
		    	}
		    }else{
		    	$status = "NIEPOWODZENIE";
		    	$comment = "Rezerwacja została już wcześniej anulowana";
		    }
	    }else{
		    $status = "NIEPOWODZENIE";
		    $comment = "Nie masz uprawnień do tej rezerwacji";
		}

	if($status == "POWODZENIE"){
		echo '<div class = "standardframe" style="background: #8cf49d">';
	}else{
		echo '<div class = "standardframe" style="background: #fb8787">';
	}

  	?>
  	
  	<h3>Status anulacji: <?php echo $status ?></h3>
	<p><?php echo $comment ?></p>
	<p><a href = "history.php">Powrót</a></p>
	</div>
</body>
</html>

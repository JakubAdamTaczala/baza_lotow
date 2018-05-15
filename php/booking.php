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

$idlotu = $_POST['idlotu'];
$miejsce = $_POST['numer_miejsca'];
$idklienta = $_SESSION['id'];
ini_set("display_errors", 1);
require_once 'connect.php';
$polaczenie = mysqli_connect($host, $db_user, $db_password);
mysqli_query($polaczenie, "SET CHARSET utf8");
mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
mysqli_select_db($polaczenie, $db_name);

$polaczenie->query("SET AUTOCOMMIT=0");
$polaczenie->query("START TRANSACTION");
$rezultat=$polaczenie->query("SELECT * FROM LOTY WHERE ID_LOTU='$idlotu' FOR UPDATE");
$rowAll = mysqli_fetch_assoc($rezultat);

if($rowAll['Uwagi'] == "ODWOŁANY" || $rezultat->num_rows == 0){
	$polaczenie->query("ROLLBACK");
	$status = "NIEUDANA";
	$comment = "Wybrany lot nie istnieje.";
}else{
	$planeID = $rowAll['ID_SAMOLOTU'];
	$planeID = intval($planeID);

	$rezultat2 = $polaczenie->query("SELECT ID_WERSJI_SAMOLOTU FROM SAMOLOTY WHERE ID_SAMOLOTU = '$planeID'");
	$rowVer = mysqli_fetch_assoc($rezultat2);
	$planeVer = $rowVer['ID_WERSJI_SAMOLOTU'];
	$planeVer = intval($planeVer);

	$rezultat3 = $polaczenie->query("SELECT ILOSC_MIEJSC FROM POJEMNOSC_SAMOLOTU WHERE ID_WERSJI_SAMOLOTU = '$planeVer'");
	$rowCap = mysqli_fetch_assoc($rezultat3);
	$planeCap = $rowCap['ILOSC_MIEJSC'];
	$planeCap = intval($planeCap);

	if($miejsce < $planeCap){
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
		if($seats[$pozycja] == "0"){
			$seats[$pozycja] = "1";
			$seats = implode("", $seats);
			$seats = base_convert ($seats, 2, 16);
			$row[$segment] = $seats;
			$row = implode("", $row);
			$polaczenie->query("UPDATE LOTY SET WOLNE_MIEJSCA='$row' WHERE ID_LOTU='$idlotu'");
			$sql = "INSERT INTO REZERWACJE VALUES (NULL, '$idklienta', '$idlotu', '$miejsce', 'REZERWACJA')";
			$polaczenie->query($sql);
			$polaczenie->query("COMMIT");
			$status = "POTWIERDZONA";
			$comment = "Wybrane miejsce zostało zarezerwowane.";
		}else{
			//miejsce zajęte
			$polaczenie->query("ROLLBACK");
			$status = "NIEUDANA";
			$comment = "Wybrane miejsce jest już zajęte.";
		}
	}else{
		//miejsce spoza zakresu
		$polaczenie->query("ROLLBACK");
		$status = "NIEUDANA";
		$comment = "Wybrane miejsce nie istnieje.";
	}

}
$polaczenie->close();
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Status rezerwacji</title>

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
	if($status == "POTWIERDZONA"){
		echo '<div class = "standardframe" style="background: #8cf49d">';
	}else{
		echo '<div class = "standardframe" style="background: #fb8787">';
	}

  	?>

	<h3>Status rezerwacji: <?php echo $status ?></h3>
	<p><?php echo $comment ?></p>
	<?php
	if($status == "NIEUDANA"){
		echo "<p><a href=/seats_choose.php?id=$idlotu>Powrót</a></p>";
	}else{
		echo "<p><a href=/history.php>Powrót</a></p>";
	}
	?>
	</div>

</body>
</html>
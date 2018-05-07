<?php
session_start();

include("opendb.php");

// Her definere vi de forskellige colonner i databasen, og laver en var (variable) og int (integer) til dem, så vi kan arbejde med dem i php.
echo "der er hul igennem til resultat.php";
$fornavn = $_POST['fornavn'];
$efternavn = $_POST['efternavn'];
$email = $_POST['email'];
$telefon = (int)$_POST['telefon'];
$adresse = $_POST['adresse'];
$by = $_POST['by']; // Her stod byen
$postnr = (int)$_POST['postnr'];
$kommentar = $_POST['kommentar'];
$kortnr = (int)$_POST['kortnr'];
$udloebsdato = (int)$_POST['udloebsdato'];
$kontrolcifre = (int)$_POST['kontrolcifre'];
$afhentning = $_POST['afhentning'];
$gave = $_POST['gave'];
$betalingskort = $_POST['kreditkort']; // Her stod betalingskort

// Her opstiller vi valideringsfejlene, hvis input felterne i index.php ikke bliver udfyldt.
$errorsFound = [];
if (strlen($postnr) != 4) {
	$errorsFound['postnr'] = 'Postnummeret skal have en længde på 4';
}
if (strlen($telefon) != 8) {
	$errorsFound['telefon'] = 'Telefonnummeret skal have en længde på 8';
}
if (strlen($kortnr) != 16) {
	$errorsFound['kortnr'] = 'Kortnummeret skal have en længde på 16';
}
if (strlen($kontrolcifre) != 3) {
	$errorsFound['kontrolcifre'] = 'Kontrolcifre skal have en længde på 3';
}

if (empty($fornavn)) {
	$errorsFound['fornavn'] = 'Angiv venligst et fornavn';
}
if (empty($efternavn)) {
	$errorsFound['efternavn'] = 'Angiv venligst et efternavn';
}

$_SESSION['formErrors'] = $errorsFound;
$_SESSION['lastInput'] = $_POST;

if (!empty($errorsFound)) {
	header('Location: index.php');
}

// Hvis alt bliver udfyldt korrekt, skal informationerne udfylde i de givende kolonner i databasen.
else {
	$sql = "INSERT INTO betalingsformular (fornavn, efternavn, email, telefon, adresse, `by`, postnr, kommentar, udloebsdato, kontrolcifre, afhentning, gave, betalingskort) VALUES ('".$fornavn."', '".$efternavn."', '".$email."', ".$telefon.", '".$adresse."', '".$by."', ".$postnr.", '".$kommentar."', ".$udloebsdato.", ".$kontrolcifre.", '".$afhentning."', '".$gave."', '".$betalingskort."')";

	//$sql = "INSERT INTO betalingsformular (fornavn, efternavn, email, telefon, adresse, `by`, postnr, kommentar, kortnr, udloebsdato, kontrolcifre, afhentning, gave, betalingskort) VALUES ('".$fornavn."', '".$efternavn."', '".$email."', ".$telefon.", '".$adresse."', '".$by."', ".$postnr.", '".$kommentar."', ".$kortnr.", ".$udloebsdato.", ".$kontrolcifre.", '".$afhentning."', '".$gave."', '".$betalingskort."')";

	//echo("SQL: " . $sql);

	if ($conn->query($sql) === TRUE) {
	echo "Gemt i databasen<br>";
	} else {
	echo "Fejl: " . $sql . "<br>" . $conn->error . "<br>";
		echo "Der er sket en fejl<br>";
	}

	//vi lukker forbindelsen til databasen igen
	$conn->close(); 
	//Når resultat.php har gennemført sin funktion, sendes brugeeren videre til udprint.php hvor dataen vises. 
	header('Location: udprint.php'); 
}
?>


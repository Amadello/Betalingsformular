<?php
    include("opendb.php");
    $sql = 'SELECT fornavn, efternavn, email, telefon, adresse, `by`, postnr, kommentar, kortnr, udloebsdato, kontrolcifre, afhentning, gave, betalingskort FROM betalingsformular ORDER BY id DESC LIMIT 1';

    //udkommenteres når vi har tjekket at det virker.
    //echo "sql: " . $sql;

    //hent værdier og læg dem i $resultat, så kan vi bruge dem senere.
    $resultat = mysqli_query($conn, $sql); 
?>

<!DOCTYPE html>
<html lang="da">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Betalingsformular</title>
        <link rel="stylesheet" href="betalingStyle.css">
  </head>
	<body>
        
    <section id="resultat">

        <h1>Order bekræftelse</h1>

        <!-- En while-løkke der lægger hver række i $r -->
        <?php while ($r = mysqli_fetch_array($resultat)) { 
                            echo '<section>' . '<p class="resholder">' . '</br>' . '<b>Dit navn er: </b>' . $r['fornavn'] . ' ' . $r['efternavn'] . '</br>' . '<b>Din Email er : </b>' . $r['email'] . '</br>' . '<b>Dit telefon nummer: </b>' . $r['telefon'] . '</br>' . '</br>' . '<b>Dine adresse oplysninger: </b>' . '</br>' . $r['adresse'] . '</br>' . $r['by'] . ' ' . $r['postnr'] . '</br>' . '</br>' . '<b>Dine konto oplysninger</b>' . '</br>' . $r['betalingskort'] . $r['kortnr'] . '</br>' . $r['kommentar'] . '</br>' . $r['udloebsdato'] . '</br>' . $r['kontrolcifre'] . '</br>' . '</br>' . '<b>Afhæntingsmetode: </b>' . $r['afhentning'] . '</br>' . '<b>Indpakningsvalg: </b>' . $r['gave'] . '</br>' . '</p></section>';
                       } 
                 ?>
    </section> 
 	</body>
</html>


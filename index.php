<?php
	// session_start(); Er til at at starte session. Det skal man gør for at få adgang til $_SESSION variablen. Det er i $_SESSION vi har gemt informationer om fejl og sidste indtastninger.
	// Den tjekker så på om formErrors i $_SESSION er tom (eller rettere ikke findes). Hvis den ikke findes, så bliver den sat til et tomt array. Ellers får vi fejl, når man prøver at til gå den.
	// Derefter gemmer vi det der står i den i en anden variabel, og sletter så det der står i formErrors. Det er bare så at fejlene ikke bliver vist igen hvis man trykker f5, men kun når man kommer inde fra action filen.
	session_start();

	// Her laver vi en client site valdidation. Vi kunne have lavet et array, der løber de forskellig input igennem, men valgte at tjekke hver enkelt. 
	// Vi laver en if sætning der siger, at hvis formErrors står tom (=[];) skal den udsende en fejlmeddelse  
	if (empty($_SESSION['formErrors'])) $_SESSION['formErrors'] = [];
	if (empty($_SESSION['lastInput'])) $_SESSION['lastInput'] = [];
	
	$formErrors = $_SESSION['formErrors'];
	$lastInput = $_SESSION['lastInput'];
	
	$_SESSION['formErrors'] = [];
	
	// Her inkludere vi en php fil udefra dokumentet. 
    include("opendb.php");
  $sql = 'SELECT fornavn, efternavn, email, telefon, adresse, `by`, postnr, kommentar, kortnr, udloebsdato, kontrolcifre, afhentning, gave, betalingskort FROM betalingsformular';

    //echo "sql: " . $sql; //udkommenteres når vi har tjekket at det virker
    
	//hent værdier og læg dem i $resultat, så kan vi bruge dem senere
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
        <!-- Her opstiller vi et form element, der skal opsamle de indtastede data brugeren skriver ind. 
		method="post" hvilket er en attribute, betyder at vi sender informationen som en HTTP post trans action.
		action="resultat.php" bestemmer hvor denne data bliver bearbejdet. 
         -->
		<form id="observation_form" name="observation_form" method="post" action="resultat.php">
			<!-- Her opstiller vi en div, med et id, der gør at vi kan style formularen i dens egen section -->
			<div id="SectionHolder">

				<!-- Vi har valgt at opstille vores layout som et single column layout, for at undgå z-patterns. Dog har vi opstillet ting som fornavn og efternavn efter hinanden, da de er sammenhængende, men kræver to forskellige inputfield -->

				<h2>Betalingsformular</h2>

				<!-- Vi har lavet 2 forskellige classes til vores label og input, da nogle skulle stå ved siden af hinanden, fylde 50%, og andre skulle fylde 100%, i længden. -->
				<div class="halfLengthL">
                <p class="title">Fornavn</p> 
                <!-- Her henter vi en funktion vi definerede i toppen af dokumentet, og siger at hvis input fieldet er tomt, skal den sende en fejl ud til brugeren, om at de ikke har udfyldt feltet korrekt.
                Vi bruger denne validerings form, på alle de inputs vi har valgt skal have en validering.  -->
                <?PHP if (!empty($formErrors['fornavn'])) echo '<b>'.$formErrors['fornavn'].'</b>'; ?>

                <!-- Her laver vi input feltet der har en forbindelse til databasen, og sender dataen til databasen hvis submit button, som ligger i slutningen, bliver aktiveret. -->
                <input class="whole" type="text" name="fornavn" value="<?PHP if (!empty($lastInput['fornavn'])) echo $lastInput['fornavn']; ?>"><br>
                </div>

				<div class="halfLengthR">
                <p class="title">Efternavn</p> 
				<?PHP if (!empty($formErrors['efternavn'])) echo '<b>'.$formErrors['efternavn'].'</b>'; ?>
				<input class="whole" type="text" name="efternavn" value="<?PHP if (!empty($lastInput['efternavn'])) echo $lastInput['efternavn']; ?>"><br>
                </div>
                
                <!-- Vi opretter en clearfix, for at vores float vi lige har lavet, ikke kommer til at påvirke resten af felterne nedenunder -->    
                <div class="clearfix"></div>

                <p class="title">E-mail</p> 
                <input class="length" type="email" name="email" value="<?PHP if (!empty($lastInput['email'])) echo $lastInput['email']; ?>"><br>
                    
                <p class="title">Telefon Nr.</p>
                <?PHP if (!empty($formErrors['telefon'])) echo '<b>'.$formErrors['telefon'].'</b>'; ?>
                <input class="length" type="tel" name="telefon" value="<?PHP if (!empty($lastInput['telefon'])) echo $lastInput['telefon']; ?>"><br>
                    
                <p class="title">Adresse</p>
                <input class="length" type="text" name="adresse" value="<?PHP if (!empty($lastInput['adresse'])) echo $lastInput['adresse']; ?>"><br>
                 
                <div class="halfLengthL">    
                <p class="title">By</p>
                <input class="whole" type="text" name="by" value="<?PHP if (!empty($lastInput['by'])) echo $lastInput['by']; ?>"><br>
                </div>

				<div class="halfLengthR">                                    
                <p class="title">Post Nr.</p>
                <?PHP if (!empty($formErrors['postnr'])) echo '<b>'.$formErrors['postnr'].'</b>'; ?>
                <input class="whole" type="text" name="postnr" value="<?PHP if (!empty($lastInput['postnr'])) echo $lastInput['postnr']; ?>"><br>
                </div>

                <div class="clearfix"></div>

				<!-- Her laver vi en select, et element tag, der bliver brugt til at skabe en drop down menu -->
                <p class="title">Leveringsmetode</p>   
				<select class="length" id="afhentning" name="afhentning">
                    <option value="default">--- ingen valgt ---</option>
					<option value="afhentning_post">Afhentning posthus</option>
					<option value="pakkeboks">Pakkeboks</option>
					<option value="tildoeren">Levering til døren</option>
				</select><br>

				<p class="title">Kommentar</p>
				<textarea class="length" id="kommentar" name="kommentar"><?PHP if (!empty($lastInput['kommentar'])) echo $lastInput['kommentar']; ?></textarea><br>

				<!-- Vi laver hr tags, for at lave en lille opdeling af formularen, der laver en god readability. Vi har brugt gestalt loven proximity, da elementerne er let adsklit, men stadig høre sammmen -->
				<hr>
				

				<!-- Vi har valgt at sææte radio buttons under hinanden for nemmer "scanability"-->
				<p class="title">Skal varen pakkes ind som gave?</p>
				<p class="title">Ja</p> 
                <input type="radio" name="gave" value="ja" checked>
                <p class="title">Nej</p> 
                <input type="radio" name="gave" value="nej"> 

                <hr>

                <p class="title">Betalingsmetode</p>
                <select class="length" id="kreditkort" name="kreditkort">
                	<option value="default">--- ingen valgt ---</option>
					<option value="mdebit">Mastercard Debit</option>
					<option value="mastercard">Mastercard</option>
					<option value="dankort">Dankort</option>
				</select><br>

				<p class="title">Kort Nr.</p>
                <?PHP if (!empty($formErrors['kortnr'])) echo '<b>'.$formErrors['kortnr'].'</b>'; ?>
                <input class="length" type="text" name="kortnr" value="<?PHP if (!empty($lastInput['kortnr'])) echo $lastInput['kortnr']; ?>"><br>
 
                 <div class="halfLengthL">                   
                <p class="title">Udløbsdato</p>
                <?PHP if (!empty($formErrors['udloebsdato'])) echo '<b>'.$formErrors['udloebsdato'].'</b>'; ?>
                <input class="whole" type="text" name="udloebsdato" value="<?PHP if (!empty($lastInput['udloebsdato'])) echo $lastInput['udloebsdato']; ?>"><br>
                </div>

                <div class="halfLengthR">               
				<p class="title">Kontrolcifre</p>
                <?PHP if (!empty($formErrors['kontrolcifre'])) echo '<b>'.$formErrors['kontrolcifre'].'</b>'; ?>
                <input class="whole" type="text" name="kontrolcifre" value="<?PHP if (!empty($lastInput['kontrolcifre'])) echo $lastInput['kontrolcifre']; ?>"><br>
                 </div>

                <div class="clearfix"></div>

                <!-- Her laver vi en button der submitter dit indtastede data til databasen -->
				<button type="submit" value="submit" class="godkend">Godkend</button>

				<div id="footer">
					<p class="title"> &copy 2018 Mette, Hussein og Camilla.  All rights reserved.</p>
				</div>

			</div>
		</form>
        
    <!-- Her opstiller vi en besked der skal vises med cookies, og hvis accepteret gemt med local storge.  -->    
	<div id="cookie-message">
		Vi bruger cookies. Denne meddelse bliver ved med at blive vist, indtil du har trykket på knappen! <button id="cookie-button">Accepter cookies</button>.
	</div>
	</body>
</html>

<script>
	// Hvis der ikke er noget i din local storge, skal denne besked (cookie-message) komme frem. 

	if (!localStorage.getItem('accepteret-cookies')) {
		document.getElementById('cookie-message').style.display = 'block';
	}

	// Hvis du acceptere cookies (med knappen der har en .onclick funktion), så vi local storge huske du har accepteret det, og ikke vise beskeden igen.

	document.getElementById('cookie-button').onclick = function(e) {
		localStorage.setItem('accepteret-cookies', 'Ja');
		document.getElementById('cookie-message').style.display = 'none';
	}
</script>
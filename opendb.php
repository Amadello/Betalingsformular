﻿ <?php
$servername = "";
$username = "";
$password = "";
$dbname = "";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname); //Her opretter vi en databaseforbindelse ved navn $conn
//mange eksempler udelader angvilse af database, hvis der kun er en

//Check connection
if ($conn->connect_error) {  //Vi tjekker om forbindelsen mislykkedes
    die("Forbindelse mislykkedes: " . $conn->connect_error);
} 
//echo "Forbundet til databasen<br>"; //udkommenteres når vi lige har set at der er hul igennem*/
?> 
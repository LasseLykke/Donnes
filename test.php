<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data using POST method
$fornavn = $_POST["fornavn"];
$telefonnummer = $_POST["telefonnummer"];
$ramme_kundeID =$_POST["kundeID"];
$dates = $_POST["Indleveringsdato"];
$profil = $_POST["profil"];
$størrelse = $_POST["størrelse"];
$glastype = $_POST["glastype"];



    // Forbinder til database
    $mysqli = new mysqli("localhost", "root", "", "Donnes");

    // Tjekker forbindelsen
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

// Begin a transaction
$mysqli->begin_transaction();

// Define SQL queries with placeholders for each table
$sql1 = "INSERT INTO kunder (fornavn, telefonnummer) VALUES (?, ?)";
$sql2 = "INSERT INTO rammer (ramme_kundeID, dates, profil, størrelse, glastype) VALUES (?, ?, ?, ?, ?)";

// Create prepared statements for each query
$stmt1 = $mysqli->prepare($sql1);
$stmt2 = $mysqli->prepare($sql2);

if ($stmt1 === false || $stmt2 === false) {
    die("Error: " . $mysqli->error);
}


// Bind parameters and their values for the first statement
$stmt1->bind_param("si", $fornavn, $telefonnummer);

// Bind parameters and their values for the second statement (leaving one row out)
// You can decide to insert or not based on your requirements
if ($ramme_kundeID != "value_to_skip") {
    $stmt2->bind_param("ssiss",$ramme_kundeID, $dates, $profil, $størrelse, $glastype);
    $stmt2->execute();
}

// Execute the prepared statement for the first table
$stmt1->execute();

// Check for execution errors
if ($stmt1->errno || $stmt2->errno) {
    $mysqli->rollback(); // Rollback the transaction in case of an error
    die("Error: " . $stmt1->error . " or " . $stmt2->error);
}

// Commit the transaction if the first statement executed successfully
$mysqli->commit();

// Close the statements and the database connection
$stmt1->close();
$stmt2->close();
$mysqli->close();
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- classless style, ændres når det er sat korrekt op ÆNDRES NÅR CSS ER SAT OP-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Ramme bestilling</title>  <!-- Også det filen hedder -->
</head>
<body>
    <h1>Ramme bestilling</h1>
    
    <?php
    // Viser success eller fejl meddelelse
    if (isset($_SESSION["message"])) {
        echo "<p>{$_SESSION["message"]}</p>";
        unset($_SESSION["message"]);
    } ?>



<form action="" method="POST">
        <div>
            <label for="dates">Indleverings dato</label>
            <input type="date" id="dates" name="Indleveringsdato">
        </div>

        <div style="display: none;">
        <label for="ramme_kundeID">KundeID</label>
            <input type="number" id="ramme_kundeID" name="kundeID">
        </div>

        <div>
            <label for="fornavn">fornavn</label>
            <input type="text" id="fornavn" name="fornavn">
        </div>
        <div>
            <label for="telefonnummer">Telefonummer</label>
            <input type="number" id="telefonnummer" name="telefonnummer">
        </div>

        <div>
            <label for="profil">Ramme Profil</label>
            <input type="number" id="profil" name="profil">
        </div>

        <div>
            <label for="størrelse">Ramme Størrelse</label>
            <input type="text" id="størrelse" name="størrelse">
        </div>
        
        <div>
            <fieldset>
                <legend>Glas Type</legend>
                <input type="radio" id="klart" name="glastype" value="Klart glas" required>
                <label for="klart">Klart Glas</label><br>
                <input type="radio" id="reflo" name="glastype" value="Reflo glas" required>
                <label for="reflo">Reflo glas</label><br>
                <input type="radio" id="museums" name="glastype" value="Museums glas" required>
                <label for="museums">Museums Glas</label><br>
                <input type="radio" id="tom" name="glastype" value="Uden glas" required>
                <label for="tom_uden_bagplade">Uden glas</label><br>
                <input type="radio" id="tom_uden_bagplade" name="glastype" value="Tom uden bagplade" required>
                <label for="tom">Uden glas og bagplade</label>
            </fieldset>
        </div>

        

        
        <button onClick="window.print()">PRINT & GEM</button> required

        
        
    </form>

</body>
</html>
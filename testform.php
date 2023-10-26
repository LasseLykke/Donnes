<?php


 /* Tjekker om der submittet til formen */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Henter data fra tabel
    $dates = $_POST["Indleveringsdato"];
    $kundeID =$_POST["kundeID"];
    $profil = $_POST["profil"];
    $størrelse = $_POST["størrelse"];
    $glastype = $_POST["glastype"];



    // Forbinder til database
    $mysqli = new mysqli("localhost", "root", "", "Donnes");

    // Tjekker forbindelsen
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    // Forbereder SQL statement til indsættelse af data til rammer
    if ($kundeID != "value_to_skip") {
    $sql1 = "INSERT INTO rammer (dates, kundeID, profil, størrelse, glastype) VALUES
    (?, ?, ?, ?, ?);";

    // Forbereder SQL statement til indsættelse af data til kunder
    $sql2 = "INSERT INTO rammer (fornavn, telefonnummer) VALUES
    (?, ?);";


    $stmt1 = $mysqli->prepare($sql1);
    $stmt2 = $mysqli->prepare($sql2);
    
    // Binder parameter sammen og eksekvere statement
    $stmt1->bind_param("sssss", $dates, $kundeID, $profil, $størrelse, $glastype);
    $stmt2->bind_param("si", $fornavn, $telefonnummer);
    
    $stmt1->execute();
    $stmt2->execute();

    // Check for execution errors
if ($stmt1->errno || $stmt2->errno) {
    $mysqli->rollback(); // Rollback the transaction in case of an error
    die("Error: " . $stmt1->error . " or " . $stmt2->error);
}

// Commit the transaction if both statements executed successfully
$mysqli->commit();

// Close the statements and the database connection
$stmt1->close();
$stmt2->close();
$mysqli->close();

  //  Går tilbage til bekræftelses side fra form. SKAL ÆNDRES
  header("Location: forside.php");
  exit();

}
    
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
        <div>
            <label for="fornavn">fornavn</label>
            <input type="text" id="fornavn" name="fornavn">
        </div>
        <div>
            <label for="telefonnummer">Telefonummer</label>
            <input type="number" id="telefonnummer" name="telefonnummer">
        </div>

        <div style="display: none;">
        <label for="kundeID">KundeID</label>
            <input type="number" id="kundeID" name="Indleveringsdato">
        </div>

        <div>
            <label for="profil">Ramme Profil</label>
            <input type="number" id="profil" name="profil">
        </div>
        

        
        <button onClick="window.print()">PRINT & GEM</button> required

        
        
    </form>

</body>
</html>
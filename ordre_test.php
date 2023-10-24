<?php


 /* Tjekker om der submittet til formen */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Henter data fra tabel
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
    
    // Forbereder SQL statement til indsættelse af data
    $sql = "INSERT INTO rammer (dates, profil, størrelse, glastype) VALUES
    (?, ?, ?, ?);";
    $stmt = $mysqli->prepare($sql);
    
    // Binder parameter sammen og eksekvere statement
    $stmt->bind_param("ssss", $dates, $profil, $størrelse, $glastype);
    
    if ($stmt->execute()) {
        // Data indsat med sussess 
        $_SESSION["message"] = "Data saved successfully!";
    } else {
        // Fejl sket.
        $_SESSION["message"] = "Error: " . $mysqli->error;
    }
    
    // Lukker statement og database forbindelse
    $stmt->close();
    $mysqli->close();
    
    //  Går tilbage til bekræftelses side fra form. SKAL ÆNDRES
    header("Location: forside.php");
    exit();
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


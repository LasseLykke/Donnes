<?php


 /* Tjekker om der submittet til formen */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Henter data fra tabel
    $dates = $_POST["Indleveringsdato"];
    $names = $_POST["Kundens_navn"];
    $telefon = $_POST["telefon"];
    $rammeprofil = $_POST["Rammeprofil"];
    $rammestørrelse = $_POST["Rammestørrelse"];
    $glastype = $_POST["Glastype"];
    $passepartout = $_POST["Passepartout"];
    $passepartoutHulmål = $_POST["Hulmål"];
    $passepartoutFarve = $_POST["passepartoutFarve"];
    $antal = $_POST["Antal"];
    $montering = $_POST["montering"];
    $billedetype = $_POST["billedetype"];
    $bemærkninger = $_POST["bemærkninger"];
    $pris = $_POST["Pris"];
    $betalt = $_POST["betaling"];
    $Bestilt = $_POST["bestilt"];
    $ekspedient = $_POST["ekspedient"];

    // Forbinder til database
    $mysqli = new mysqli("localhost", "root", "", "login_db");

    // Tjekker forbindelsen
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    // Forbereder SQL statement til indsættelse af data
    $sql = "INSERT INTO rammer (dates, names, telefon, rammeprofil, rammestørrelse, glastype, passepartout, Hulmål, passepartoutFarve, antal, montering, billedetype, bemærkninger, pris, betalt, bestilt, ekspedient) VALUES
    (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?);";
    $stmt = $mysqli->prepare($sql);
    
    // Binder parameter sammen og eksekvere statement
    $stmt->bind_param("sssssssssssssssss", $dates, $names, $telefon, $rammeprofil, $rammestørrelse, $glastype, $passepartout, $passepartoutHulmål, $passepartoutFarve, $antal, $montering, $billedetype, $bemærkninger, $pris, $betalt, $Bestilt, $ekspedient);
    
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
            <label for="names">Navn</label>
            <input type="text" id="names" name="Kundens_navn" >
        </div>

        <div>
            <label for="telefon">Telefon nummer</label>
            <input type="number" id="telefon" name="telefon">
        </div>

        <div>
            <label for="rammeprofil">Ramme Profil</label>
            <input type="number" id="rammeprofil" name="Rammeprofil">
        </div>

        <div>
            <label for="rammestørrelse">Ramme Størrelse</label>
            <input type="text" id="rammestørrelse" name="Rammestørrelse">
        </div>

        <div>
            <fieldset>
                <legend>Glas Type</legend>
                <input type="radio" id="klart" name="Glastype" value="Klart glas" required>
                <label for="klart">Klart Glas</label><br>
                <input type="radio" id="reflo" name="Glastype" value="Reflo glas" required>
                <label for="reflo">Reflo glas</label><br>
                <input type="radio" id="museums" name="Glastype" value="Museums glas" required>
                <label for="museums">Museums Glas</label><br>
                <input type="radio" id="tom" name="Glastype" value="Uden glas" required>
                <label for="tom_uden_bagplade">Uden glas</label><br>
                <input type="radio" id="tom_uden_bagplade" name="Glastype" value="Tom uden bagplade" required>
                <label for="tom">Uden glas og bagplade</label>
            </fieldset>
        </div>

        <div>
            <h3>Passepartout</h3>
            <input type="radio" id="passepartout_ja" name="Passepartout" value="Ja">
            <label for="passepartout_ja">Ja</label>
            <input type="radio" id="passepartout_nej" name="Passepartout" value="Nej">
            <label for="passepartout_nej">Nej</label>
        </div>

        <div>
            <label for="passepartoutHulmål">Hulmål</label>
            <input type="text" id="passepartoutHulmål" name="Hulmål">
        </div>

        <div>
            <fieldset>
                <legend>Farve på passepartout</legend>

            <input type="radio" id="8001" name="passepartoutFarve" value="8001">
            <label for="profil_8001">Hvidt med hvid kerne</label><br>
            <input type="radio" id="8213" name="passepartoutFarve" value="8213">
            <label for="profil_8213">Knækket hvid med hvid kerne</label><br>
            <input type="radio" id="profil_8011" name="passepartoutFarve" value="8011">
            <label for="profil_8011">Sort med hvid kerne</label><br>
            <input type="radio" id="7011" name="passepartoutFarve" value="7011">
            <label for="profil_7011">Sort med sort kerne</label><br>
            <input type="radio" id="8051" name="passepartoutFarve" value="8051">
            <label for="profil_8051">Lyseblå med hvid kerne</label><br>
            <input type="radio" id="8071" name="passepartoutFarve" value="8071">
            <label for="profil_8071">Mørkeblå med hvid kerne</label><br>
            <input type="radio" id="8816" name="passepartoutFarve" value="8816">
            <label for="profil_8816">Bordeaux med hvid kerne</label><br>
            <input type="radio" id="8611" name="passepartoutFarve" value="8611">
            <label for="profil_8611">Karry gul med hvid kerne</label><br>
            <input type="radio" id="8411" name="passepartoutFarve" value="8411">
            <label for="profil_8411">Olivengrøn med hvid kerne</label><br>
            <input type="radio" id="8009" name="passepartoutFarve" value="8009">
            <label for="profil_8009">Lysebrun med hvid kerne</label><br>
            </fieldset>
        </div>

        <div>
            <label for="antal">Antal rammer</label>
            <input type="number" id="antal" name="Antal">
        </div>

        <div>
            <h4>Montering</h4>
            <input type="radio" id="montering_JA" name="montering" value="Ja">
            <label for="montering_JA">Ja</label>
            <input type="radio" id="montering_NEJ" name="montering" value="Nej">
            <label for="montering_NEJ">Nej</label>
        </div>
        
        <div>
        <fieldset>
            <legend>Billede</legend>
            <input type="radio" id="kundens_Billede" name="billedetype" value="Vi har fået billede fra kunde">
            <label fot="kundens_Billede">Kunden har vedlagt billede</label><br>
            <input type="radio" id="print_Billede" name="billedetype" value="Vi skal printe">
            <label fot="print_Billede">Vi skal printe billede</label><br>
        </fieldset>
        </div>

        <div>
            <label for="bemærkninger">Bemærkninger</label>
            <textarea id="bemærkninger" name="bemærkninger"></textarea>
        </div>

        <div>
            <label for="pris">Aftalt pris</label>
            <input type="number" id="pris" name="Pris">
        </div>

        <div>
            <h4>Betalt</h4>
            <input type="radio" id="betalt" name="betaling" value="Ja">
            <label for="betalt">Ja</label>
            <input type="radio" id="betalt" name="betaling" value="Nej">
            <label for="betalt">Nej</label>
        </div>

        <div>
            <h3>Bestilt</h3>
            <input type="radio" id="bestilt" name="bestilt" value="Ja">
            <label for="bestilt">Ja</label>
            <input type="radio" id="bestilt" name="bestilt" value="Nej">
            <label for="bestilt">Nej</label>
        </div>

        <div>
            <label for="ekspedient">Ekspedient</label>
            <input type="text" id="ekspedient" name="ekspedient" >
        </div>

        
        <button onClick="window.print()">PRINT & GEM</button> required

        
        
    </form>

</body>
</html>


<?php



/* DATA POINTS => id is the same as the points from db - has to match. 
id (int)
dates (date)
names (var)
telefon (int)
Leverandør (var) => Dropdown
Produkt (var)
Pris (float)
Ekspediendt (text)
*/


 /* Tjekker om der submittet til formen */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Henter data fra tabel
    $id = $_POST["Ordrenummer"];
    $dates = $_POST["Indleveringsdato"];
    $names = $_POST["Kundens_navn"];
    $telefon = $_POST["Telefon"];
    $leverandør = $_POST["Leverandør"];
    $produkt = $_POST["Produkt"];
    $pris = $_POST["Pris"];
    $ekspedient = $_POST["Ekspedient"];


    // Forbinder til database
    $mysqli = new mysqli("localhost", "root", "", "DonnesDB");

    // Tjekker forbindelsen
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    // Forbereder SQL statement til indsættelse af data
    $sql = "INSERT INTO kundeOrdre (dates, names, telefon, leverandør, produkt, pris, ekspedient) VALUES
    (?,?,?,?,?,?,?);";
    $stmt = $mysqli->prepare($sql);
    
    // Binder parameter sammen og eksekvere statement
    $stmt->bind_param("sssssss", $dates, $names, $telefon, $leverandør, $produkt, $pris, $ekspedient);




    
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
    <title>DONNÉS || Kundeordre</title>  <!-- Også det filen hedder -->
</head>



<body>
    <h1>Kunde ordre
        <?php echo $last_id;
        ?>
    </h1>
    
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
            <input type="number" id="telefon" name="Telefon">
        </div>

        <div>
            <label for="leverandør">Leverandør</label>
            <input type="text" id="leverandør" name="Leverandør">
        </div>

        <div>
            <label for="produkt">Produkt</label>
            <input type="text" id="produkt" name="Produkt">
        </div>

        <div>
            <label for="pris">Pris</label>
            <input type="number" id="pris" name="Pris">
        </div>

        <div>
            <label for="ekspedient">Ekspedient</label>
            <input type="text" id="ekspedient" name="Ekspedient" >
        </div>

        
        <button onClick="window.print()">PRINT & GEM</button>

        
        
    </form>

</body>
</html>


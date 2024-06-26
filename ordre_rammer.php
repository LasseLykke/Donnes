<?php
session_start();
if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data using POST method

$rk_fornavn = $_POST["rk_fornavn"];
$rk_telefonnummer = $_POST["rk_telefonnummer"];
$rammeID =$_POST["kundeID"];
$dates = $_POST["Indleveringsdato"];
$profil = $_POST["profil"];
$størrelse = $_POST["størrelse"];
$glastype = $_POST["glastype"];
$passepartout = $_POST["passepartout"];
$hulmål = $_POST["hulmål"];
$passepartoutFarve = isset($_POST["passepartoutFarve"]) ? htmlspecialchars($_POST["passepartoutFarve"]) : '';
$antal = $_POST["antal"];
$montering = $_POST["montering"];
$billedetype = isset($_POST["billedetype"]) ? htmlspecialchars($_POST["billedetype"]) : '';
$bemærkninger = $_POST["bemærkninger"];
$ekspedient = $_POST["ekspedient"];



// Begin a transaction
$mysqli->begin_transaction();

// Define SQL queries with placeholders for each table
$sql1 = "INSERT INTO ramme_kunder (rk_fornavn, rk_telefonnummer) VALUES (?, ?)";
$sql2 = "INSERT INTO ramme (rammeID, dates, profil, størrelse, glastype, passepartout, hulmål, passepartoutFarve, antal, montering, billedetype, bemærkninger, ekspedient) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Create prepared statements for each query
$stmt1 = $mysqli->prepare($sql1);
$stmt2 = $mysqli->prepare($sql2);

if ($stmt1 === false || $stmt2 === false) {
    die("Error: " . $mysqli->error);
}


// Bind parameters and their values for the first statement
$stmt1->bind_param("si", $rk_fornavn, $rk_telefonnummer);

// Bind parameters and their values for the second statement (leaving one row out)
// You can decide to insert or not based on your requirements
if ($rammeID != "value_to_skip") {
    $stmt2->bind_param("issssssisssss", $rammeID, $dates, $profil, $størrelse, $glastype, $passepartout, $hulmål, $passepartoutFarve, $antal, $montering, $billedetype, $bemærkninger, $ekspedient);
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


    //  Går tilbage til bekræftelses side fra form.
    header("Location: success.php");
    exit();
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--classless style, ændres når det er sat korrekt op ÆNDRES NÅR CSS ER SAT OP-->
     <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
   <link href="./style/forms.css" type="text/css" rel="stylesheet">
    <title>DONNÉS || Ramme bestilling</title>  <!-- Også det filen hedder -->
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon"/>
    <meta http-equiv="refresh" content="900;url=logout.php" />
</head>
<body>
    
    <?php
    // Viser success eller fejl meddelelse
    if (isset($_SESSION["message"])) {
        echo "<p>{$_SESSION["message"]}</p>";
        unset($_SESSION["message"]);
    } ?>


<div class="form-wrapper">
<form class="forminput" action="" method="POST"  onsubmit="return validateForm()">
<h1 class="bestillingsheader">Ramme bestilling</h1>
<!-- Basic infomation -->
<div class="baseinfo">
    <div class="dato">
        <label for="dates">Indleverings dato: *</label>
        <input type="date" id="dates" name="Indleveringsdato" required >
    </div>
    <div class="kundenavn">
        <label for="fornavn">Fornavn:</label>
        <input type="text" id="fornavn" name="rk_fornavn" required>
    </div>
    <div class="kundenummer">
        <label for="telefonnummer">Telefonummer:</label>
        <input type="number" id="telefonnummer" name="rk_telefonnummer" required>
    </div>
</div>

    <!-- Bliver skjult -->
    <div style="display: none;">
        <label for="rammeID">rammeID</label>
        <input type="number" id="rammeID" name="kundeID">
    </div>
    



    <!-- Ramme information -->
    <div class="ramme-wrapper">
    <div class="ramme">
    <h6>Ramme oplysninger:</h6>
        <label for="profil">Ramme Profil:</label>
        <input type="text" id="profil" name="profil" required>
        <label for="størrelse">Ramme Størrelse:</label>
        <input type="text" id="størrelse" name="størrelse" required>
        <label for="antal">Antal rammer:</label>
        <input type="number" id="antal" name="antal" required>
    </div>


<!-- Glas og Passepartout information -->
<div class="glas">
    <h6>Glas Type:</h6>
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
</div>
    </div>


    <div class="passepartout-wrapper">
        <div class="ppinfo">
            <h6>Passepartout:</h6>
            <input type="radio" id="passepartout_ja" name="passepartout" value="Ja" required>
            <label for="passepartout_ja">Ja</label>
            <input type="radio" id="passepartout_nej" name="passepartout" value="Nej" required>
            <label for="passepartout_nej">Nej</label><br>
            <h6>Hulmål:</h6>
            <label for="hulmål"></label>
            <input type="text" id="hulmål" placeholder="Billedmål - 1cm" name="hulmål">
        </div>
        <div class="ppfarve1">
            <h6>Farve:</h6>
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
            </div>
        <div class="ppfarve2">
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
        </div>
        </div>


    <!-- Montering og print information & bemærkning -->
    <div class="monteringsinfo">
        <div class="montering">
            <h6>Skal billedet monteres?</h6>
            <input type="radio" id="montering_JA" name="montering" value="Ja" required>
            <label for="montering_JA">Ja</label>
            <input type="radio" id="montering_NEJ" name="montering" value="Nej" required>
            <label for="montering_NEJ">Nej</label>
            <br>
            <input type="radio" id="kundens_Billede" name="billedetype" value="Vi har fået billede fra kunde">
            <label for="kundens_Billede">Kundens billede</label>
            <input type="radio" id="print_Billede" name="billedetype" value="Vi skal printe">
            <label for="print_Billede">Vi skal printe billede</label>
        </div>
        <div class="bemærkning">
            <label for="bemærkninger">Bemærkninger:</label>
            <textarea id="bemærkninger" placeholder="F.eks er ikke betalt.. eller posenummer" name="bemærkninger"></textarea>
        </div>
    </div>

    <div class="ekspedient">
    <label for="ekspedient">Ekspedient:</label>
    <input type="text" id="ekspedient" name="ekspedient" required>
    <button type="submit" class="saveBtn">PRINT & GEM</button>
</div>

<?php if(isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>


</form>

<script>
    function validateForm() {
        window.print();
        return true; // Tillad formularen at blive sendt, hvis valideringen er vellykket
    }
</script>


</div>
</body>
</html>
<?php
/* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>
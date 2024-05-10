<?php 
session_start();
if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Din eksisterende PHP-kode for behandling af formdata

        // Tjek om mindst én båndtype er valgt
        if (!isset($_POST['båndType'])) {
            $error_message = "Du skal vælge mindst én båndtype.";
        } else {
            if (!isset($_POST['båndMedie'])) {
                $error_message = "Du skal vælge mindst én båndmedie.";
            } else {
                $fornavn = $_POST["fornavn"];
                $telefonnummer = $_POST["telefonnummer"];
                $båndID = $_POST["båndID"];
                $båndDates = $_POST["båndDates"];
                $båndType = $_POST["båndType"];
                $båndAntal = $_POST["båndAntal"];
                $båndMedie = $_POST["båndMedie"];
                $båndMedieKopi = isset($_POST["båndMedieKopi"]) ? intval($_POST["båndMedieKopi"]) : 0;
                $båndNotes = $_POST["båndNotes"];
                $båndBetalt = $_POST["båndBetalt"];
                $båndPris = $_POST["båndPris"];
                $ekspedient = $_POST["ekspedient"];
            }
        
        

            // Begin a transaction
            $mysqli->begin_transaction();

            // Define SQL queries with placeholders for each table
            $sql1 = "INSERT INTO kunder (fornavn, telefonnummer) VALUES (?, ?)";
            $sql2 = "INSERT INTO bånd (båndID, båndDates, båndType, båndAntal, båndMedie, båndMedieKopi, båndNotes, båndBetalt, båndPris, ekspedient) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Create prepared statements for each query
            $stmt1 = $mysqli->prepare($sql1);
            $stmt2 = $mysqli->prepare($sql2);

            if ($stmt1 === false || $stmt2 === false) {
                die("Error: " . $mysqli->error);
            }

            // Bind parameters and their values for the first statement
            $stmt1->bind_param("si", $fornavn, $telefonnummer);

            // Bind parameters and their values for the second statement
            $stmt2->bind_param("isssssssss", $båndID, $båndDates, $båndType, $båndAntal, $båndMedie, $båndMedieKopi, $båndNotes, $båndBetalt, $båndPris, $ekspedient);

            // Execute the prepared statements
            $stmt1->execute();
            $stmt2->execute();

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

            // Redirect to the success page after form submission
            header("Location: success.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--classless style, ændres når det er sat korrekt op ÆNDRES NÅR CSS ER SAT OP-->
     <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
   <link href="./style/forms.css" type="text/css" rel="stylesheet">


    <title>DONNÉS || BÅND </title>
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon"/>
    <meta http-equiv="refresh" content="900;url=logout.php" />
</head>
<body>
<div class="form-wrapper">
<form class="forminput" action="" method="POST" onsubmit="return validateForm()">
<h1 class="bestillingsheader">Bånd Ordre</h1>

<!-- Basic infomation --> 
<div class="baseinfo">
    <div class="dato">
        <label for="dates">Indleverings dato: *</label>
        <input type="date" id="dates" name="båndDates" required >
    </div>
    <div class="kundenavn">
        <label for="fornavn">Fornavn:</label>
        <input type="text" id="fornavn" name="fornavn" required>
    </div>
    <div class="kundenummer">
        <label for="telefonnummer">Telefonnummer:</label>
        <input type="number" id="telefonnummer" name="telefonnummer" required>
    </div>

    <!-- Bliver skjult -->
    <div style="display: none;">
        <label for="båndID">KundeID</label>
        <input type="number" id="båndID" name="båndID">
    </div>
</div>

<!-- Ordre info -->
<div class="bånd-wrapper">
   <div class="båndType">
    <h6>Bånd Type:</h6>
    <input type="checkbox" id="VHS" name="båndType" value="VHS">
    <label for="VHS">VHS</label><br>

    <input type="checkbox" id="VHS-C" name="båndType" value="VHS-C">
    <label for="VHS-C">VHS-C</label><br>
    
    <input type="checkbox" id="HI8" name="båndType" value="HI8">
    <label for="HI8">HI8</label><br>

    <input type="checkbox" id="DV" name="båndType" value="DV">
    <label for="DV">DV</label><br>

    <input type="checkbox" id="BETAMAX" name="båndType" value="BETAMAX">
    <label for="BETAMAX">BETAMAX</label><br>

    <input type="checkbox" id="KASSETTEBÅND" name="båndType" value="KASSETTEBÅND">
    <label for="KASSETTEBÅND">KASSETTEBÅND</label><br>

    <label for="båndAntal">Antal bånd ialt</label>
    <input type="number" id="båndAntal" name="båndAntal" required>

</div>

<div class="medie">
    <h6>Medie Type:</h6>
    <p>(Husk at se bemærkninger for evt split)</p>
    
    <input type="checkbox" id="USB" name="båndMedie" value="USB">
    <label for="USB">USB</label><br>

    <input type="checkbox" id="DVD" name="båndMedie" value="DVD">
    <label for="DVD">DVD</label><br>

    <label for="båndMedieKopi">Kopier?</label>
    <input type="number" id="båndMedieKopil" name="båndMedieKopi">
</div>
</div>

<!-- Bemærkninger og pris -->
<div class="prisogbemærkninger">
    <div class="bemærkning">
    <label for="bemærkninger">Bemærkninger:</label>
            <textarea id="bemærkninger" placeholder="" name="båndNotes"></textarea>
    </div>

    <div class="diaspris">
        <h6>Betalt?</h6>
        <input type="radio" id="ja" name="båndBetalt" value="ja" required>
        <label for="diaspris">Ja</label><br>
        <input type="radio" id="nej" name="båndBetalt" value="nej" required>
        <label for="diaspris">Nej</label>

        <label for="aftaltPris">Aftalt samlet pris</label>
    <input type="number" id="aftaltPris" name="båndPris">
        
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
    var checkboxesBåndType = document.querySelectorAll('input[name="båndType"]:checked');
    var checkboxesBåndMedie = document.querySelectorAll('input[name="båndMedie"]:checked');
    
    if (checkboxesBåndType.length === 0) {
        alert('Du skal vælge mindst én båndtype.');
        return false;
    }
    
    if (checkboxesBåndMedie.length === 0) {
        alert('Du skal vælge mindst ét Medie.');
        return false;
    }
    
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

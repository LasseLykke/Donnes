<?php 
session_start();
if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

   include 'connection.php';

   if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fornavn = $_POST["fornavn"];
    $telefonnummer = $_POST["telefonnummer"];
    $bånd_kundeID = $_POST["bånd_kundeID"];
    $båndType = $_POST["båndType"];
    $båndDates = $_POST["båndDates"];
    $båndMedie = $_POST["båndMedie"];
    $båndNotes = $_POST["båndNotes"];
    $båndBetalt = $_POST["båndBetalt"];



// Begin a transaction
$mysqli->begin_transaction();

// Define SQL queries with placeholders for each table
$sql1 = "INSERT INTO kunder (fornavn, telefonnummer) VALUES (?, ?)";
$sql2 = "INSERT INTO bånd (bånd_kundeID, båndType, båndMedie, båndNotes, båndBetalt) VALUES (?, ?, ?, ?, ?)";

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
if ($bånd_kundeID != "value_to_skip") {
    $stmt2->bind_param("sssss", $bånd_kundeID, $båndType, $båndMedie, $båndNotes, $båndBetalt);
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


/*include 'header.php';*/
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
<form class="forminput" action="" method="POST">
<h1 class="bestillingsheader">Bånd Ordre</h1>

<!-- Basic infomation --> 
<div class="baseinfo">
    <div class="dato">
        <label for="dates">Indleverings dato: *</label>
        <input type="date" id="dates" name="båndDates" reguired >
    </div>
    <div class="kundenavn">
        <label for="fornavn">Fornavn:</label>
        <input type="text" id="fornavn" name="fornavn" required>
    </div>
    <div class="kundenummer">
        <label for="telefonnummer">Telefonummer:</label>
        <input type="number" id="telefonnummer" name="telefonnummer" required>
    </div>

    <!-- Bliver skjult -->
    <div style="display: none;">
        <label for="bånd_kundeID">KundeID</label>
        <input type="number" id="bånd_kundeID" name="bånd_kundeID">
    </div>
</div>

<!-- Ordre info -->
<div class="bånd-wrapper">
   <div class="båndType">
    <h6>Bånd Type:</h6>
    <label for="VHS">VHS:</label>
    <input type="number" id="VHS" name="båndType" value="VHS"><br>
    <label for="VHS-C">VHS-C:</label>
    <input type="number" id="VHS-C" name="båndType" value="VHS-C"><br>
    <label for="HI8">Hi8:</label>
    <input type="number" id="HI8" name="båndType" value="HI8"><br>
    <label for="DV">DV:</label>
    <input type="number" id="DV" name="båndType" value="DV"><br>
    <label for="BETA">Betamax:</label>
    <input type="number" id="BETA" name="båndType" value="BETA"><br>   
    <label for="kassettebånd">Kassettebånd:</label>
    <input type="number" id="kassettebånd" name="båndType" value="kassettebånd"><br>   

</div>

<div class="medie">
    <h6>Medie:</h6>
    <p>(Husk at se bemærkninger for evt split)</p>
    <label for="USB">USB</label>
    <input type="number" id="USB" name="båndMedie" value="USB"><br>
    <label for="DVD">DVD</label>
    <input type="number" id="DVD" name="båndMedie" value="DVD"><br>
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

        <label for="aftaltPris">Aftalt pris</label>
    <input type="number" id="aftaltPris" name="aftaltPris">
        
</div>
</div>

<div class="ekspedient">
        <label for="ekspedient">Ekspedient:</label>
        <input type="text" id="ekspedient" name="ekspedient" required>
        <button class="saveBtn" onClick="window.print()">PRINT & GEM</button>
    </div>

</form>
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
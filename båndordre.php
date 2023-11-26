<?php 
session_start();
if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

   


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
</head>
<body>
<div class="form-wrapper">
<form class="forminput" action="" method="">
<h1 class="bestillingsheader">Bånd Ordre</h1>

<!-- Basic infomation --> 
<div class="baseinfo">
    <div class="dato">
        <label for="dates">Indleverings dato: *</label>
        <input type="date" id="dates" name="Indleveringsdato" reguired >
    </div>
    <div class="kundenavn">
        <label for="fornavn">Fornavn:</label>
        <input type="text" id="fornavn" name="fornavn" required>
    </div>
    <div class="kundenummer">
        <label for="telefonnummer">Telefonummer:</label>
        <input type="number" id="telefonnummer" name="telefonnummer" required>
    </div>
</div>

<!-- Dias info -->
<div class="bånd-wrapper">
   <div class="båndType">
    <h6>Bånd Type:</h6>
    <label for="VHS">VHS:</label>
    <input type="number" id="VHS" name="VHS" value="VHS"><br>
    <label for="VHS-C">VHS-C:</label>
    <input type="number" id="VHS-C" name="VHS-C" value="VHS-C"><br>
    <label for="HI8">Hi8:</label>
    <input type="number" id="HI8" name="HI8" value="HI8"><br>
    <label for="DV">DV:</label>
    <input type="number" id="DV" name="DV" value="DV"><br>
    <label for="BETA">Betamax:</label>
    <input type="number" id="BETA" name="BETA" value="BETA"><br>    
</div>

<div class="medie">
    <h6>Medie:</h6>
    <label for="USB">USB</label>
    <input type="number" id="USB" name="USB" value="USB"><br>
    <label for="DVD">DVD</label>
    <input type="number" id="DVD" name="DVD" value="DVD"><br>
</div>
</div>

<!-- Bemærkninger og pris -->

<div class="prisogbemærkninger">
    <div class="bemærkning">
    <label for="bemærkninger">Bemærkninger:</label>
            <textarea id="bemærkninger" placeholder="" name="bemærkninger"></textarea>
    </div>

    <div class="diaspris">
        <h6>Betalt?</h6>
        <input type="radio" id="ja" name="diaspris" value="ja" required>
        <label for="diaspris">Ja</label><br>
        <input type="radio" id="nej" name="diaspris" value="nej" required>
        <label for="diaspris">Nej</label>

        <label for="aftaltPris">Aftalt pris</label>
    <input type="number" id="aftaltPris" name="aftaltPris">
        
</div>
</div>

<div class="ekspedient">
        <label for="ekspedient">Ekspedient:</label>
        <input type="text" id="ekspedient" name="ekspedient" required>
        <button class="saveBtn" onClick="window.print()">PRINT</button>
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
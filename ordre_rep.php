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


    <title>DONNÉS || REPARATION </title>
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon"/>
</head>
<body>
<div class="form-wrapper">
<form class="forminput" action="" method="">
<h1 class="bestillingsheader">Reparations formular:</h1>

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

<!-- Enheds info -->

<div class="enheds-wrapper">
    <div class="mærke">
        <label for="mærke">Mærke:</label>
        <input type="text" id="mærke" name="mærke" value="" required>
    </div>

    <div class="model">
        <label for="model">Model:</label>
        <input type="text" id="model" name="model" value=""required>
    </div>

    <div class="serienummer">
        <label for="serienummer">Serienummer:</label>
        <input type="text" id="serienummer" name="serienummer" value="" required>
    </div>
</div>



<div class="garanti">
    <div class="tilbehør">
        <label for="tilbehør">Tilbehør:</label>
        <textarea id="tilbehør" placeholder="Evt. medfølgende tilbehør" name="tilbehør"></textarea>
    </div>

    <div class="garantisag">
        <h6>Garanti?</h6>
        <input type="radio" id="ja" name="garantisag" value="ja" required>
        <label for="garantisag">Ja</label>
        <input type="radio" id="nej" name="garantisag" value="nej" required>
        <label for="garantisag">Nej</label>
    </div>

    <div class="værksted">
        <label for="værksted">Værksted:</label>
        <select id="værksted" name="værksted">
        <option value="dfa">DFA</option>
        <option value="servicebroker">ServiceBroker</option>
        <option value="focusnordic">Focus Nordic</option>
        <option value="boston">Boston</option>
        <option value="ringfoto">Ringfoto </option>
        <option value="guntex">Guntex </option>
        <option value="andet" selected>Andet</option>
        </select>
    </div>
</div>

<div class="fejl">
    <div class="fejlbeskrivelse">
        <label for="fejlbeskrivelse">Fejlbeskrivelse:</label>
        <textarea id="fejlbeskrivelse" placeholder="" name="fejlbeskrivelse"></textarea>

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
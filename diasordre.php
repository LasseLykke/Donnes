<?php 
session_start();
if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!--classless style, ændres når det er sat korrekt op ÆNDRES NÅR CSS ER SAT OP-->
   <link href="./style/forms.css" type="text/css" rel="stylesheet">


    <title>DONNÉS || DIAS </title>
</head>
<body>
    <div class="dias-wrapper">
        <div class="">
            <form class="forminput" action="" method="">
            <div class="baseinfo">
    <div class="dato">
        <label for="dates">Indleverings dato: *</label>
        <input type="date" id="dates" name="Indleveringsdato" required >
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


            </form>
        </div>
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
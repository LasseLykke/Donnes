<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    die('Du skal være logget ind for at bruge denne side.');
}
$logged_in_user = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="da">

<head>
    <meta charset="UTF-8">
    <title>Indsæt ny ordre</title>
</head>

<body>


    <form action="insertDataRammer.php" method="post">

        <h2>Kunde Information:</h2>
        <div class="kundenavn">
            <label for="kundeNavn">Navn:</label>
            <input type="text" id="kundeNavn" name="kundeNavn" required><br><br>
        </div>

        <div class="kundenummer">
            <label for="kundeTelefon">Telefon:</label>
            <input type="text" id="kundeTelefon" name="kundeTelefon" required><br><br>
        </div>

        <h2>Ramme Information</h2>
        <label for="profil">Profil:</label>
        <input type="text" id="profil" name="profil" required><br><br>

        <label for="størrelse">Størrelse:</label>
        <input type="text" id="størrelse" name="størrelse" required><br><br>

        <!-- glas -->
        <label for="glastype">Glastype:</label><br>
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
        <br><br>

        <label for="passepartout">Passepartout:</label>
        <input type="text" id="passepartout" name="passepartout"><br><br>

        <label for="hulmål">Hulmål:</label>
        <input type="text" id="hulmål" name="hulmål"><br><br>

        <label for="passepartoutFarve">Passepartout Farve:</label>
        <div class="ppfarve1">
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

        <label for="antal">Antal rammer:</label>
        <input type="number" id="antal" name="antal" required><br><br>

        <div class="montering">
            <h6>Skal billedet monteres?</h6>
            <input type="radio" id="montering_JA" name="montering" value="Ja" required>
            <label for="montering_JA">Ja</label>
            <input type="radio" id="montering_NEJ" name="montering" value="Nej" required>
            <label for="montering_NEJ">Nej</label>
            <br>
            <input type="radio" id="kundens_Billede" name="billedtype" value="Kundens billede">
            <label for="kundens_Billede">Kundens billede</label>
            <input type="radio" id="print_Billede" name="billedtype" value="Vi skal printe">
            <label for="print_Billede">Vi skal printe billede</label>
        </div>

        <label for="bemærkninger">Bemærkninger:</label>
        <textarea id="bemærkninger" name="bemærkninger"></textarea><br><br>

        <label for="pris">Pris:</label>
        <input type="number" step="0.01" id="pris" name="pris" required><br><br>

        <label for="ekspedient">Ekspedient:</label>
        <input type="text" id="ekspedient" name="ekspedient" value="<?php echo htmlspecialchars($logged_in_user); ?>"
            readonly>




        <button type="submit">Gem data</button>
    </form>
    </div> <!-- Afslut af form wrapper -->

</body>

</html>
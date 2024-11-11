<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <title>Indsæt ny ordre</title>
</head>
<body>

<form action="insertDataRammer.php" method="post">

    <h2>Kunde Information</h2>
    <label for="kundeNavn">Navn:</label>
    <input type="text" id="kundeNavn" name="kundeNavn" required><br><br>

    <label for="kundeTelefon">Telefon:</label>
    <input type="text" id="kundeTelefon" name="kundeTelefon" required><br><br>

    <h2>Ramme Information</h2>
    <label for="profil">Profil:</label>
    <input type="text" id="profil" name="profil" required><br><br>

    <label for="størrelse">Størrelse:</label>
    <input type="text" id="størrelse" name="størrelse" required><br><br>

    <label for="glastype">Glastype:</label>
    <input type="text" id="glastype" name="glastype" required><br><br>

    <label for="passepartout">Passepartout:</label>
    <input type="text" id="passepartout" name="passepartout"><br><br>

    <label for="hulmål">Hulmål:</label>
    <input type="text" id="hulmål" name="hulmål"><br><br>

    <label for="passepartoutFarve">Passepartout Farve:</label>
    <input type="text" id="passepartoutFarve" name="passepartoutFarve"><br><br>

    <label for="antal">Antal:</label>
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

    <button type="submit">Gem data</button>
</form>

</body>
</html>

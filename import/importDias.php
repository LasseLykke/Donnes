<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    die('Du skal være logget ind for at bruge denne side.');
}
$logged_in_user = $_SESSION['user_name'];

include '../header.php';
?>

<!DOCTYPE html>
<html lang="da">

<head>
    <meta charset="UTF-8">
    <title>Dias ordre</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
</head>

<body>

    <nav class="navbar">
        <a href="../forside.php">
            <img src="../img/hflogo.png" class="logo" alt="logo"></a>
        <h3>Hej
            <?php echo $_SESSION['name']; ?> 👋🏻
        </h3>
        <a href="../logout.php"><button class="signOut" alt="LogOut"></button>
        </a>
    </nav>

    <div class="wrapperOrdre">
        <form id="ordreForm">
            <!-- KUNDE INFORMATION -->
            <h2 class="ordreSection">Kunde Information:</h2>
            <div class="grid2">
                <div class="kundenavn">
                    <label for="kundeNavn">Navn:</label>
                    <input type="text" id="kundeNavn" name="kundeNavn" required>
                </div>

                <div class="kundenummer">
                    <label for="kundeTelefon">Telefon:</label>
                    <input type="text" id="kundeTelefon" name="kundeTelefon" required>
                </div>
            </div>

            <!-- Dias INFORMATION -->
            <h2 class="ordreSection">DIAS Information:</h2>
            <div class="grid4">

                <div class="diasType">
                    <label><strong>Diastype:</strong> </label><br>
                    <input type="checkbox" id="Plastisk" name="diasType[]" value="Plastisk">
                    <label for="Plastisk">Plastisk</label><br>
                    <input type="checkbox" id="Metal" name="diasType[]" value="Metal">
                    <label for="Metal">Metal</label><br>
                    <input type="checkbox" id="Pap" name="diasType[]" value="Pap">
                    <label for="Pap">Pap</label><br>
                    <input type="checkbox" id="Glas" name="diasType[]" value="Glas">
                    <label for="Glas">Glas</label><br>
                    <input type="checkbox" id="Løse" name="diasType[]" value="Løse">
                    <label for="Løse">Løse</label><br>
                </div>


                <div class="antal">
                    <label for="diasAntal">Antal dias ialt</label>
                    <input type="number" id="diasAntal" name="diasAntal">
                </div>

                <div class="diasmedie">
                    <label><strong>Medie Type:</strong></label><br>

                    <input type="checkbox" id="USB" name="medieType[]" value="USB">
                    <label for="USB">USB</label>
                    <br>
                    <input type="checkbox" id="DVD" name="medieType[]" value="DVD">
                    <label for="DVD">DVD</label>
                    <br>
                    <input type="checkbox" id="Print" name="medieType[]" value="Print">
                    <label for="Print">Print</label>

                    

                </div>



            </div>


            <div class="grid4">
                <div class="prøve">
                    <label><strong>Prøve scan:</strong></label><br>

                    <input type="radio" id="prøveJa" name="prøve" value="Ja">
                    <label for="prøveJa">Ja</label>
                    <input type="radio" id="prøveNej" name="prøve" value="Nej">
                    <label for="prøveNej">Nej</label> 

                    <br><br>

                    <label><strong>Afpudses?:</strong></label><br>
                    <input type="radio" id="pudsesJa" name="afpudsning" value="Ja">
                    <label for="pudsesJa">Ja</label>
                    <input type="radio" id="pudsesNej" name="afpudsning" value="Nej">
                    <label for="pudsesNej">Nej</label>


                </div>

                <div class="bemærkning">
                    <label for="bemærkninger">Bemærkninger:</label>
                    <textarea id="bemærkninger" placeholder="" name="bemærkninger"></textarea>
                </div>


                <div class="pris">
                    <label for="pris">Pris:</label>
                    <input type="number" step="0.01" id="pris" name="pris" placeholder="Ordre total" required><br>
                </div>

            </div>








            <div class="ghost">
                <label for="ekspedient">Ekspedient:</label>
                <input type="text" id="ekspedient" name="ekspedient"
                    value="<?php echo htmlspecialchars($logged_in_user); ?>" readonly>
            </div>




            <button id="submitButton" class="saveBtn" type="submit">Gem ordre</button>
            <button id="printButton" class="printBtn" disabled>Print Ordre x2!</button>
            <div id="statusMessage"></div>

    </div>


    <script>
        $(document).ready(function () {
            $("#ordreForm").on("submit", function (e) {
                e.preventDefault(); // Forhindrer standard formularindsendelse

                const submitButton = $("#submitButton");
                const printButton = $("#printButton");
                const statusMessage = $("#statusMessage");

                const formData = $(this).serialize(); // Saml alle formularfelter

                // Start knapanimation
                submitButton.prop("disabled", true).addClass("saving").text("Gemmer...");

                // AJAX-opkald
                $.ajax({
                    url: "insertDataDias.php", // Dit PHP-script til at gemme data
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        // Opdater gem-knappen til succes-tilstand
                        submitButton.text("Ordre gemt").removeClass("saving").addClass("saved");

                        // Fjern successtil efter en tid
                        setTimeout(() => {
                            submitButton.removeClass("saved").text("Gem ordre").prop("disabled", false);
                        }, 2000);

                        $("body").addClass("orderSaved");

                        // Aktiver printknap og tilføj CSS-klassen "printBtn"
                        printButton.prop("disabled", false).addClass("printBtn");
                    },
                    error: function (xhr, status, error) {
                        // Håndter fejl
                        submitButton.text("Gem ordre").removeClass("saving").prop("disabled", false);
                        statusMessage.html("<p>Fejl: Kunne ikke gemme ordren.</p>").fadeIn().delay(3000).fadeOut();
                    }
                });
            });

            // Printknap funktion
            $("#printButton").on("click", function () {
                window.location.href = "../export/exportToPrintDias.php"; // Henvisning til print-siden
            });
        });
    </script>

</body>

</html>
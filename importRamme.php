<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    die('Du skal være logget ind for at bruge denne side.');
}
$logged_in_user = $_SESSION['user_name'];

include 'header.php';
?>

<!DOCTYPE html>
<html lang="da">

<head>
    <meta charset="UTF-8">
    <title>Ramme ordre</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
</head>

<body>

    <nav class="navbar">
        <a href="forside.php">
            <img src="./img/hflogo.png" class="logo" alt="logo"></a>
        <h3>Hej
            <?php echo $_SESSION['name']; ?> 👋🏻
        </h3>
        <a href="logout.php"><button class="signOut" alt="LogOut"></button>
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

            <!-- RAMME INFORMATION -->
            <h2 class="ordreSection">Ramme Information:</h2>
            <div class="grid3">
                <div class="profil">
                    <label for="profil">Profil:</label>
                    <input type="text" id="profil" name="profil" required>
                </div>
                <div class="størrelse">
                    <label for="størrelse">Størrelse:</label>
                    <input type="text" id="størrelse" name="størrelse" required>
                </div>
                <div class="antal">
                    <label for="antal">Antal rammer:</label>
                    <input type="number" id="antal" name="antal" required>
                </div>
            </div>

            <!-- GLAS -->
            <h2 class="ordreSection">Glastype:</h2>
            <div class="grid4">
                <div class="glas">
                    <input type="radio" id="klart" name="glastype" value="Klart glas" required>
                    <label for="klart">Klart Glas</label><br>

                    <input type="radio" id="reflo" name="glastype" value="Reflo glas" required>
                    <label for="reflo">Reflo glas</label><br>

                    <input type="radio" id="museums" name="glastype" value="Museums glas" required>
                    <label for="museums">Museums Glas</label>
                </div>
                <div class="glas">
                    <input type="radio" id="tom" name="glastype" value="Uden glas" required>
                    <label for="tom_uden_bagplade">Uden glas</label><br>

                    <input type="radio" id="tom_uden_bagplade" name="glastype" value="Tom uden bagplade" required>
                    <label for="tom">Uden glas og bagplade</label><br>

                    <input type="radio" id="tom_uden_bagplade_og_fligner" name="glastype"
                        value="Tom uden bagplade og fligner" required>
                    <label for="tom">Uden glas, bagplade og fligner</label>
                </div>
            </div>


            <!-- PASSEPARTOUT -->
            <h2 class="ordreSection">Passepartout:</h2>
            <div class="grid4">
                <div class="hulmål">
                    <label for="hulmål">Hulmål:</label><br>
                    <input type="text" id="hulmål" name="hulmål"><br>
                    <p class="note">Hulmål: Fratræk 1cm fra billedmålet</p>
                </div>

                <div class="passepartout">
                    <input type="radio" id="8001" name="passepartoutFarve" value="8001">
                    <label for="profil_8001">Hvidt med hvid kerne (8001)</label><br>
                    <input type="radio" id="8213" name="passepartoutFarve" value="8213">
                    <label for="profil_8213">Knækket hvid med hvid kerne (8213)</label><br>
                    <input type="radio" id="profil_8011" name="passepartoutFarve" value="8011">
                    <label for="profil_8011">Sort med hvid kerne (8011)</label><br>
                    <input type="radio" id="7011" name="passepartoutFarve" value="7011">
                    <label for="profil_7011">Sort med sort kerne (7011)</label><br>
                    <input type="radio" id="8051" name="passepartoutFarve" value="8051">
                    <label for="profil_8051">Lyseblå med hvid kerne (8051)</label><br>
                </div>
                <div class="passepartout">
                    <input type="radio" id="8071" name="passepartoutFarve" value="8071">
                    <label for="profil_8071">Mørkeblå med hvid kerne (8071)</label><br>
                    <input type="radio" id="8816" name="passepartoutFarve" value="8816">
                    <label for="profil_8816">Bordeaux med hvid kerne (8816)</label><br>
                    <input type="radio" id="8611" name="passepartoutFarve" value="8611">
                    <label for="profil_8611">Karry gul med hvid kerne (8611)</label><br>
                    <input type="radio" id="8411" name="passepartoutFarve" value="8411">
                    <label for="profil_8411">Olivengrøn med hvid kerne (8411)</label><br>
                    <input type="radio" id="8009" name="passepartoutFarve" value="8009">
                    <label for="profil_8009">Lysebrun med hvid kerne (8009)</label>
                </div>
            </div>


            <!-- MONTERING & PRIS -->
            <h2 class="ordreSection">Montering & pris:</h6>
                <div class="grid4">
                    <div class="montering">
                        <h5>Skal vi montere?</h5><br>
                        <input type="radio" id="montering_JA" name="montering" value="Ja" required>
                        <label for="montering_JA">Ja</label>
                        <input type="radio" id="montering_NEJ" name="montering" value="Nej" required>
                        <label for="montering_NEJ">Nej</label>
                        <br><br>
                        <input type="radio" id="kundens_Billede" name="billedtype" value="Kundens billede">
                        <label for="kundens_Billede">Kundens billede</label><br>
                        <input type="radio" id="print_Billede" name="billedtype" value="Vi skal printe">
                        <label for="print_Billede">Vi skal printe billede</label>
                    </div>

                    <div class="bemærkning">
                        <label for="bemærkninger">Bemærkninger:</label><br>
                        <textarea id="bemærkninger" name="bemærkninger"
                            placeholder="Indsæt posenummer eller andre bemærkninger"></textarea>
                    </div>

                    <div class="pris">
                        <label for="pris">Pris:</label>
                        <input type="number" step="0.01" id="pris" name="pris" required><br>
                    </div>
                </div>

                <div class="ghost">
                    <label for="ekspedient">Ekspedient:</label>
                    <input type="text" id="ekspedient" name="ekspedient"
                        value="<?php echo htmlspecialchars($logged_in_user); ?>" readonly>
                </div>




                <button id="submitButton" class="saveBtn" type="submit">Gem ordre</button>
                <button id="printButton" class="printBtn" disabled>Print Ordre</button>
                <div id="statusMessage"></div>


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
                                url: "insertDataRammer.php", // Dit PHP-script til at gemme data
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
                            window.location.href = "exportToPrint.php"; // Henvisning til print-siden
                        });
                    });
                </script>

</body>

</html>
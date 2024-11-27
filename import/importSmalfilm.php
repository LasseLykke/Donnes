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
    <title>Smalfilm ordre</title>
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

            <!-- Smalfilm INFORMATION -->
            <h2 class="ordreSection">Smalfilm Information:</h2>
            <div class="grid4">

                <div class="smalfilm">
                    
                    <label for="antal">Antal spoler:</label>
                    <input type="number" id="antal" name="antal"><br>
                </div>


                <div class="medie">
                    <label><strong>Medie Type:</strong></label><br>

                    <input type="checkbox" id="USB" name="medieType[]" value="USB">
                    <label for="USB">USB</label>
                    <br>
                    <input type="checkbox" id="DVD" name="medieType[]" value="DVD">
                    <label for="DVD">DVD</label>



                </div>



            </div>


            <div class="grid2">
                
                </div>

                <div class="bemærkning">
                    <label for="bemærkninger">Bemærkninger:</label>
                    <textarea id="bemærkninger" placeholder="" name="bemærkninger"></textarea>
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
    let orderSaved = false; // Flag til at spore, om ordren er gemt

    $("#ordreForm").on("submit", function (e) {
        e.preventDefault(); // Forhindrer standard formularindsendelse

        if (orderSaved) {
            // Hvis ordren allerede er gemt, skal handlingen ikke udføres igen
            return;
        }

        const submitButton = $("#submitButton");
        const printButton = $("#printButton");
        const statusMessage = $("#statusMessage");

        const formData = $(this).serialize(); // Saml alle formularfelter

        // Start knapanimation
        submitButton.prop("disabled", true).addClass("saving").text("Gemmer...");

        // AJAX-opkald
        $.ajax({
            url: "insertDataSmalfilm.php", // Dit PHP-script til at gemme data
            type: "POST",
            data: formData,
            success: function (response) {
                orderSaved = true; // Sæt flag til true, når gemning lykkes

                // Opdater gem-knappen til succes-tilstand
                submitButton.text("Ordre gemt").removeClass("saving").addClass("saved");

                // Fjern successtil efter en tid
                setTimeout(() => {
                    submitButton.removeClass("saved").text("Gem ordre").prop("disabled", false);
                }, 2000);

                $("body").addClass("orderSaved");

                // Aktiver printknap
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
        if (!orderSaved) {
            alert("Du skal gemme ordren, før du kan printe.");
            return;
        }
        window.location.href = "../export/exportToPrintSmalfilm.php"; // Henvisning til print-siden
    });
});

    </script>

</body>

</html>
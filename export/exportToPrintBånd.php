<?php
// Start session
session_start();

// Tjek om brugeren er logget ind
if (!isset($_SESSION['users_id']) || !isset($_SESSION['user_name'])) {
    // Hvis ikke logget ind, omdiriger til login-siden
    header("Location: login.php");
    exit();
}

// Forbind til databasen
include '../connection.php';
include '../header.php';

// Hent den seneste ordre fra databasen
$query = "
    SELECT 
        ordre.ordreID,
        ordre.ordreDate,
        kunde.Navn,
        kunde.Telefon,
        bånd.båndType,
        bånd.båndAntal,
        bånd.båndMedie,
        bånd.båndMedieKopi,
        bånd.båndNotes,
        bånd.båndPris,
        bånd.ekspedient
    FROM ordre
    LEFT JOIN kunde ON ordre.kundeID = kunde.kundeID
    LEFT JOIN bånd ON ordre.ordreID = bånd.ordreID
    ORDER BY ordre.ordreID DESC
    LIMIT 1
";
$result = mysqli_query($conn, $query);

// Kontrollér om en ordre blev fundet
$orderDetails = mysqli_fetch_assoc($result);

if (!$orderDetails) {
    die("Ingen ordre fundet.");
}
?>

<!DOCTYPE html>
<html lang="da">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordrebekræftelse</title>
    <script>
        // Automatisk print, når siden er indlæst
        window.onload = function () {
            window.print();
        };
    </script>
</head>

<body>
    <div class="logoWrapper">
        <a href="../forside.php">
            <img src="../img/hflogoUp.png" class="printLogo" alt="Logo">
        </a>
    </div>
    <div class="wrapper">
        <h2>Tak for din ordre</h2>
        <p class="ordreText">Kære <?php echo htmlspecialchars($orderDetails['Navn']); ?>, <br>Tusinde tak for din
            bestilling. Her kan du
            se en oversigt over din ordre: </p><br><br>

        <p class="ordreText">
            <strong>Ordrenr:</strong> <?php echo htmlspecialchars($orderDetails['ordreID']); ?><br>
            <strong>Ordredato:</strong>
            <?php
            $formattedDate = date("d/m-Y", strtotime($orderDetails['ordreDate']));
            echo htmlspecialchars($formattedDate);
            ?><br>
            <strong>Kunde navn:</strong> <?php echo htmlspecialchars($orderDetails['Navn']); ?><br>
            <strong>Telefonnummer:</strong> <?php echo htmlspecialchars($orderDetails['Telefon']); ?>

        </p>
        <table class="confTabel">
            <thead>

            </thead>
            <tbody>
                <tr>
                    <td>Bånd type:</td>
                    <td><?php echo htmlspecialchars($orderDetails['båndType']); ?></td>
                </tr>
                <tr>
                    <td>Afleveret bånd:</td>
                    <td><?php echo htmlspecialchars($orderDetails['båndAntal']); ?></td>
                </tr>
                <tr>
                    <td>Bånd bliver overspillet til:</td>
                    <td><?php echo htmlspecialchars($orderDetails['båndMedie']); ?></td>
                </tr>
                <tr>
                    <td>Kopier:</td>
                    <td><?php echo htmlspecialchars($orderDetails['båndMedieKopi']); ?></td>
                </tr>
                <tr>
                    <td>Bemærkninger:</td>
                    <td><?php echo htmlspecialchars($orderDetails['båndNotes']); ?></td>
                </tr>
                <tr>
                    <td>Pris:</td>
                    <td><?php echo htmlspecialchars($orderDetails['båndPris']); ?> DKK</td>
                </tr>
                <tr>
                    <td>Du er blevet ekspederet af:</td>
                    <td><?php echo htmlspecialchars($orderDetails['ekspedient']); ?></td>
                </tr>
            </tbody>
        </table><br>

        <h2>Hvad sker der nu?</h2>
        <p class="ordreText">Vi går straks i gang med at sætte din ordre i produktion! Alt efter vores aftale
            overspilles dine bånd enten til DVD eller USB. Hvis du har valgt USB, leveres filerne i MP4-format – et af
            de mest anvendte og kompatible videoformater. Når din ordre er færdig og klar til afhentning, modtager du en
            SMS fra os. Vi glæder os til at levere et godt resultat! </p><br><br>


    </div>
</body>

</html>
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
        dias.diasType,
        dias.diasAntal,
        dias.medieType,
        dias.afpudsning,
        dias.prøve,
        dias.bemærkninger,
        dias.pris,
        dias.ekspedient
    FROM ordre
    LEFT JOIN kunde ON ordre.kundeID = kunde.kundeID
    LEFT JOIN dias ON ordre.ordreID = dias.ordreID
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
                    <td>Dias type:</td>
                    <td><?php echo htmlspecialchars($orderDetails['diasType']); ?></td>
                </tr>
                <tr>
                    <td>Antal dias indleveret:</td>
                    <td><?php echo htmlspecialchars($orderDetails['diasAntal']); ?></td>
                </tr>
                <tr>
                    <td>Medie:</td>
                    <td><?php echo htmlspecialchars($orderDetails['medieType']); ?></td>
                </tr>
                <tr>
                    <td>Skal de afpudses:</td>
                    <td><?php echo htmlspecialchars($orderDetails['afpudsning']); ?></td>
                </tr>
                <tr>
                    <td>Prøve:</td>
                    <td><?php echo htmlspecialchars($orderDetails['prøve']); ?></td>
                </tr>
                <tr>
                    <td>Bemærkninger:</td>
                    <td><?php echo htmlspecialchars($orderDetails['bemærkninger']); ?></td>
                </tr>
                <tr>
                    <td>Pris:</td>
                    <td><?php echo htmlspecialchars($orderDetails['pris']); ?> DKK</td>
                </tr>
                <tr>
                    <td>Du er blevet ekspederet af:</td>
                    <td><?php echo htmlspecialchars($orderDetails['ekspedient']); ?></td>
                </tr>
            </tbody>
        </table><br>

        <h2>Hvad sker der nu?</h2>
        <p class="ordreText">Din ordre går nu i produktion! Vi scanner dine dias med professionelt udstyr og
            anvender farvekorrigering samt støvreducering for at sikre det bedst mulige resultat.<br> Når din ordre er færdig og klar til
            afhentning, sender vi dig en SMS. Vi ser frem til at levere et resultat, der lever op til dine
            forventninger! </p><br><br>


    </div>
</body>

</html>
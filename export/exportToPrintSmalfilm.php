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
        smalfilm.antal,
        smalfilm.medieType,
        smalfilm.bemærkninger,
        smalfilm.ekspedient
    FROM ordre
    LEFT JOIN kunde ON ordre.kundeID = kunde.kundeID
    LEFT JOIN smalfilm ON ordre.ordreID = smalfilm.ordreID
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
                    <td>Antal spoler:</td>
                    <td><?php echo htmlspecialchars($orderDetails['antal']); ?></td>
                </tr>
                <tr>
                    <td>Overspilles til:</td>
                    <td><?php echo htmlspecialchars($orderDetails['medieType']); ?></td>
                </tr>
                <tr>
                    <td>Bemærkninger:</td>
                    <td><?php echo htmlspecialchars($orderDetails['bemærkninger']); ?></td>
                </tr>
                <tr>
                    <td>Du er blevet ekspederet af:</td>
                    <td><?php echo htmlspecialchars($orderDetails['ekspedient']); ?></td>
                </tr>
            </tbody>
        </table><br>

        <h2>Hvad sker der nu?</h2>
        <p class="ordreText">Din smalfilm går nu i produktion! Vi digitaliserer dine film med professionelt udstyr for
            at bevare kvaliteten og fremhæve detaljerne. For at sikre det bedst mulige resultat foretager vi nøje
            farvekorrigering og optimering. Når arbejdet er færdigt og klar til afhentning, sender vi dig en SMS. Vi
            glæder os til at levere minderne tilbage i ny digital kvalitet! </p><br><br>


    </div>
</body>

</html>
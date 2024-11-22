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
include 'connection.php';
include 'header.php';

// Hent den seneste ordre fra databasen
$query = "
    SELECT 
        ordre.ordreID,
        ordre.ordreDate,
        kunde.Navn,
        kunde.Telefon,
        ramme.profil,
        ramme.størrelse,
        ramme.glastype,
        ramme.hulmål,
        ramme.passepartoutFarve,
        ramme.antal,
        ramme.montering,
        ramme.billedtype,
        ramme.bemærkninger,
        ramme.pris,
        ramme.ekspedient
    FROM ordre
    LEFT JOIN kunde ON ordre.kundeID = kunde.kundeID
    LEFT JOIN ramme ON ordre.ordreID = ramme.ordreID
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
        <a href="forside.php">
            <img src="img/hflogoUp.png" class="printLogo" alt="Logo">
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
        <table>
            <thead>

            </thead>
            <tbody>
                <tr>
                    <td>Ramme Profil:</td>
                    <td><?php echo htmlspecialchars($orderDetails['profil']); ?></td>
                </tr>
                <tr>
                    <td>Ramme Størrelse:</td>
                    <td><?php echo htmlspecialchars($orderDetails['størrelse']); ?></td>
                </tr>
                <tr>
                    <td>Glastype:</td>
                    <td><?php echo htmlspecialchars($orderDetails['glastype']); ?></td>
                </tr>
                <tr>
                    <td>Hulmål:</td>
                    <td><?php echo htmlspecialchars($orderDetails['hulmål']); ?></td>
                </tr>
                <tr>
                    <td>Passepartout Farve:</td>
                    <td><?php echo htmlspecialchars($orderDetails['passepartoutFarve']); ?></td>
                </tr>
                <tr>
                    <td>Antal Rammer:</td>
                    <td><?php echo htmlspecialchars($orderDetails['antal']); ?></td>
                </tr>
                <tr>
                    <td>Montering af billede:</td>
                    <td><?php echo htmlspecialchars($orderDetails['montering']); ?></td>
                </tr>
                <tr>
                    <td>Dit eget billede eller skal vi printe:</td>
                    <td><?php echo htmlspecialchars($orderDetails['billedtype']); ?></td>
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
        <p class="ordreText">Din ordre sættes straks i produktion. Når rammen er færdiggjort på værkstedet, monterer vi
            dit billede, hvis dette er aftalt. Vi sørger samtidig for at pudse glasset og sikre, at billedet er klar til
            ophængning. Du vil modtage en SMS, så snart din ordre er klar til afhentning. </p><br><br>


    </div>
</body>

</html>
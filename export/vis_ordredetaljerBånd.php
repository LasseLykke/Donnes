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

// Tjek om ordreID er sendt
if (isset($_POST['ordreID'])) {
    $ordreID = mysqli_real_escape_string($conn, $_POST['ordreID']);

    // Hent detaljer for den valgte ordre
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
        WHERE ordre.ordreID = '$ordreID'
    ";
    $result = mysqli_query($conn, $query);

    // Kontrollér om ordren blev fundet
    $orderDetails = mysqli_fetch_assoc($result);

    if (!$orderDetails) {
        die("Ingen detaljer fundet for denne ordre.");
    }
} else {
    die("Ingen ordre valgt.");
}
?>

<!DOCTYPE html>
<html lang="da">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordredetaljer</title>

    <script>
        // Funktion til print
        function printOrderDetails() {
            window.print();
        }
    </script>
</head>

<body>
    <div class="logoWrapper">
        <a href="../forside.php">
            <img src="../img/hflogoUp.png" class="printLogo" alt="Logo">
        </a>
    </div>
    <div class="wrapper">
        <h2>Ordredetaljer:</h2><br>

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
                    <td>Medie:</td>
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
                    <td>Ekspedient:</td>
                    <td><?php echo htmlspecialchars($orderDetails['ekspedient']); ?></td>
                </tr>
            </tbody>
        </table><br>

        <div class="printButtonWrapper">
            <button onclick="printOrderDetails()" class="mainBtn">Print</button>
        </div>
    </div>
</body>

</html>
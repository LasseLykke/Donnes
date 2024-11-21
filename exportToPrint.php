<?php
// Forbind til databasen
include 'connection.php'; // Sørg for at have din connection-fil klar
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
    <link rel="stylesheet" href="styles.css">
    <--<script>
        // Automatisk print, når siden er indlæst
        window.onload = function () {
            window.print();
        };
    </script> -->
</head>
<body>
    <div class="wrapper">
    <h1>Tak for din ordre</h1>
    <p>Kære <?php echo htmlspecialchars($orderDetails['Navn']); ?>, tak fordi du har handlet hos os. Her er en oversigt over din ordre:</p>

    <table>
        <thead>
            <tr>
                <th>Felt</th>
                <th>Detaljer</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ordre:</td>
                <td><?php echo htmlspecialchars($orderDetails['ordreID']); ?></td>
            </tr>
            <tr>
                <td>Dato:</td>
                <td><?php echo htmlspecialchars($orderDetails['ordreDate']); ?></td>
            </tr>
            <tr>
                <td>Kunde Navn:</td>
                <td><?php echo htmlspecialchars($orderDetails['Navn']); ?></td>
            </tr>
            <tr>
                <td>Telefon:</td>
                <td><?php echo htmlspecialchars($orderDetails['Telefon']); ?></td>
            </tr>
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
                <td>Montering:</td>
                <td><?php echo htmlspecialchars($orderDetails['montering']); ?></td>
            </tr>
            <tr>
                <td>Billedtype:</td>
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
                <td>Ekspedient</td>
                <td><?php echo htmlspecialchars($orderDetails['ekspedient']); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Vi ser frem til at handle med dig igen!</p>
    </div>
    </div>
</body>
</html>

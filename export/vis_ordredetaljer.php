<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {
    include '../connection.php';

    if (isset($_POST['ordreID'])) {
        $ordreID = mysqli_real_escape_string($conn, $_POST['ordreID']);

        // Hent detaljer for ordren
        $sql = "SELECT ramme.*, kunde.navn AS kunde_navn, kunde.telefon AS kunde_telefon, ordre.ordreDate
                FROM ramme
                INNER JOIN ordre ON ramme.ordreID = ordre.ordreID
                INNER JOIN kunde ON ordre.kundeID = kunde.kundeID
                WHERE ramme.ordreID = '$ordreID'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $orderDetails = mysqli_fetch_assoc($result);

            echo "<h1>Detaljer for ordre #" . $orderDetails['ordreID'] . "</h1>";
            echo "<p>Dato: " . $orderDetails['ordreDate'] . "</p>";
            echo "<p>Kunde: " . $orderDetails['kunde_navn'] . "</p>";
            echo "<p>Telefon: " . $orderDetails['kunde_telefon'] . "</p>";
            echo "<p>Rammeprofil: " . $orderDetails['profil'] . "</p>";
            echo "<p>Pris: " . $orderDetails['pris'] . " DKK</p>";
            // ... Tilføj flere detaljer som ønsket
        } else {
            echo "Ordre ikke fundet.";
        }

        mysqli_free_result($result);
    } else {
        echo "Ingen ordre valgt.";
    }

    mysqli_close($conn);
} else {
    header("Location: login.php");
    exit();
}
?>

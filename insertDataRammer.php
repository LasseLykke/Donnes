<?php
session_start();
if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'connection.php';  // Forbindelsen til databasen

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Modtag data fra formularen
        $ordreDate = $_POST['ordreDate'];
        $kundeNavn = $_POST['kundeNavn'];
        $kundeTelefon = $_POST['kundeTelefon'];
        $profil = $_POST['profil'];
        $størrelse = $_POST['størrelse'];
        $glastype = $_POST['glastype'];
        $passepartout = $_POST['passepartout'];
        $hulmål = $_POST['hulmål'];
        $passepartoutFarve = $_POST['passepartoutFarve'];
        $antal = $_POST['antal'];
        $montering = $_POST['montering'];
        $billedtype = $_POST['billedtype'];
        $bemærkninger = $_POST['bemærkninger'];
        $pris = $_POST['pris'];

        // Start transaktion
        $conn->begin_transaction();

        try {
            // Indsæt data i kunde-tabellen
            $stmt_kunde = $conn->prepare("INSERT INTO kunde (navn, telefon) VALUES (?, ?)");
            $stmt_kunde->bind_param("ss", $kundeNavn, $kundeTelefon);
            $stmt_kunde->execute();
            $kundeID = $conn->insert_id;

            // Indsæt data i ordre-tabellen
            $stmt_ordre = $conn->prepare("INSERT INTO ordre (ordreDate, kundeID) VALUES (?, ?)");
            $stmt_ordre->bind_param("si", $ordreDate, $kundeID);
            $stmt_ordre->execute();
            $ordreID = $conn->insert_id;

            // Indsæt data i ramme-tabellen med alle felter
            $stmt_ramme = $conn->prepare("INSERT INTO ramme (ordreID, profil, størrelse, glastype, passepartout, hulmål, passepartoutFarve, antal, montering, billedtype, bemærkninger, pris) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_ramme->bind_param("issssssisssd", $ordreID, $profil, $størrelse, $glastype, $passepartout, $hulmål, $passepartoutFarve, $antal, $montering, $billedtype, $bemærkninger, $pris);
            $stmt_ramme->execute();

            // Commit transaktionen
            $conn->commit();

            echo "Data indsat succesfuldt!";
        } catch (Exception $e) {
            // Rollback ved fejl
            $conn->rollback();
            echo "Fejl ved indsættelse af data: " . $e->getMessage();
        }
    }

} else {
    echo "Du skal være logget ind for at indsætte data.";
}
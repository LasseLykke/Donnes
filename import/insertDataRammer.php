<?php
session_start();
if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include '../connection.php';  // Forbindelsen til databasen

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sæt ordreDate automatisk til dagens dato
        $ordreDate = date('Y-m-d');

        // Modtag data fra formularen
        $kundeNavn = $_POST['kundeNavn'];
        $kundeTelefon = $_POST['kundeTelefon'];
        $profil = $_POST['profil'];
        $størrelse = $_POST['størrelse'];
        $glastype = $_POST['glastype'];
        $hulmål = $_POST['hulmål'];
        $passepartoutFarve = isset($_POST["passepartoutFarve"]) ? htmlspecialchars($_POST["passepartoutFarve"]) : '';
        $antal = $_POST['antal'];
        $montering = $_POST['montering'];
        $billedtype = isset($_POST["billedtype"]) ? htmlspecialchars($_POST["billedtype"]) : '';
        $bemærkninger = $_POST['bemærkninger'];
        $pris = $_POST['pris'];
        $ekspedient = $_POST['ekspedient'];


        // Start transaktion
        $conn->begin_transaction();

        try {
            // Indsæt data i kunde-tabellen
            $stmt_kunde = $conn->prepare("INSERT INTO kunde (navn, telefon) VALUES (?, ?)");
            $stmt_kunde->bind_param("ss", $kundeNavn, $kundeTelefon);
            $stmt_kunde->execute();
            $kundeID = $conn->insert_id;

            // Indsæt data i ordre-tabellen med den automatisk genererede dato
            $stmt_ordre = $conn->prepare("INSERT INTO ordre (ordreDate, kundeID) VALUES (?, ?)");
            $stmt_ordre->bind_param("si", $ordreDate, $kundeID);
            $stmt_ordre->execute();
            $ordreID = $conn->insert_id;

            $stmt_ramme = $conn->prepare("INSERT INTO ramme (ordreID, profil, størrelse, glastype, hulmål, passepartoutFarve, antal, montering, billedtype, bemærkninger, pris, ekspedient) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_ramme->bind_param("isssssisssds", $ordreID, $profil, $størrelse, $glastype, $hulmål, $passepartoutFarve, $antal, $montering, $billedtype, $bemærkninger, $pris, $ekspedient);
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

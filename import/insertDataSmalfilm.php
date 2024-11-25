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
        $båndTyper = isset($_POST['båndType']) ? $_POST['båndType'] : [];
        $båndTypeString = implode(',', $båndTyper); // Kombiner valgte båndtyper til en kommasepareret streng
        $båndAntal = $_POST['båndAntal'];
        $båndMedie = $_POST['båndMedie'];
        $båndMedieKopi = isset($_POST["båndMedieKopi"]) ? intval($_POST["båndMedieKopi"]) : 0;
        $båndNotes = $_POST["båndNotes"];
        $båndPris = $_POST["båndPris"];
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

            // Indsæt hver båndType i bånd-tabellen
            $stmt_bånd = $conn->prepare("INSERT INTO bånd (ordreID, båndType, båndAntal, båndMedie, båndMedieKopi, båndNotes, båndPris, ekspedient) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_bånd->bind_param("isisssds", $ordreID, $båndTypeString, $båndAntal, $båndMedie, $båndMedieKopi, $båndNotes, $båndPris, $ekspedient);
            $stmt_bånd->execute();

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

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
        $antal =$_POST['antal'];
        $medieTyper = isset($_POST['medieType']) ? $_POST['medieType'] : [];
        $medieTypeString = !empty($medieTyper) ? implode(',', $medieTyper) : null;
        $bemærkninger = $_POST['bemærkninger'];
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
            $stmt_bånd = $conn->prepare("INSERT INTO smalfilm (ordreID, antal, medieType, bemærkninger, ekspedient) VALUES (?, ?, ?, ?, ?)");
            $stmt_bånd->bind_param("iisss", $ordreID, $antal, $medieTypeString, $bemærkninger, $ekspedient);
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

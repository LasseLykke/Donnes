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
        $diasTyper = isset($_POST['diasType']) ? $_POST['diasType'] : [];
        $diasTypeString = !empty($diasTyper) ? implode(',', $diasTyper) : null;
        $diasAntal = $_POST['diasAntal'];
        $medieTyper = isset($_POST['medieType']) ? $_POST['medieType'] : [];
        $medieTypeString = !empty($medieTyper) ? implode(',', $medieTyper) : null;
        $afpudsning = $_POST['afpudsning'];
        $prøve = $_POST['prøve'];
        $bemærkninger = $_POST["bemærkninger"];
        $pris = $_POST["pris"];
        $ekspedient = $_POST['ekspedient'];

        // Start transaktion
        $conn->begin_transaction();

        try {
            // Indsæt data i kunde-tabellen
            $stmt_kunde = $conn->prepare("INSERT INTO kunde (navn, telefon) VALUES (?, ?)");
            $stmt_kunde->bind_param("ss", $kundeNavn, $kundeTelefon);
            if (!$stmt_kunde->execute()) {
                throw new Exception("Fejl i kunde-tabellen: " . $stmt_kunde->error);
            }
            $kundeID = $conn->insert_id;

            // Indsæt data i ordre-tabellen
            $stmt_ordre = $conn->prepare("INSERT INTO ordre (ordreDate, kundeID) VALUES (?, ?)");
            $stmt_ordre->bind_param("si", $ordreDate, $kundeID);
            if (!$stmt_ordre->execute()) {
                throw new Exception("Fejl i ordre-tabellen: " . $stmt_ordre->error);
            }
            $ordreID = $conn->insert_id;

            // Indsæt data i dias-tabellen
            $stmt_dias = $conn->prepare("INSERT INTO dias (ordreID, diasType, diasAntal, medieType, afpudsning, bemærkninger, pris, prøve, ekspedient) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt_dias->bind_param("isisssiss", $ordreID, $diasTypeString, $diasAntal, $medieTypeString, $afpudsning, $bemærkninger, $pris, $prøve, $ekspedient);
            if (!$stmt_dias->execute()) {
                throw new Exception("Fejl i dias-tabellen: " . $stmt_dias->error);
            }

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

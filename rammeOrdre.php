<?php


if (isset($_SESSION['users_id']) && isset($_SESSION['user_name']))

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dates = $_POST["Indleveringsdato"];
    $names = $_POST["Kundens_navn"];
    $telefon = $_POST["telefon"];
    $rammeprofil = $_POST["Rammeprofil"];
    $rammestørrelse = $_POST["Rammestørrelse"];
    $glastype = $_POST["Glastype"];
    $passepartout = $_POST["Passepartout"];
    $passepartoutHulmål = $_POST["Hulmål"];
    $passepartoutFarve = $_POST["passepartoutFarve"];
    $antal = $_POST["Antal"];
    $montering = $_POST["montering"];
    $billedetype = $_POST["billedetype"];
    $bemærkninger = $_POST["bemærkninger"];
    $pris = $_POST["Pris"];
    $betalt = $_POST["betaling"];
    $Bestilt = $_POST["bestilt"];
    $ekspedient = $_POST["ekspedient"];

    

     try {
        require_once "connection.php";

        $query = "INSERT INTO rammer (dates, names, telefon, rammeprofil, rammestørrelse, glastype, passepartout, Hulmål, passepartoutFarve, antal, montering, billedetype, bemærkninger, pris, betalt, bestilt, ekspedient) VALUES
        (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,);";

        $stmt = $pdo->prepare($query);

        $stmt->execute([$dates, $names, $telefon, $rammeprofil, $rammestørrelse, $glastype, $passepartout, $passepartoutHulmål, $passepartoutFarve, $antal, $montering, $billedetype, $bemærkninger, $pris, $betalt, $Bestilt, $ekspedient]);

        $pdo = null;
        $stmt = null;
        header("Location: forside.php");
        die();
     } catch (PDOException $e) {
        die ("Query failed: " . $e->getMessage());
     }

} else {
    header("Location: index.php");
}





/*Print all - array
print_r($_POST);
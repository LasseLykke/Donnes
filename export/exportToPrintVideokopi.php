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

// Hent den seneste ordre fra databasen
$query = "
    SELECT 
            ordre.ordreID,
        ordre.ordreDate,
        kunde.Navn,
        kunde.Telefon,
        smalfilm.antal,
        smalfilm.medieType,
        smalfilm.bemærkninger,
        smalfilm.ekspedient
    FROM ordre
    LEFT JOIN kunde ON ordre.kundeID = kunde.kundeID
    LEFT JOIN smalfilm ON ordre.ordreID = smalfilm.ordreID
    ORDER BY ordre.ordreID DESC
    
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
    <title>Arbejdsseddel</title>
    <script>
        // Automatisk print, når siden er indlæst
        window.onload = function () {
            window.print();
        };
    </script>
</head>

<body>
    <div class="logoWrapper">
        <a href="../forside.php">
            <img src="../img/hflogoUp.png" class="printLogo" alt="Logo">
        </a>
    </div>
    <div class="wrapper">
        <h2>Arbejdsseddel:</h2>
        <p class="ordreText">Kære Videokopi,<br>

            Vi fremsender hermed smalfilm til overspilning på DVD.<br> Hvis der opstår spørgsmål undervejs, er I meget
            velkomne til at kontakte os.<br>

            Med venlig hilsen<br>
            Holm Foto ApS </p><br><br>

        <p class="ordreText">
            <strong>Ordrenr:</strong> <?php echo htmlspecialchars($orderDetails['ordreID']); ?><br>
            <strong>Ordredato:</strong>
            <?php
            $formattedDate = date("d/m-Y", strtotime($orderDetails['ordreDate']));
            echo htmlspecialchars($formattedDate); ?><br>
            <strong>Antal spoler:</strong> <?php echo htmlspecialchars($orderDetails['antal']); ?><br>
        </p><br><br>
        <table class="confTabel">
            <thead>
                <h2>udfyldes af videokopi:</h2>
            </thead>
            <tbody>
                <tr>
                    <td>Minutter:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Spoleskift:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Splejsninger:</td>
                    <td></td>
                </tr>
            </tbody>
        </table><br>
        <h2>Bemærkninger:</h2>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>




    </div>
</body>

</html>
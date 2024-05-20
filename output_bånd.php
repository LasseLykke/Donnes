<?php

session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>DONNÉS || ALLE BÅND ORDRE</title>
    <link href="./style/layout.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon"/>
    <meta http-equiv="refresh" content="900;url=logout.php"/>
</head>
<body>
<div class="søge-wrapper">
    <div class="søge-header">
        <h1 class="søgeoverskrift">Alle bånd ordre</h1><br>
        <a href="forside.php"><button class="backBtn">Tilbage</button></a>
    </div>

    <div class="søge-resultat">
        <form class="søgeform" method="POST" action="output_bånd.php">
            <input type="text" name="søgeord" placeholder="Søg efter ordre">
            <button type="submit" name="søg">Søg</button>
        </form>
    </div>
        <?php

        // Standard SQL-forespørgsel for at hente alle ordre
        $sql = "SELECT bånd.*, bånd_kunder.bk_fornavn AS kunde_fornavn, bånd_kunder.bk_telefonnummer AS kunde_telefonnummer, bånd_kunder.bk_kundeID, bånd.båndDates
        FROM bånd
        INNER JOIN bånd_kunder ON bånd.båndID = bånd_kunder.bk_kundeID ORDER BY bånd.båndID DESC";


;

// Check if search form is submitted
if (isset($_POST['søg'])) {
    $search = mysqli_real_escape_string($conn, $_POST['søgeord']);
    // Modify the SQL query to filter results based on search criteria
    $sql = "SELECT bånd.*, bånd_kunder.bk_fornavn AS kunde_fornavn, bånd_kunder.bk_telefonnummer AS kunde_telefonnummer, bånd_kunder.bk_kundeID
        FROM bånd
        INNER JOIN bånd_kunder ON bånd.båndID = bånd_kunder.bk_kundeID
            WHERE bånd_kunder.bk_fornavn LIKE '%$search%'
            OR bånd_kunder.bk_telefonnummer LIKE '%$search%'
            OR bånd.båndType LIKE '%$search%'
            OR bånd.båndAntal LIKE '%$search%'
            OR bånd.båndMedie LIKE '%$search%'
            OR bånd.båndMedieKopi LIKE '%$search%'
            OR bånd.båndNotes LIKE '%$search%'
            OR bånd.båndBetalt LIKE '%$search%'
            OR bånd.båndPris LIKE '%$search%'
            OR bånd.ekspedient LIKE '%$search%'
            ORDER BY bånd.båndID DESC";
}


$result = mysqli_query($conn, $sql);
$queryResult = mysqli_num_rows($result);

// Vis antallet af resultater
echo '<div class="resultat">';
echo "Der er " . $queryResult . " ordre";
echo '</div>';

// Vis tabel med alle ordre
echo '<div class="søge-resultat">';
echo '<table>
        <tr>
            <th>Ordre</th>
            <th>Dato</th>
            <th>Navn</th>
            <th>Telefon</th>
            <th>Type</th>
            <th>Antal</th>
            <th>Medie</th>
            <th>Antal</th>
            <th>Bemærkninger</th>
            <th>Betalt</th>
            <th>Pris</th>
            <th>Ekspedient</th>
        </tr>';

// Vis hver ordre som en række i tabellen
// Vis hver ordre som en række i tabellen
while ($row = mysqli_fetch_assoc($result)) {
    // Formatere datoen fra 'YYYY-MM-DD' til 'DD-MM-YYYY'
    $formattedDate = date("d-m-Y", strtotime($row["båndDates"]));

    echo '<tr>
            <td>' . $row["bk_kundeID"] . '</td>
            <td>' . $formattedDate . '</td>
            <td>' . $row["kunde_fornavn"] . '</td>
            <td>' . $row["kunde_telefonnummer"] . '</td>
            <td>' . $row["båndType"] . '</td>
            <td>' . $row["båndAntal"] . '</td>
            <td>' . $row["båndMedie"] . '</td>
            <td>' . $row["båndMedieKopi"] . '</td>
            <td>' . $row["båndNotes"] . '</td>
            <td>' . $row["båndBetalt"] . '</td>
            <td>' . $row["båndPris"] . '</td>
            <td>' . $row["ekspedient"] . '</td>
        </tr>';
}

echo '</table>';
echo '</div>'; // Lukker søge-resultat
echo '</div>'; // Lukker søge-wrapper

mysqli_free_result($result);
mysqli_close($conn);
}
?>


    </div> <!-- Lukker resultat -->
</div> <!--Lukker wrapper-->

<div>
    <button onClick="window.print()">Udskriv</button>
</div>

<!-- HOTFIX for at vende dokument udskrift i landscape -->
<style type="text/css" media="print">
    @page {
        size: landscape;
    }
</style>
</body>

</html>

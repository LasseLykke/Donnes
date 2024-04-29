<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>DONNÉS || Søge resultat</title>
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon"/>
    <link href="./style/layout.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="søge-wrapper">
    <div class="søge-header">
        <h1 class="søgeoverskrift">Søge Resultat</h1>
        <a href="forside.php"><button class="backBtn">Tilbage</button></a>
    </div>
    <div class="søge-resultat">

    <?php
    if(isset($_POST['submit-search'])) {
    // Definer søgetermen
    $search_query = $_POST['submit-search'];
    $table = $_POST['table'];

    // Opret SQL-forespørgsel baseret på søgeforespørgslen og den relevante tabel
    $sql = "SELECT kunder.kundeID, kunder.fornavn, kunder.telefonnummer,
        ramme.ordreID AS ramme_ordreID, ramme.profil AS ramme_profil, ramme.dates AS ramme_dates,
        bånd.ordreID AS bånd_ordreID, bånd.båndType AS bånd_båndType, bånd.båndDates AS bånd_båndDates
        FROM kunder
        LEFT JOIN ramme ON kunder.kundeID = ramme.kundeID
        LEFT JOIN bånd ON kunder.kundeID = bånd.båndkundeID";

    if ($table == 'ramme') {
        $sql .= " LEFT JOIN ramme ON kunder.kundeID = ramme.kundeID WHERE ramme.profil LIKE '%$search_query%'";
    } elseif ($table == 'bånd') {
        $sql .= " LEFT JOIN bånd ON kunder.kundeID = bånd.båndkundeID WHERE bånd.båndType LIKE '%$search_query%'";
    }

    // Udfør SQL-forespørgslen
    $result = $conn->query($sql);

    // Vis resultaterne
    if ($result->num_rows > 0) {
        echo '<table>
                <tr>
                    <th>Kunde ID</th>
                    <th>Fornavn</th>
                    <th>Telefonnummer</th>';
        if ($table == 'ramme') {
            echo '<th>Ramme Ordre ID</th>
                  <th>Ramme Profil</th>
                  <th>Ramme Dato</th>';
        } elseif ($table == 'bånd') {
            echo '<th>Bånd Ordre ID</th>
                  <th>Bånd Type</th>
                  <th>Bånd Dato</th>';
        }
        echo '</tr>';

        while($row = $result->fetch_assoc()) {
            // Vis resultaterne på din HTML-side
            echo "<tr>
                    <td>" . $row['kundeID'] . "</td>
                    <td>" . $row['fornavn'] . "</td>
                    <td>" . $row['telefonnummer'] . "</td>";
            if ($table == 'ramme') {
                echo '<td>' . $row['ramme_ordreID'] . '</td>
                      <td>' . $row['ramme_profil'] . '</td>
                      <td>' . $row['ramme_dates'] . '</td>';
            } elseif ($table == 'bånd') {
                echo '<td>' . $row['bånd_ordreID'] . '</td>
                      <td>' . $row['bånd_båndType'] . '</td>
                      <td>' . $row['bånd_båndDates'] . '</td>';
            }
            echo "</tr>";
        }

        echo '</table>';
    } else {
        echo "Ingen resultater fundet.";
    }

    // Luk forbindelsen til databasen
    $conn->close();
}
?>

    </div> <!-- Lukker resultat -->
</div> <!--Lukker wrapper-->
</body>
</html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>

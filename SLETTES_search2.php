<?php
session_start();

// Kontroller om brugeren er logget ind
if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    // Inkluder headeren
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
    // Hvis søgeformularen er blevet indsendt
    if (isset($_POST['submit-search'])) {
        // Søgeteksten
        $search = mysqli_real_escape_string($conn, $_POST['search']);

        // SQL-forespørgsel for at hente data fra både ramme- og bånd-tabellerne
        $sql = "SELECT 
            ramme.rammeID, 
            ramme.dates, 
            kunder.fornavn, 
            kunder.telefonnummer, 
            ramme.profil, 
            ramme.størrelse, 
            ramme.glastype, 
            ramme.passepartout, 
            ramme.hulmål, 
            ramme.passepartoutFarve, 
            ramme.antal, 
            ramme.montering, 
            ramme.billedetype, 
            ramme.bemærkninger, 
            ramme.ekspedient AS ekspedient,
            NULL AS båndID,
            NULL AS båndDates,
            NULL AS båndType,
            NULL AS båndAntal,
            NULL AS båndMedie,
            NULL AS båndMedieKopi,
            NULL AS båndNotes,
            NULL AS båndBetalt,
            NULL AS båndPris,
            NULL AS ekspedient
        FROM 
            ramme 
        INNER JOIN ramme_kunder ON ramme.rammeID = kunder.kundeID
        WHERE 
            kunder.kundeID LIKE '%$search%' 
            OR ramme.dates LIKE '%$search%' 
            OR kunder.fornavn LIKE '%$search%'
            OR kunder.telefonnummer LIKE '%$search%'
            OR ramme.profil LIKE '%$search%'
            OR ramme.størrelse LIKE '%$search%'
            OR ramme.glastype LIKE '%$search%'
            OR ramme.passepartout LIKE '%$search%'
            OR ramme.hulmål LIKE '%$search%'
            OR ramme.passepartoutFarve LIKE '%$search%'
            OR ramme.antal LIKE '%$search%'
            OR ramme.montering LIKE '%$search%'
            OR ramme.billedetype LIKE '%$search%'
            OR ramme.bemærkninger LIKE '%$search%'
            OR ramme.ekspedient LIKE '%$search%'
        UNION
        SELECT 
            NULL AS rammeID, 
            NULL AS dates, 
            kunder.fornavn, 
            kunder.telefonnummer, 
            NULL AS profil, 
            NULL AS størrelse, 
            NULL AS glastype, 
            NULL AS passepartout, 
            NULL AS hulmål, 
            NULL AS passepartoutFarve, 
            NULL AS antal, 
            NULL AS montering, 
            NULL AS billedetype, 
            NULL AS bemærkninger, 
            NULL AS ekspedient,
            bånd.båndID, 
            bånd.båndDates, 
            bånd.båndType,
            bånd.båndAntal,
            bånd.båndMedie,
            bånd.båndMedieKopi,
            bånd.båndNotes,
            bånd.båndBetalt,
            bånd.båndPris,
            bånd.ekspedient AS ekspedient
        FROM 
            bånd 
        INNER JOIN 
        bånd_kunder ON bånd.båndID = kunder.kundeID 
        WHERE 
            kunder.kundeID LIKE '%$search%' 
            OR bånd.båndDates LIKE '%$search%' 
            OR kunder.fornavn LIKE '%$search%'
            OR kunder.telefonnummer LIKE '%$search%'
            OR bånd.båndType LIKE '%$search%'
            OR bånd.båndAntal LIKE '%$search%'
            OR bånd.båndMedie LIKE '%$search%'
            OR bånd.båndMedieKopi LIKE '%$search%'
            OR bånd.båndNotes LIKE '%$search%'
            OR bånd.båndBetalt LIKE '%$search%'
            OR bånd.båndPris LIKE '%$search%'
            OR bånd.ekspedient LIKE '%$search%'
        ORDER BY rammeID DESC";

        // Udfør forespørgslen
        $result = mysqli_query($conn, $sql);
        $queryResult = mysqli_num_rows($result);
        
        // Check hvilken tabel søgningen kommer fra
        $isRamme = false;
        $isBånd = false;
        while ($row = mysqli_fetch_assoc($result)) {
            if (!empty($row["rammeID"])) {
                $isRamme = true;
            }
            if (!empty($row["båndID"])) {
                $isBånd = true;
            }
        }

        // Vis kolonner baseret på hvilken tabel søgningen kommer fra
        echo '<table> <tr>';
        if ($isRamme) {
            // Ramme ordre
            echo '
                <th> Ordre </th> 
                <th> Dato </th>
                <th> Fornavn </th> 
                <th> Telefon </th>
                <th> Rammeprofil </th>
                <th> Størrelse </th>
                <th> Glas </th>
                <th> Passepartout </th>
                <th> Hulmål </th>
                <th> PP Farve </th>
                <th> Antal </th>
                <th> Montering </th>
                <th> Billede </th>
                <th> Bemærkninger </th>
                <th> Ekspedient </th>
            ';
        } elseif ($isBånd) {
            // Bånd ordre
            echo '
                <th> Ordre </th> 
                <th> Dato </th>
                <th> Fornavn </th> 
                <th> Telefon </th>
                <th> Bånd Type </th>
                <th> Bånd Antal </th>
                <th> Medie Type </th>
                <th> Kopi </th>
                <th> Bemærkning </th>
                <th> Betalt </th>
                <th> Samlet pris </th>
                <th> Ekspedient </th>
            ';
        }
        echo '</tr>';

        // Vis data baseret på hvilken tabel søgningen kommer fra
        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            if (!empty($row["rammeID"])) {
                // Ramme ordre
                echo '
                    <td>' . $row["rammeID"] . '</td> 
                    <td>' . $row["dates"] . '</td> 
                    <td>' . $row["fornavn"] . '</td> 
                    <td>' . $row["telefonnummer"] . '</td> 
                    <td>' . $row["profil"] . '</td> 
                    <td>' . $row["størrelse"] . '</td> 
                    <td>' . $row["glastype"] . '</td> 
                    <td>' . $row["passepartout"] . '</td> 
                    <td>' . $row["hulmål"] . '</td> 
                    <td>' . $row["passepartoutFarve"] . '</td> 
                    <td>' . $row["antal"] . '</td> 
                    <td>' . $row["montering"] . '</td> 
                    <td>' . $row["billedetype"] . '</td> 
                    <td>' . $row["bemærkninger"] . '</td> 
                    <td>' . $row["ekspedient"] . '</td>
                ';
            } elseif (!empty($row["båndID"])) {
                // Bånd ordre
                echo '
                    <td>' . $row["båndID"] . '</td> 
                    <td>' . $row["båndDates"] . '</td> 
                    <td>' . $row["fornavn"] . '</td> 
                    <td>' . $row["telefonnummer"] . '</td> 
                    <td>' . $row["båndType"] . '</td> 
                    <td>' . $row["båndAntal"] . '</td> 
                    <td>' . $row["båndMedie"] . '</td> 
                    <td>' . $row["båndMedieKopi"] . '</td> 
                    <td>' . $row["båndNotes"] . '</td> 
                    <td>' . $row["båndBetalt"] . '</td> 
                    <td>' . $row["båndPris"] . '</td> 
                    <td>' . $row["ekspedient"] . '</td>
                ';
            }
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "Ingen resultater fundet.";
    }
}
    // Luk forbindelsen til databasen
    mysqli_close($conn);

?>
    </div> <!-- Lukker resultat -->
</div> <!--Lukker wrapper-->
</body>
</html>

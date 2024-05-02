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
    if (isset($_POST['submit-search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
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
            ramme.ekspedient,
            NULL AS båndID,
            NULL AS båndDates,
            NULL AS båndType,
            NULL AS båndAntal,
            NULL AS båndMedie,
            NULL AS båndMedieKopi,
            NULL AS båndNotes,
            NULL AS båndBetalt,
            NULL AS båndPris
        FROM 
            ramme 
        INNER JOIN 
            kunder ON ramme.rammeID = kunder.kundeID 
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
            bånd.båndPris
        FROM 
            bånd 
        INNER JOIN 
            kunder ON bånd.båndID = kunder.kundeID 
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
        ORDER BY rammeID DESC";


    $result = mysqli_query($conn, $sql);
    $queryResult = mysqli_num_rows($result);
    echo '<table> <tr>';
    if (!empty($row["rammeID"])) {
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
    } else {
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
        ';
    }
    echo '</tr>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        if (!empty($row["rammeID"])) {
            // Ramme ordre
            echo '
                <td>' . $row["rammeID"] . '</td> 
                <td>' . $row["dates"] . '</td> 
                <td>' . $row["fornavn"] . '</td> 
                <td>' . $row["telefonnummer"] . '</td> 
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
        } else {
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

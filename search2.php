<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    include 'connection.php'; // Inkluderer forbindelsesfilen til databasen

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
                ramme.ekspedient 
            FROM 
                ramme 
            INNER JOIN 
                kunder ON ramme.rammeID = kunder.kundeID 
            WHERE 
                kunder.kundeID LIKE '%$search' 
                OR ramme.dates LIKE '%$search' 
                OR kunder.fornavn LIKE '%$search'
                OR kunder.telefonnummer LIKE '%$search'
                OR ramme.profil LIKE '%$search'
                OR ramme.størrelse LIKE '%$search'
                OR ramme.glastype LIKE '%$search'
                OR ramme.passepartout LIKE '%$search'
                OR ramme.hulmål LIKE '%$search'
                OR ramme.passepartoutFarve LIKE '%$search'
                OR ramme.antal LIKE '%$search'
                OR ramme.montering LIKE '%$search'
                OR ramme.billedetype LIKE '%$search'
                OR ramme.bemærkninger LIKE '%$search'
                OR ramme.ekspedient LIKE '%$search'
            UNION
            SELECT 
                bånd.båndID, 
                bånd.båndDates, 
                kunder.fornavn, 
                kunder.telefonnummer, 
                '', 
                '', 
                '', 
                '', 
                '', 
                '', 
                bånd.båndAntal, 
                '', 
                bånd.båndMedie, 
                bånd.båndNotes, 
                '' 
            FROM 
                bånd 
            INNER JOIN 
                kunder ON bånd.båndID = kunder.kundeID 
            WHERE 
                kunder.kundeID LIKE '%$search' 
                OR bånd.båndDates LIKE '%$search' 
                OR kunder.fornavn LIKE '%$search'
                OR kunder.telefonnummer LIKE '%$search'
                OR bånd.båndType LIKE '%$search'
                OR bånd.båndAntal LIKE '%$search'
                OR bånd.båndMedie LIKE '%$search'
                OR bånd.båndNotes LIKE '%$search'
                OR bånd.båndBetalt LIKE '%$search'
                OR bånd.båndPris LIKE '%$search'
            ORDER BY rammeID DESC";

    $result = mysqli_query($conn, $sql);
    $queryResult = mysqli_num_rows($result);
    echo '<table> <tr>
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
    <th> Ekspedient </th></tr>
    ';

    if ($queryResult > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            if (!empty($row["rammeID"])) {
                echo '<td>' . $row["rammeID"] . '</td>
                <td>' . $row["dates"] . '</td>
                <td> ' . $row["fornavn"] . '</td>
                <td>' . $row["telefonnummer"] . '</td>
                <td> ' . $row["profil"] . '</td> 
                <td> ' . $row["størrelse"] . '</td> 
                <td> ' . $row["glastype"] . '</td> 
                <td> ' . $row["passepartout"] . '</td> 
                <td> ' . $row["hulmål"] . '</td> 
                <td> ' . $row["passepartoutFarve"] . '</td> 
                <td> ' . $row["antal"] . '</td> 
                <td> ' . $row["montering"] . '</td> 
                <td> ' . $row["billedetype"] . '</td> 
                <td> ' . $row["bemærkninger"] . '</td> 
                <td> ' . $row["ekspedient"] . '</td>';
            } else {
                echo '<td>' . $row["båndID"] . '</td>
                <td>' . $row["båndDates"] . '</td>
                <td> ' . $row["fornavn"] . '</td>
                <td>' . $row["telefonnummer"] . '</td>
                <td>N/A</td> 
                <td>N/A</td> 
                <td>N/A</td> 
                <td>N/A</td> 
                <td>N/A</td> 
                <td>N/A</td> 
                <td>' . $row["båndAntal"] . '</td> 
                <td>N/A</td> 
                <td>' . $row["båndMedie"] . '</td> 
                <td>' . $row["båndNotes"] . '</td> 
                <td>N/A</td>';
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
} 
?>

    </div> <!-- Lukker resultat -->
</div> <!--Lukker wrapper-->
</body>
</html>



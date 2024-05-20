<?php 
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    include 'connection.php';
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
    $sql = "SELECT ramme.rammeID, ramme.profil, ramme.dates, kunder.fornavn, kunder.telefonnummer, ramme.profil, ramme.størrelse, ramme.glastype, ramme.passepartout, ramme.hulmål, 
    ramme.passepartoutFarve, ramme.antal, ramme.montering, ramme.billedetype, ramme.bemærkninger, ramme.ekspedient
    FROM ramme
    INNER JOIN kunder
    ON ramme.rammeID = kunder.kundeID 

        WHERE kunder.kundeID LIKE '%$search' 
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
        ORDER BY ramme.ordreID DESC";

    $result = mysqli_query($conn, $sql);
    $queryResult = mysqli_num_rows($result);
    echo '<table> <tr">
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
    ?>
    <!-- Viser hvor mange resultater der er. -->
    <div class="resultat">
    <?php echo "Der er " . $queryResult . " resultater";?>
</div>
<?php
    if ($queryResult > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr> 
            <td>' . $row["ordreID"] . '</td>
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
            <td> ' . $row["ekspedient"] . '</td> 
            </tr>';
        }
        echo '</table>';
    } 
} }

mysqli_free_result($result);

// Lukker forbindelsen.
mysqli_close($conn);
?>
            </div> <!-- Lukker resultat -->
        </div> <!--Lukker wrapper-->
    </body>

</html>
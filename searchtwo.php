<?php 
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>DONNÉS || Søge resultat</title>
        <link href="./style/layout.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div class="søge-wrapper">
            <div class="søge-header">
                <h1 class="søgeoverskrift">Søge Resultat</h1>
            </div>
            <div class="søge-resultat">
            <?php
// Åbner forbindelse til database.
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "Donnes";

// Forbinder til database
$con = mysqli_connect($hostname, $username, $password, $dbname);
// Tjekker om der er forbindelse eller ej.
if (!$con) {
    die("Connection failed!" . mysqli_connect_error());
}

if (isset($_POST['submit-search'])) {
    $search = mysqli_real_escape_string($con, $_POST['search']);
    $sql = "SELECT rammer.ordreID, rammer.profil, rammer.dates, kunder.fornavn, kunder.telefonnummer, rammer.profil, rammer.størrelse, rammer.glastype, rammer.passepartout, rammer.hulmål, 
    rammer.passepartoutFarve, rammer.antal, rammer.montering, rammer.billedetype, rammer.bemærkninger, rammer.pris, rammer.betalt, rammer.bestilt, rammer.ekspedient
    FROM rammer
    INNER JOIN kunder
    ON rammer.ordreID = kunder.kundeID 

        WHERE kunder.kundeID LIKE '%$search' 
        OR rammer.dates LIKE '%$search' 
        OR kunder.fornavn LIKE '%$search'
        OR kunder.telefonnummer LIKE '%$search'
        OR rammer.profil LIKE '%$search'
        OR rammer.størrelse LIKE '%$search'
        OR rammer.glastype LIKE '%$search'
        OR rammer.passepartout LIKE '%$search'
        OR rammer.hulmål LIKE '%$search'
        OR rammer.passepartoutFarve LIKE '%$search'
        OR rammer.antal LIKE '%$search'
        OR rammer.montering LIKE '%$search'
        OR rammer.billedetype LIKE '%$search'
        OR rammer.bemærkninger LIKE '%$search'
        OR rammer.pris LIKE '%$search'
        OR rammer.betalt LIKE '%$search'
        OR rammer.bestilt LIKE '%$search'
        OR rammer.ekspedient LIKE '%$search'
        ORDER BY rammer.ordreID DESC";

    $result = mysqli_query($con, $sql);
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
    <th> Pris </th>
    <th> Betalt </th>
    <th> Bestilt </th>
    <th> Ekspedient </th></tr>
    ';
    ?>
    // Viser hvor mange resultater der er. 
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
            <td> ' . $row["pris"] . '</td> 
            <td> ' . $row["betalt"] . '</td> 
            <td> ' . $row["bestilt"] . '</td> 
            <td> ' . $row["ekspedient"] . '</td> 
            </tr>';
        }
        echo '</table>';
    } else {
        echo "Ingen resultat på søgning";
    }
} }

mysqli_free_result($result);

// Lukker forbindelsen.
mysqli_close($con);
?>
            </div> <!-- Lukker resultat -->
        </div> /*Lukker wrapper*/
    </body>

</html>
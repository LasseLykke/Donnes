<?php 
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>DONNÉS || UGELIG ORDRE</title>
        <link href="./style/layout.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div class="søge-wrapper">
            <div class="søge-header">
                <h1 class="søgeoverskrift">Ugelig ordre</h1>
                <a href="forside.php"><button class="backBtn">Tilbage</button></a>
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

// Henter den nuværende dag på ugen (0= søndag, 1 = mandag .. , 6 = lørdag)
$dayOfWeek = date("w");

// Udregner forskellen mellem nuværende dag og mandag
$daysUntilMonday = ($dayOfWeek == 0) ? 6 : ($dayOfWeek - 1);

// Udregner start og slut dato for ugen (mandag til søndag)
$startDate = date("Y-m-d", strtotime("today - $daysUntilMonday days"));
$endDate = date("Y-m-d", strtotime("$startDate + 6 days"));



    $sql = "SELECT ramme.ordreID, ramme.profil, ramme.dates, ramme.profil, ramme.størrelse, ramme.glastype, ramme.passepartout, ramme.hulmål, 
    ramme.passepartoutFarve, ramme.antal, ramme.montering, ramme.billedetype, ramme.bemærkninger, ramme.ekspedient
    FROM ramme 
    WHERE ramme.dates BETWEEN '$startDate' AND '$endDate'";

    $result = mysqli_query($con, $sql);
    $queryResult = mysqli_num_rows($result);

    echo '<table>
     <tr>
    <th> Ordre </th> 
    <th> Dato </th>
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
    </tr>
    ';
    ?>
    <!-- Viser hvor mange resultater der er. -->
    <div class="resultat">
    <?php echo "Der er " . $queryResult . " ordre";?>
</div>
<?php
    if ($queryResult > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr> 
            <td>' . $row["ordreID"] . '</td>
            <td>' . $row["dates"] . '</td>
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
} 

mysqli_free_result($result);

// Lukker forbindelsen.
mysqli_close($con);
?>
            </div> <!-- Lukker resultat -->
        </div> <!--Lukker wrapper-->
    </body>

</html>
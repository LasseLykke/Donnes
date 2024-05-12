<?php 

session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>DONNÉS || UGENTLIG ORDRE</title>
        <link href="./style/layout.css" type="text/css" rel="stylesheet">
        <link rel="shortcut icon" href="fav.ico" type="image/x-icon"/>
        <meta http-equiv="refresh" content="900;url=logout.php" />
    </head>
    <body>
        <div class="søge-wrapper">
            <div class="søge-header">
                <h1 class="søgeoverskrift">Alle ramme ordre</h1><br>
                <a href="forside.php"><button class="backBtn">Tilbage</button></a>
            </div>

            <div class="søge-resultat">
            <?php



    $sql = "SELECT ramme.rammeID, ramme.profil, ramme.dates, ramme.profil, ramme.størrelse, ramme.glastype, ramme.passepartout, ramme.hulmål, 
    ramme.passepartoutFarve, ramme.antal, ramme.montering, ramme.billedetype, ramme.bemærkninger, ramme.ekspedient
    FROM ramme 
    WHERE ramme.dates";

    $result = mysqli_query($conn, $sql);
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
            <td>' . $row["rammeID"] . '</td>
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
 

mysqli_free_result($result);

// Lukker forbindelsen.
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
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

            <form method="POST" action="output_rammer.php">
                <input type="text" name="søgeord" placeholder="Søg efter ordre">
                <button type="submit" name="søg">Søg</button>
            </form>
            <?php

    // Standard SQL-forespørgsel for at hente alle ordre
    $sql = "SELECT * FROM ramme";
    $result = mysqli_query($conn, $sql);
    $queryResult = mysqli_num_rows($result);

    // Check if search form is submitted
    if(isset($_POST['søg'])) {
        $search = mysqli_real_escape_string($conn, $_POST['søgeord']);
        // Modify the SQL query to filter results based on search criteria
        $sql = "SELECT * FROM ramme WHERE 
                profil LIKE '%$search%' OR 
                størrelse LIKE '%$search%' OR 
                glastype LIKE '%$search%' OR 
                passepartout LIKE '%$search%' OR 
                bemærkninger LIKE '%$search%' OR 
                ekspedient LIKE '%$search%' DESC";
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
                <th>Rammeprofil</th>
                <th>Størrelse</th>
                <th>Glas</th>
                <th>Passepartout</th>
                <th>Hulmål</th>
                <th>PP Farve</th>
                <th>Antal</th>
                <th>Montering</th>
                <th>Billede</th>
                <th>Bemærkninger</th>
                <th>Ekspedient</th>
            </tr>';

    // Vis hver ordre som en række i tabellen
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr> 
                <td>' . $row["rammeID"] . '</td>
                <td>' . $row["dates"] . '</td>
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
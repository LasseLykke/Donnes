<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>DONNÉS || ALLE RAMME ORDRE</title>
        <link href="./style/layout.css" type="text/css" rel="stylesheet">
        <link rel="shortcut icon" href="fav.ico" type="image/x-icon" />
        <meta http-equiv="refresh" content="900;url=logout.php" />
    </head>

    <body>
        <nav class="navbar">
            <a href="forside.php">
                <img src="./img/hflogo.png" class="logo" alt="logo"></a>
            <h3>Hej
                <?php echo $_SESSION['name']; ?> 👋🏻
            </h3>
            <a href="logout.php"><button class="signOut" alt="LogOut"></button>
            </a>
        </nav>

        <div class="wrapperOversigt">
            <div class="søge-wrapper">
                <!-- Header med resultat og søgefunktion -->
                <div class="søge-header">
                    <!-- Query result til venstre -->
                    <div class="resultat">

                    </div>

                    <!-- Søgefunktion til højre -->
                    <form class="søgeform" method="POST" action="output_rammer.php">
                        <div class="input-wrapper">
                            <input type="text" name="søgeord" placeholder="Søg efter ordre">
                            <button type="submit" name="søg">
                                <img src="./img/search.svg" class="search" alt="Søg">
                            </button>
                        </div>
                    </form>

                </div>
                <?php

                // Standard SQL-forespørgsel for at hente alle ordre med DESC rækkefølge
                $sql = "SELECT ramme.*, kunde.navn AS kunde_navn, kunde.telefon AS kunde_telefon, ordre.ordreDate
                        FROM ramme
                        INNER JOIN ordre ON ramme.ordreID = ordre.ordreID
                        INNER JOIN kunde ON ordre.kundeID = kunde.kundeID
                        ORDER BY ramme.rammeID DESC"; // Sortér standard efter rammeID DESC
            
                // Check if search form is submitted
                if (isset($_POST['søg'])) {
                    $search = mysqli_real_escape_string($conn, $_POST['søgeord']);
                    // Modify the SQL query to filter results based on search criteria
                    $sql = "SELECT ramme.*, kunde.navn AS kunde_navn, kunde.telefon AS kunde_telefon, ordre.ordreDate
                            FROM ramme
                            INNER JOIN ordre ON ramme.ordreID = ordre.ordreID
                            INNER JOIN kunde ON ordre.kundeID = kunde.kundeID
                            WHERE kunde.navn LIKE '%$search%' 
                            OR ramme.ordreID LIKE '%$search%' 
                            OR kunde.telefon LIKE '%$search%' 
                            OR ramme.profil LIKE '%$search%' 
                            OR ramme.størrelse LIKE '%$search%' 
                            OR ramme.glastype LIKE '%$search%' 
                            OR ramme.hulmål LIKE '%$search%' 
                            OR ramme.passepartoutFarve LIKE '%$search%' 
                            OR ramme.antal LIKE '%$search%' 
                            OR ramme.montering LIKE '%$search%' 
                            OR ramme.billedtype LIKE '%$search%' 
                            OR ramme.bemærkninger LIKE '%$search%' 
                            OR ramme.ekspedient LIKE '%$search%' 
                            ORDER BY ramme.rammeID DESC"; // Sortér stadig efter rammeID DESC
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
                    <th>Profil</th>
                    <th>Størrelse</th>
                    <th>Antal</th>
                    <th>Bemærkning</th>
                    <th>Ekspedient</th>
                    <th>Vis ordre</th>
                </tr>';

                // Vis hver ordre som en række i tabellen
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                            <td>' . $row["ordreID"] . '</td>
                            <td>' . $row["ordreDate"] . '</td>
                            <td>' . $row["kunde_navn"] . '</td>
                            <td>' . $row["kunde_telefon"] . '</td>
                            <td>' . $row["profil"] . '</td>
                            <td>' . $row["størrelse"] . '</td>
                            <td>' . $row["antal"] . '</td>
                            <td>' . $row["bemærkninger"] . '</td>
                            <td>' . $row["ekspedient"] . '</td>
                            <td>
                                <form method="POST" action="vis_ordredetaljer.php" target="_blank">
                                    <input type="hidden" name="ordreID" value="' . $row["ordreID"] . '">
                                    <button type="submit" class="btn-åbn">Åbn</button>
                                </form>
                            </td>
                        </tr>';
                }

                echo '</table>';
                echo '</div>'; // Lukker søge-resultat
                echo '</div>'; // Lukker søge-wrapper
            
                mysqli_free_result($result);
                mysqli_close($conn);
                ?>
            </div> <!-- Lukker resultat -->
        </div> <!-- Lukker wrapper -->
        </div>

    </body>

    </html>
    <?php
}
?>
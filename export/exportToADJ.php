<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {
    include '../header.php';
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>DONNÉS || ALLE RAMME ORDRE</title>
        <link rel="shortcut icon" href="fav.ico" type="image/x-icon" />
        <meta http-equiv="refresh" content="900;url=logout.php" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <nav class="navbar">
            <a href="../forside.php">
                <img src="../img/hflogo.png" class="logo" alt="logo"></a>
            <h3>Hej <?php echo $_SESSION['name']; ?> 👋🏻</h3>
            <a href="../logout.php"><button class="signOut" alt="LogOut"></button></a>
        </nav>

        <div class="wrapperOversigt">
            <!-- Filtreringsformularen -->
            <div class="filter-wrapper">
                <form class="dato-filter" method="POST" action="">
                    <div class="input-row">
                        <label for="startDato">Fra dato:</label>
                        <input type="date" id="startDato" name="startDato" required>
                        <label for="slutDato">Til dato:</label>
                        <input type="date" id="slutDato" name="slutDato" required>
                    </div>
                    <button type="submit" name="filtrer" class="mainBtn">OK</button>
                </form>
            </div>

            <?php
            // SQL-forespørgsel og visning af resultater
            $sql = "SELECT ramme.*, kunde.navn AS kunde_navn, kunde.telefon AS kunde_telefon, 
    DATE_FORMAT(ordre.ordreDate, '%d/%m/%y') AS ordreDateFormatted
FROM ramme
INNER JOIN ordre ON ramme.ordreID = ordre.ordreID
INNER JOIN kunde ON ordre.kundeID = kunde.kundeID
ORDER BY ramme.rammeID DESC";


            if (isset($_POST['filtrer'])) {
                $startDato = mysqli_real_escape_string($conn, $_POST['startDato']);
                $slutDato = mysqli_real_escape_string($conn, $_POST['slutDato']);
                $sql = "SELECT ramme.*, kunde.navn AS kunde_navn, kunde.telefon AS kunde_telefon, 
                DATE_FORMAT(ordre.ordreDate, '%d/%m/%y') AS ordreDateFormatted
            FROM ramme
            INNER JOIN ordre ON ramme.ordreID = ordre.ordreID
            INNER JOIN kunde ON ordre.kundeID = kunde.kundeID
            WHERE ordre.ordreDate BETWEEN '$startDato' AND '$slutDato'
            ORDER BY ramme.rammeID DESC";
            }

            $result = mysqli_query($conn, $sql);
            $queryResult = mysqli_num_rows($result);

            echo '<div class="resultat">';
            echo "Der er " . $queryResult . " ordre";
            echo '</div>';

            echo '<div class="søge-resultat">';
            echo '<table>
    <tr>
        <th>Ordre</th>
        <th>Dato</th>
        <th>Profil</th>
        <th>Størrelse</th>
        <th>Glas</th>
        <th>Antal</th>
        <th>Hulmål</th>
        <th>PP Farve</th>
        <th>Bemærkning</th>
    </tr>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                <td>' . $row["ordreID"] . '</td>
                <td>' . $row["ordreDateFormatted"] . '</td>
                <td>' . $row["profil"] . '</td>
                <td>' . $row["størrelse"] . '</td>
                <td>' . $row["glastype"] . '</td>
                <td>' . $row["antal"] . '</td>
                <td>' . $row["hulmål"] . '</td>
                <td>' . $row["passepartoutFarve"] . '</td>
                <td>' . $row["bemærkninger"] . '</td>
            </tr>';
            }

            echo '</table>';
            echo '</div>';

            mysqli_free_result($result);
            mysqli_close($conn);
            ?>

            <!-- Eksportformularen -->
            <form method="POST" action="export_filtreret.php" target="_blank">
    <input type="hidden" name="startDato" value="<?php echo isset($startDato) ? $startDato : ''; ?>">
    <input type="hidden" name="slutDato" value="<?php echo isset($slutDato) ? $slutDato : ''; ?>">
    <button type="submit" name="export">Eksporter resultater</button>
</form>

            <?PHP
            echo '</div>';
            ?>
        </div>
    </body>

    <script>
        document.querySelector('form').onsubmit = function() {
            const startDato = document.getElementById('startDato').value;
            const slutDato = document.getElementById('slutDato').value;
            if (!startDato || !slutDato) {
                alert('Begge datoer skal udfyldes!');
                return false;
            }
        };
    </script>

    </html>
<?php
}
?>
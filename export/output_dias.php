<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include '../header.php';
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>DONNÉS || ALLE DIAS ORDRE</title>
        <link rel="shortcut icon" href="fav.ico" type="image/x-icon" />
        <meta http-equiv="refresh" content="900;url=logout.php" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <nav class="navbar">
            <a href="../forside.php">
                <img src="../img/hflogo.png" class="logo" alt="logo"></a>
            <h3>Hej
                <?php echo $_SESSION['name']; ?> 👋🏻
            </h3>
            <a href="../logout.php"><button class="signOut" alt="LogOut"></button>
            </a>
        </nav>

        <div class="wrapperOversigt">
            <div class="søge-wrapper">
                <div class="søge-header">
                    <div class="resultat"></div>

                    <form class="søgeform" method="POST" action="output_dias.php">
                        <div class="input-wrapper">
                            <input type="text" name="søgeord" placeholder="Søg efter ordre">
                            <button type="submit" name="søg">
                                <img src="../img/search.svg" class="search" alt="Søg">
                            </button>
                        </div>
                    </form>
                </div>

                <?php
                $sql = "SELECT dias.*, kunde.navn AS kunde_navn, kunde.telefon AS kunde_telefon, ordre.ordreDate
                        FROM dias
                        INNER JOIN ordre ON dias.ordreID = ordre.ordreID
                        INNER JOIN kunde ON ordre.kundeID = kunde.kundeID
                        ORDER BY dias.diasID DESC";

                if (isset($_POST['søg'])) {
                    $search = mysqli_real_escape_string($conn, $_POST['søgeord']);
                    $sql = "SELECT dias.*, kunde.navn AS kunde_navn, kunde.telefon AS kunde_telefon, ordre.ordreDate
                            FROM dias
                            INNER JOIN ordre ON dias.ordreID = ordre.ordreID
                            INNER JOIN kunde ON ordre.kundeID = kunde.kundeID
                            WHERE kunde.navn LIKE '%$search%' 
                            OR dias.ordreID LIKE '%$search%' 
                            OR kunde.telefon LIKE '%$search%' 
                            OR dias.diasType LIKE '%$search%' 
                            OR dias.diasAntal LIKE '%$search%' 
                            OR dias.medieType LIKE '%$search%' 
                            OR dias.afpudsning LIKE '%$search%' 
                            OR dias.bemærkninger LIKE '%$search%' 
                            OR dias.pris LIKE '%$search%' 
                            OR dias.ekspedient LIKE '%$search%' 
                            ORDER BY dias.diasID DESC";
                }

                $result = mysqli_query($conn, $sql);
                $queryResult = mysqli_num_rows($result);

                if (isset($_POST['sletOrdre'])) {
                    $ordreID = intval($_POST['ordreID']);
                    $sletSQL = "DELETE FROM ordre WHERE ordreID = ?";
                    
                    if ($stmt = mysqli_prepare($conn, $sletSQL)) {
                        mysqli_stmt_bind_param($stmt, "i", $ordreID);
                        if (mysqli_stmt_execute($stmt)) {
                            echo '<p class="success">Ordre med ID ' . $ordreID . ' blev slettet.</p>';
                        } else {
                            echo '<p class="error">Der opstod en fejl under sletning af ordren.</p>';
                        }
                        mysqli_stmt_close($stmt);
                    } else {
                        echo '<p class="error">Kunne ikke forberede forespørgslen.</p>';
                    }
                }

                echo '<div class="resultat">';
                echo "Der er " . $queryResult . " ordre";
                echo '</div>';

                echo '<div class="søge-resultat">';
                echo '<table>
                <tr>
                    <th>Ordre</th>
                    <th>Dato</th>
                    <th>Navn</th>
                    <th>Telefon</th>
                    <th>Dias Type</th>
                    <th>Antal</th>
                    <th>Medietype</th>
                    <th>Bemærkning</th>
                    <th>Ekspedient</th>
                    <th>Vis ordre</th>
                    <th>Slet ordre</th>
                </tr>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                            <td>' . $row["ordreID"] . '</td>
                            <td>' . $row["ordreDate"] . '</td>
                            <td>' . $row["kunde_navn"] . '</td>
                            <td>' . $row["kunde_telefon"] . '</td>
                            <td>' . $row["diasType"] . '</td>
                            <td>' . $row["diasAntal"] . '</td>
                            <td>' . $row["medieType"] . '</td>
                            <td>' . $row["bemærkninger"] . '</td>
                            <td>' . $row["ekspedient"] . '</td>
                            <td>
                                <form method="POST" action="vis_ordredetaljerDias.php" target="_blank">
                                    <input type="hidden" name="ordreID" value="' . $row["ordreID"] . '">
                                    <button type="submit" class="btn-åbn">Åbn</button>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="btn-slet" onclick="bekræftSletning(' . $row['ordreID'] . ')">Slet</button>
                            </td>
                        </tr>';
                }

                echo '</table>';
                echo '</div>';
                echo '</div>';
            
                mysqli_free_result($result);
                mysqli_close($conn);
                ?>
            </div>
        </div>

        <script>
            function bekræftSletning(ordreID) {
                Swal.fire({
                    title: 'Er du sikker?',
                    text: "Du kan ikke fortryde denne handling!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ja, slet ordren!',
                    cancelButtonText: 'Annuller'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '';
                        form.innerHTML = `
                            <input type="hidden" name="ordreID" value="${ordreID}">
                            <input type="hidden" name="sletOrdre" value="1">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }
        </script>

    </body>
    </html>
    <?php
}
?>

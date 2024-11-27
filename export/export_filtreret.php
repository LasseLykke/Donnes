<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Udskriv automatisk</title>

</head>

<body>
    <?php
    include '../connection.php';
    include '../header.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $startDato = $_POST['startDato'];
        $slutDato = $_POST['slutDato'];

        // Opret DateTime objekter fra de indsendte datoer
        $startDatoObj = DateTime::createFromFormat('Y-m-d', $startDato);
        $slutDatoObj = DateTime::createFromFormat('Y-m-d', $slutDato);

        // Formater datoerne som DD/MM-YY
        $startDatoFormatted = $startDatoObj->format('d/m/Y');
        $slutDatoFormatted = $slutDatoObj->format('d/m/Y');

        $sql = "SELECT ramme.*, kunde.navn AS kunde_navn, kunde.telefon AS kunde_telefon, 
            DATE_FORMAT(ordre.ordreDate, '%d/%m/%Y') AS ordreDateFormatted
        FROM ramme
        INNER JOIN ordre ON ramme.ordreID = ordre.ordreID
        INNER JOIN kunde ON ordre.kundeID = kunde.kundeID
        WHERE ordre.ordreDate BETWEEN '$startDato' AND '$slutDato'";

        $result = mysqli_query($conn, $sql);
    ?>
        <h2 class="ordreSection">Ordre fra <?php echo $startDatoFormatted; ?> til <?php echo $slutDatoFormatted; ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Ordre ID</th>
                    <th>Dato</th>
                    <th>Profil</th>
                    <th>Størrelse</th>
                    <th>Glas</th>
                    <th>Antal</th>
                    <th>Hulmål</th>
                    <th>PP Farve</th>
                    <th>Bemærkning</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['ordreID']; ?></td>
                        <td><?php echo $row['ordreDateFormatted']; ?></td>
                        <td><?php echo $row['profil']; ?></td>
                        <td><?php echo $row['størrelse']; ?></td>
                        <td><?php echo $row['glastype']; ?></td>
                        <td><?php echo $row['hulmål']; ?></td>
                        <td><?php echo $row['passepartoutFarve']; ?></td>
                        <td><?php echo $row['antal']; ?></td>
                        <td><?php echo $row['bemærkninger']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <script>
            // Trigger print dialog automatically
            window.onload = function() {
                window.print();
            };
        </script>

    <?php } else { ?>
        <form method="POST" action="">
            <label for="startDato">Startdato:</label>
            <input type="date" id="startDato" name="startDato" required>
            <label for="slutDato">Slutdato:</label>
            <input type="date" id="slutDato" name="slutDato" required>
            <button type="submit">Generer og udskriv</button>
        </form>
    <?php } ?>
</body>

</html>
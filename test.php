<html>
    <body>
        <table>
            <thead>
            <tr>
               <!-- <th>Ordre ID</th>-->
                <th>Data</th>
                <th>Fornavn</th>
                <th>Telefonnummer</th>
                <th>Profil</th>
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
                <th> Ekspedient </th>
            </tr>
            </thead>
            <tbody>

            <?php 
            // Åbner forbindelse til database.
            $hostname = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Donnes";

            // Forbinder til database
            $con = mysqli_connect($hostname, $username, $password, $dbname);

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

            

            if ($result->num_rows > 0) {
                while ($row = $result-> fetch_assoc()) {
                    echo '<tr> 
                    <th>Ordre ID</th>
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
            }
            else {
                echo "ingen resultat";
            } }
            $con->close();


            ?>
            </tbody>
        </table>


        <script>
    // JavaScript to remove rows with no data
    window.addEventListener('DOMContentLoaded', function() {
    const tbody = document.querySelector('tbody');
    const dataRows = tbody.querySelectorAll('.data-row');

    dataRows.forEach((dataRow, index) => {
        const headers = document.querySelectorAll('thead th');
        if (dataRow.textContent.trim() === "") {
            headers[index].style.display = 'none';
        }
    });
});



    
</script>
</body>
</html>
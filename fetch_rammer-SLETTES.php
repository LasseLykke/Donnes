<?php
    // Henter database
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Donnes";

    //Forbinder til database
    $con = mysqli_connect($hostname, $username, $password, $dbname);
    //Tjekker om der er forbindelse.
    if(!$con)
    {
        die("Connection failed!" . mysqli_connect_error());
    }
    else 
    {
        echo "Forbundet! <br>";
    }

    //Outputter Hele 'Ramme table" i en.
    $sql = "SELECT  id, dates, names, telefon, rammeprofil, rammestørrelse, Glastype, Passepartout, Hulmål, passepartoutFarve, Antal, Montering, Billedetype, Bemærkninger, Pris, Betalt, Bestilt, Ekspedient FROM rammer ORDER BY id DESC";
    //fire query
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0) // Dette er hvad tabellen outputter
    {
       echo '<table> <tr>
        <th> Id </th> 
       <th> Dato </th>
        <th> Navn </th> 
        <th> Telefon </th>
        <th> Rammeprofil </th>
        <th> Rammestørrelse </th>
        <th> Glastype </th>
        <th> Passepartout </th>
        <th> Hulmål </th>
        <th> Passepartout Profil </th>
        <th> Antal </th>
        <th> Montering </th>
        <th> Billedetype </th>
        <th> Bemærkninger </th>
        <th> Pris </th>
        <th> Betalt </th>
        <th> Bestilt </th>
        <th> Ekspedient </th> </tr></div>';
       while($row = mysqli_fetch_assoc($result)){
         // Outputter SQL data til HTML tableformat
         echo '<tr > <td>' . $row["id"] . '</td>
           <td>' . $row["dates"] . '</td>
           <td> ' . $row["names"] . '</td>
           <td>' . $row["telefon"] . '</td>
           <td> ' . $row["rammeprofil"] . '</td>
           <td> ' . $row["rammestørrelse"] . '</td>
           <td> ' . $row["Glastype"] . '</td>
           <td> ' . $row["Passepartout"] . '</td>
           <td> ' . $row["Hulmål"] . '</td>
           <td> ' . $row["passepartoutFarve"] . '</td>
           <td> ' . $row["Antal"] . '</td>
           <td> ' . $row["Montering"] . '</td>
           <td> ' . $row["Billedetype"] . '</td>
           <td> ' . $row["Bemærkninger"] . '</td>
           <td> ' . $row["Pris"] . '</td>
           <td> ' . $row["Betalt"] . '</td>
           <td> ' . $row["Bestilt"] . '</td>
           <td> ' . $row["Ekspedient"] . '</td> </tr>';
       } 
       echo '</table>';
    } 
    else
    {
        echo "0 results";
    } 
    // Lukker forbindelsen.
    mysqli_close($con);

?>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Records</title>
    <style>
        table{
            width: 90wv;
            margin: auto;
            font-family: Arial, Helvetica, sans-serif;
        }
        table, tr, th, td{
            border: 1px solid #d4d4d4;
            border-collapse: collapse;
            padding: 12px;
        }
        th, td{
            text-align: left;
            vertical-align: top;
        }
        tr:nth-child(even){
            background-color: #e7e9eb;
        }

        .retur_btn {
            background-color: #d67D19;
            padding: 20px 30px;
            margin-bottom: 10px;
            margin-right: 10px;
            border: 1px solid black;
            text-transform: uppercase;
        }
    </style>
<body>

    <!-- SEARCH FORM -->
    <form action="search.php" method="POST">
        <input type="text" name="search" placeholder="Søg her">
        <button type="submit" name="submit-search">Søgefelt</button>
    </form>



    <a href="forside.php">
        <button class="retur_btn">Retur</button>
    </a>
     
    <div class="søge-container">
<?php
    // Henter database
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "DonnesDB";

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

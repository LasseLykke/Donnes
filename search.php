<h1>Søge resultat</h1>

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

<a href="forside.php">
        <button class="retur_btn">Retur</button>
    </a>
<div class="søge-container">

    <?php
    //Åbner forbindelse til database.
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "DonnesDB";

    //Forbinder til database
    $con = mysqli_connect($hostname, $username, $password, $dbname);
    //Tjekker om der er forbindelse eller ej.
    if(!$con)
    {
        die("Connection failed!" . mysqli_connect_error());
    }


        if (isset($_POST['submit-search'])) {
            $search = mysqli_real_escape_string($con, $_POST['search']);
            $sql = "SELECT * FROM rammer WHERE id LIKE '%$search%' 
            OR dates LIKE '%$search%' 
            OR names LIKE '%$search%' 
            OR telefon LIKE '%$search%' 
            OR rammeprofil LIKE '%$search%' 
            OR rammestørrelse LIKE '%$search%' 
            OR Glastype LIKE '%$search%' 
            OR Hulmål LIKE '%$search%' 
            OR Bemærkninger LIKE '%$search%' 
            OR pris LIKE '%$search%' 
            OR Ekspedient LIKE '%$search%' 
            ORDER BY id DESC";
            $result = mysqli_query($con, $sql);
            $queryResult = mysqli_num_rows($result);

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

        echo "Der er ".$queryResult." resultater";

            if ($queryResult > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
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

            } else {
                echo "Ingen resultat på søgning";
            }
        }
        // Lukker forbindelsen.
        mysqli_close($con);
    ?>
</div>
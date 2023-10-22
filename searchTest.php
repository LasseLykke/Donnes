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
    $dbname = "Donnes";

    //Forbinder til database
    $con = mysqli_connect($hostname, $username, $password, $dbname);
    //Tjekker om der er forbindelse eller ej.
    if(!$con)
    {
        die("Connection failed!" . mysqli_connect_error());
    }


        if (isset($_POST['submit-search'])) {
            $search = mysqli_real_escape_string($con, $_POST['search']);
            $sql = "SELECT * FROM rammer JOIN kundeOrdre ON rammer.co WHERE id LIKE '%$search%' 
            OR dates LIKE '%$search%' 
            OR names LIKE '%$search%' 
            OR telefon LIKE '%$search%'  
            ORDER BY id DESC";
            $result = mysqli_query($con, $sql);
            $queryResult = mysqli_num_rows($result);

            echo '<table> <tr>
        <th> Ordre </th> 
       <th> Dato </th>
        <th> Navn </th> 
        <th> Telefon </th>';

        echo "Der er ".$queryResult." resultater";

            if ($queryResult > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr > <td>' . $row["id"] . '</td>
           <td>' . $row["dates"] . '</td>
           <td> ' . $row["names"] . '</td>
           <td>' . $row["telefon"] . '</td>';
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
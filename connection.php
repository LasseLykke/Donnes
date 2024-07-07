<!-- REMEMBER TO INPUT OWN CREDS -->
<?php

$sname = "localhost";
$uname = "root";
$password = "root";

$db_name = "Donnes";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$mysqli = new mysqli("localhost", "root", "root", "Donnes");

if (!$conn) {
    echo "Connection failed!" . mysqli_connect_error();
}

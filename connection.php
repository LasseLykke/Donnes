<?php

$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "Donnes";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$mysqli = new mysqli("localhost", "root", "", "Donnes");

if (!$conn) {
    echo "Connection failed!" . mysqli_connect_error();
}
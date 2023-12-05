<?php

$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "Donnes";

$con = mysqli_connect($sname, $uname, $password, $db_name);

if (!$con) {
    die( "Connection failed!" . mysqli_connect_error());
}
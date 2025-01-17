<?php
include 'connection.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <link href="../style/base.css" type="text/css" rel="stylesheet">
    <link href="../style/components.css" type="text/css" rel="stylesheet">
    <link href="../style/layout.css" type="text/css" rel="stylesheet">
    <link href="../style/typography.css" type="text/css" rel="stylesheet">
   
   
    <meta name="keywords" content="internal tooling for ordermanagement system." />
    <meta name="description" content="Internal tooling for ordremanagement system and database" />
    <meta name="author" content="Lasse Lykke @ Lasselykke.com" />
    
    
    <!-- LOGUD TIMER 15min -->
    <meta http-equiv="refresh" content="900;url=../logout.php" />
</head>

<?php


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Logout script
    session_unset();
    session_destroy();
    header('Location: /index.php');
    exit();
}
?>
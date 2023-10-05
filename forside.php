<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        
        <!--<title>DONNÉS</title>
        <link href="main.css" type="text/css" rel="stylesheet"> -->
    </head>

    <body>
        <h1>Velkommen,
            <?php
            echo $_SESSION['name'];
            ?>
        </h1>
        <a href="rammeOrdre.php">
        <button>Ramme bestilling</button>
    </a>
    <br>

    <a href="rammer_last_data.php">
        <button>Hent rammeordre</button>
    </a>
    <br>
        <a href="logout.php">Logout</a>



    </body>

    </html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>
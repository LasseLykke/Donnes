<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>
    <!DOCTYPE html>
    <html>

    <head>

    </head>

    <body>
        <h1>Velkommen,
            <?php
            /* Trækker login bruger ind*/
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
/* Hvis ikke looget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>
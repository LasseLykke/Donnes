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

    <div class="maincontainer">
        <div class="header">
            <h1>Hej 
            <?php
            /* Trækker login bruger ind*/
            echo $_SESSION['name'];
            ?> 👋🏻</h1>
        
        <br>
        <form action="search.php" method="POST">
        <input type="text" name="search" placeholder="Søg her">
        <button type="submit" name="submit-search">Søgefelt</button>
    </form>
        </div>
        <div class="main">
        <h2>Formular</h2>
       
        <a href="rammeOrdre.php">
        <button>Ramme bestilling</button>
    </a>
    <a href="rammeOrdre.php">
        <button>Ordre</button>
    </a>
    <a href="rammeOrdre.php">
        <button>Bånd</button>
    </a>
    <a href="rammeOrdre.php">
        <button>Reperationer</button>
    </a>
        </div>
    </div>

    </body>

    </html>

<?php
/* Hvis ikke looget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>
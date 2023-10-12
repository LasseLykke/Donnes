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
        <nav class="nav">
            <a href="logout.php"><button class="signOut" alt="LogOut"></button>
        </a>
        </nav>
        <div class="header">
            <h1>Hej 
                <?php
                /* Trækker login bruger ind*/
                echo $_SESSION['name'];
                ?> 👋🏻</h1>
        
        <br>
        
        <form action="search.php" method="POST">
        <input type="text" name="search" placeholder="Hvad vil du søge efter?">
        <button class="submitSearch" type="submit" name="submit-search">Søg</button>
         </form>
        </div>


        <div class="main">
            <div class="mainContent">
         <h2>Formular</h2>
        <a href="rammeOrdre.php">
        <button>ADJ rammebestilling</button>
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
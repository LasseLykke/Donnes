<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>
    <!DOCTYPE html>
    <html>

    <head>
    <title>DONNÉS || FORSIDE</title>
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
        
        <form action="test.php" method="POST">
        <input type="text" name="search" placeholder="Hvad vil du søge efter?">
        <button class="submitSearch" type="submit" name="submit-search">Søg</button>
         </form>
        </div>


        <div class="main">
            <div class="mainContent">
                <h2>Bestillingsformular</h2><br>
                    <a href="rammeOrdre.php">
                        <button>ADJ rammebestilling</button>
                    </a>
                    <a href="kundeOrdre.php">
                        <button>Kunde ordre</button>
                    </a>
                    <a href="rammeOrdre.php">
                        <button>Dias</button>
                    </a>
                    <a href="test.php">
                        <button>Smalfilm</button>
                    </a>
                    <a href="test.php">
                        <button>Reperationer</button>
                    </a>

            </div>
        </div>

    </body>

    </html>

<?php
/* Hvis ikke logget ind bliver man sendt tilbage til login skærm */
} else {
    header("Location: index.php");
    exit();
}
?>
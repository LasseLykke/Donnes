<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>
    <!DOCTYPE html>
    <html>

    <head>
    <title>DONNÉS || FORSIDE</title>
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon"/>
    <meta http-equiv="refresh" content="900;url=logout.php" />
    </head>

    <body>
        <nav class="nav">
            <a href="logout.php"><button class="signOut" alt="LogOut"></button>
        </a>
        </nav>
        <!-- Velkommen div -->
        <div class="header">
            <h1>Hej 
                <?php
                /* Trækker login bruger ind*/
                echo $_SESSION['name'];
                ?> 👋🏻</h1>
        
        </div>


        <div class="main">
            <div class="mainContent">
                <h2>Bestilling:</h2><br>
                    <a href="ordre_rammer.php">
                        <button>ADJ rammebestilling</button>
                    </a>
                    <a href="ordre_bånd.php">
                        <button>Bånd</button>
                    </a>
                    <a href="ordre_dias.php">
                        <button>Dias</button>
                    </a>
                    <a href="ordre_smalfilm.php">
                        <button>Smalfilm</button>
                    </a>
                    <a href="ordre_rep.php">
                        <button>Reparationer</button>
                    </a>

            </div>

            <div class="secContent">
                <h2>Ordre:</h2><br>
                    <a href="output_rammer.php">
                        <button>Ramme ordre</button>
                    </a>

                    <a href="output_bånd.php">
                        <button>Bånd ordre</button>
                    </a>
                </div>

                <div class="secContent">
                    <h2>Export:</h2><br>
                    <a href="export_rammer.php">
                        <button>Rammer ugelig</button>
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
<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    include 'header.php';
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>DONNÉS || FORSIDE</title>
        <link rel="shortcut icon" href="fav.ico" type="image/x-icon" />
    </head>

    <body>
        <nav class="navbar">
            <img src="./img/hflogo.png" class="logo" alt="logo">
            <h3>Hej
                <?php
                /* Trækker login bruger ind*/
                echo $_SESSION['name'];
                ?> 👋🏻
            </h3>
            <a href="logout.php"><button class="signOut" alt="LogOut"></button>
            </a>
        </nav>


        <div class="wrapper">
            <!-- GRAF div -->
            <div class="header">

                <p>Indsæt graf her</p>
            </div>

            <div class="mainContent">
                <h2>Bestilling:</h2><br>
                <a href="importRamme.php">
                    <button class="mainBtn">ADJ ramme</button>
                </a>
                <a href="ordre_bånd.php">
                    <button class="mainBtn">Bånd</button>
                </a>
                <a href="ordre_dias.php">
                    <button class="mainBtn">Dias</button>
                </a>
                <a href="ordre_smalfilm.php">
                    <button class="mainBtn">Smalfilm</button>
                </a>
                <a href="ordre_rep.php">
                    <button class="mainBtn">Reparationer</button>
                </a>

            </div>

            <div class="secContent">
                <h2>Ordre:</h2><br>
                <a href="output_rammer.php">
                    <button class="mainBtn">Ramme ordre</button>
                </a>

                <a href="output_bånd.php">
                    <button class="mainBtn">Bånd ordre</button>
                </a>
            </div>

            <div class="secContent">
                <h2>Export:</h2><br>
                <a href="export_rammer.php">
                    <button class="mainBtn">Rammer ugelig</button>
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
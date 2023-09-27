<?php
session_start();

if (isset($_SESSION['users_id']) && isset($_SESSION['user_name'])) {

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>HOME</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body>
        <h1>Welcome,
            <?php
            echo $_SESSION['name'];
            ?>
        </h1>
        <a href="ramme_forms.html">form</a>
        <a href="logout.php">Logout</a>


        <h1>Velkommen til forsiden</h1>

    <a href="ramme_forms.html">
        <button>Ramme bestilling</button>
    </a>

    <a href="rammer_last_data.php">
        <button>Hent rammeordre</button>
    </a>
    </body>

    </html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>
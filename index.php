<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>



    <title>DONNÉS || LOGIN</title>
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon"/>
</head>

<body>
    <div class="loginWrapper">
    <div class="loginContainer">
    <form class="loginForm" action="login.php" method="POST">
        <h2 class="loginHeader">LOGIN</h2>
<?php
if(isset($_GET['error'])) {?>
<p class="error"><?php echo $_GET['error']; ?><p>

<?php }?>
<div class="login">
        <label for="">Brugernavn</label>
        <input type="text" name="uname" placeholder="Brugernavn"></br>
        <label for="">Password</label>
        <input type="password" name="password" placeholder="Password"></br>
        <button class="mainBtn" type="submit">Login</button><br>
        <a href="register.php" class="ca">Opret konto</a>
        </div>
    </form>
</div>

    <div class="footer">
            <p div class="version">Version 2.0</p>
        </div>
    </div>
</body>

</html>
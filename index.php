<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>



    <title>DONNÉS || LOGIN</title>
</head>

<body>
    <div class="login-wrapper">
    <div class="loginContainer">
    <form action="login.php" method="POST">
        <h2 class="loginHeader">LOGIN</h2>
<?php
if(isset($_GET['error'])) {?>
<p class="error"><?php echo $_GET['error']; ?><p>

<?php }?>

        <label for="">Brugernavn</label>
        <input type="text" name="uname" placeholder="Brugernavn"></br>
        <label for="">Password</label>
        <input type="password" name="password" placeholder="Password"></br>
        <button class="loginBtn" type="submit">Login</button>
        <a href="register.php" class="ca">Opret konto</a>
    </form>
</div>

    <div class="footer">
            <p div class="version">Version 1.0</p>
        </div>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="main.css" type="text/css" rel="stylesheet">
    <meta name="keywords" content="SKAL ÆNDRES!!!" />
    <meta name="description" content="SKAL ÆNDRES" />
    <meta name="author" content="Lasse Lykke @ Lasselykke.com" />


    <title>LOGIN</title>
</head>

<body>
    <form action="login.php" method="POST">
        <h2>LOGIN</h2>
<?php
if(isset($_GET['error'])) {?>
<p class="error"><?php echo $_GET['error']; ?><p>

<?php }?>

        <label for="">User Name</label>
        <input type="text" name="uname" placeholder="User Name"></br>
        <label for="">Password</label>
        <input type="password" name="password" placeholder="Password"></br>
        <button type="submit">Login</button>
        <a href="register.php" class="ca">Create an account</a>
    </form>
</body>

</html>
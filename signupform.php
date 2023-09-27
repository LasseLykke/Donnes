// Signup form vil ikke være synlig, men kun tilgåes ved at skrive url.


<h1>Signup form</h1>

<form action="includes/signupform.php" method="POST">
    <input type="text" name="uid" placeholder="Username">
    <input type="password" name="pwd" placeholder="Password">
    <input type="password" name="pwdrepeat" placeholder="Gentag password">
    <br>
    <button type="submit" name="submit">Sign up!</button>
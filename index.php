<!--
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
-->

<!--
Sign In Page
->Take user information and send it to login logic
->Offer redirection to signup page
-->

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1><u>MySBD</u></h1>
        <form action="login.php" method="post">    
        <h2>Login</h2>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <label>User Name</label>
            <input type="text" name="uname" placeholder="Enter User Name"><br>

            <label>Password</label>
            <input type="password" name="password" placeholder = "Enter Password"><br>
            
            <button type="submit">Login</button>
            <a href="signup.php" class="ca">Create Account</a>
        </form>
    </body>
</html>
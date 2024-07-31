<!--
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
-->

<!--Register page allows user to enter credentials which will be sent to signup_action-->
<!-- User must enter a name, username, password twice, and an email -->
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <form action="signup_action.php" method="post">
            <h2>Register</h2>

            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            
            <?php if (isset($_GET['registered'])) { ?>
                <p class="registered"><?php echo $_GET['registered']; ?></p>
            <?php } ?>

            <label>Name</label>
            <?php if (isset($_GET['name'])) { ?>
                <input type="text" name="name" placeholder="Enter Name" value="<?php echo ($_GET['name']); ?>"><br>
            <?php }else{ ?>
                <input type="text" name="name" placeholder="Enter Name"><br>
            <?php }?>

            <label>User Name</label>
            <?php if (isset($_GET['uname'])) { ?>
                <input type="text" name="uname" placeholder="Enter User Name" value="<?php echo $_GET['uname']; ?>"><br>
            <?php }else{ ?>
                <input type="text" name="uname" placeholder="Enter User Name"><br>
            <?php }?>

            <label>Password</label>
            <input type="password" name="password" placeholder = "Enter Password"><br>
            
            <label>Reenter Password</label>
            <input type="password" name="repassword" placeholder = "Reenter Password"><br>
            
            <label>Email</label>
            <input type="text" name="email" placeholder="Enter Email"><br>
            
            <button type="submit">Create Account</button>
            <!--Include option to be redirected to login page-->
            <a href="index.php" class="ca">Already have an account?</a>

        </form>
    </body>
</html>
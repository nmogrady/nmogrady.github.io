<?php
/*
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
*/

/*
Home Page
Check that user is signed in, then display options to view past workouts, record a workout, or logout
*/

session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>Welcome Back, <?php echo $_SESSION['name']; ?>!</header><br><br>
        <div class="home-buttons">
            <!--Send user to page based on which option they select-->
            <a href="record_workout.php" class="home-button">Record Workout</a>
            <a href="past_workouts.php" class="home-button">See Past Workouts</a>
            <a href="progress.php" class="home-button">See Progress</a>
            <a href="logout.php">Logout</a>
        </div>
    </body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>
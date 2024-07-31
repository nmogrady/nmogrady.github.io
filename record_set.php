<?php
/*
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
*/

//Record set page allows user to enter as many sets as they would like, each associated with the workout they started from record workout page

//start user session and include connection to database
include "db_conn.php";
session_start();

//make sure user is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Record Workout Sets</title>
</head>
<body>
    <h2>Record Set</h2>


    <!--Implement record multiple sets-->

    <!-- Form for typing set information. Upon submission, the form will send a post request to this file, which will handle navigation and data storage-->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-set">
        <label for="exercise">Exercise:</label>
        <input type="text" id="exercise" name="exercise" placeholder="Enter Excercise"><br><br>
        <label for="weight">Weight (lbs):</label>
        <input type="number" id="weight" name="weight" placeholder="Enter Weight"><br><br>
        <label for="reps">Reps:</label>
        <input type="number" id="reps" name="reps" placeholder="Enter Reps"><br><br>
        <label for="sets">Sets:</label>
        <input type="number" id="sets" name="sets" placeholder="Enter Sets"><br><br>
        <!--Provide buttons for options: record another set, record current set and finish, go home without recording current set-->
        <button type="submit" name="continue">Record Set And Continue</button>
        <button type="submit" name="last">Record Set And Finish</button>
        <button type="submit" name="finish">Back Home</button>
    </form>
    <?php

    //if record set and finish button is selected, the set information will be retrieved from the post request and inserted into the database. The user will then be returned to the home page
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['last'])) {
        $exercise = ucfirst($_POST['exercise']);
        $weight = $_POST['weight'];
        $reps = $_POST['reps'];
        $sets = $_POST['sets']; 
        $workout_id = $_SESSION['workout_id'];
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO sets (workout_id, user_id, exercise, reps, weight) VALUES ('$workout_id', '$user_id', '$exercise', '$reps', '$weight')";
        while ($sets > 0) {
        $result = mysqli_query($conn, $sql);
        $sets = $sets - 1;
        }
        header("Location: record_workout.php");
        exit();
    
    //if record another set button is selected, the set information will be retrieved from the post request and inserted into the database. The user will then be returned to the record set page where they can record another set
    } else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['continue'])) {
        $exercise = $_POST['exercise'];
        $weight = $_POST['weight'];
        $reps = $_POST['reps'];
        $sets = $_POST['sets']; 
        $workout_id = $_SESSION['workout_id'];
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO sets (workout_id, user_id, exercise, reps, weight) VALUES ('$workout_id', '$user_id', '$exercise', '$reps', '$weight')";
        while ($sets > 0) {
            $result = mysqli_query($conn, $sql);
            $sets = $sets - 1;
        }
        header("Location: record_set.php");
        exit();

    //if back home button is selected, query the database for any sets associated with the current workout. If there are none, meaning the user recorded 0 sets, delete the workout from the database. The user will be redirected to home page
    } else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['finish'])) {
        $workout_id = $_SESSION['workout_id'];
        $sql = "SELECT * FROM sets WHERE workout_id = '$workout_id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 0) {
            $sql2 = "DELETE FROM workouts WHERE workouts.workout_id = '$workout_id'";
            mysqli_query($conn, $sql2);
        }
        header("Location: home.php");
        exit();
    }
    ?>
</body>
</html>
<?php
}
?>
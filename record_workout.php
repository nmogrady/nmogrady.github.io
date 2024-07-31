<?php
/*
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
*/

//Record workout page allows a user to start a workout with an associated date

//start user session and include database connection
include "db_conn.php";
session_start();

// make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//if form is submitted, insert workout into database
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $workout_date = $_POST['workout_date'];
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO workouts (user_id, workout_date) VALUES ('$user_id', '$workout_date')";

    //retieve database-determined workout id from database, and set session value for use in record_set queries. Then redirect user to record_set
    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);
        $_SESSION['workout_id'] = $last_id;
        header("Location: record_set.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Record Workout</title>
</head>
<body>
    <header>Set Workout Date</header>
    <!--Simple html form for user to select workout date. Submit post request to self upon submission-->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="workout_date">Date:</label>
        <input type="date" id="workout_date" name="workout_date" required><br><br>
        <input type="submit" value="Record Workout">
    </form>
    <!--Back home button -->
    <a href="home.php" class="link">Back To Home</a>
</body>
</html>


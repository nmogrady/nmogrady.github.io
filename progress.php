<?php
/*
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
*/

//Progress page allows users to select an excercise to visualize their progress
//start user session and include database connection 
include "db_conn.php";
session_start();

//make sure user is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    //check for server post from form for selecting exercise
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //check that an exercise has been selected and it is not empty
        if (isset($_POST['exercises']) && !empty($_POST['exercises'])) {
            //if form has been submitted with an exercise selected, set a session variable for referring to the selected exercise, and redirect the user to the visualization
            $_SESSION['selected_exercise'] = $_POST['exercises'];
            header("Location: visualize.php");
            exit();
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Progress</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>Check Progress</header><br><br>
        <!--Create a form for selecting an exercise. The form will be populated with exercises the user has recorded previously. On form submission, send a server wide post request for handling-->
        <form method='post' class='dependent-form'>
            <label for="exercises">Choose an exercise</label>
            <select id="exercises" name="exercises">
            <?php
                //query the database for distinct exercises associated with the logged in user
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT DISTINCT exercise FROM users, sets WHERE users.user_id = sets.user_id AND users.user_id = '$user_id';";
                $result = mysqli_query($conn, $sql);

                //create an entry in the dropdown menu for each exercise returned by the query
                while ($row = mysqli_fetch_assoc($result)) {
                    $exercise = $row['exercise'];
                    echo "<option value='" . $exercise . "'>" . ucfirst($exercise) . "</option>";
                }
            ?>
            </select>
            <input type="submit" value="Select">
        </form>
        <!--Back to home button-->
        <a href="home.php" class="link">Back To Home</a>
    </body>
</html>
<?php
//if no user is logged in, send them back to login page
} else {
    header("Location: index.php");
    exit();
}
?>
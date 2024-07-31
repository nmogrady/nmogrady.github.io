<?php
/*
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
*/

//Past workout page displays all workouts and sets that a user has recorded
//start user session and include database connection
session_start();
include "db_conn.php";

//Ensure a user is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Workouts</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header><?php echo $_SESSION['name']; ?>'s Past Workouts</header>
        <div class="container">
            <div class="content">
                <?php
                //take the loggin in user's id and query the database for every workout associated with their id, and order them by date
                $id = $_SESSION['user_id'];
                $sql = "SELECT * FROM workouts WHERE user_id = '$id' ORDER BY workout_date";
                $result = mysqli_query($conn, $sql);

                //if a user has any past workouts, create a table
                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th><u>Date</u></th><th><u>Workout Info</u></th></tr>";
                    
                    //implement delete past workout and or past set

                    //iterate over each row in query and display each workout, and each set associated with that workout
                    while ($row = $result->fetch_assoc()) {
                        $current_id = $row['workout_id'];
                        //query the database for all sets associated with current workout
                        $sql2 = "SELECT * FROM sets WHERE sets.workout_id = '$current_id'";
                        $result2 = mysqli_query($conn, $sql2);
                        echo "<tr>";
                        echo "<td>" . $row["workout_date"] . "</td>";
                        echo "<td><ul>";
                        mysqli_data_seek($result2, 0);
                        while ($row2 = $result2->fetch_assoc()) {
                            echo "<li>" . ucfirst($row2['exercise']) . ": " . $row2['weight'] . " lbs for " . $row2['reps'] . " reps" . "</li>";
                        }
                        echo "</ul></td>";
                        
                        echo "</tr>";
                    }  
                    echo "</table>";
                //if a user has no recorded workouts, print so
                } else {
                    echo "0 results<br>";
                }

                ?>
                <!--Back home button-->
                <a href="home.php">Back To Home</a>
            </div>
        </div>
    </body>
</html>
<?php
//if user is not logged in, redirect to login page
} else {
    header("Location: index.php");
    exit();
}
?>
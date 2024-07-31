<?php
/*
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
*/

//Login php file to facilitate user login
//include database connection and start user session
session_start();
include "db_conn.php";

//check that user has attempted to login
if (isset($_POST['uname']) && isset($_POST['password'])) {
    //validate function takes a string and cleans it for use in validating user credentials
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    //if either field is empty, return to login page with error
    if (empty($uname)) {
        header("Location: index.php?error=User Name Not Entered");
        exit();
    }else if (empty($pass)){
        header("Location: index.php?error=Password Not Entered");
        exit();
    }else{
        //if both fields are not empty, query the database for the user's existence based on credentials, and send them to the home page (logging them in) if they exist
        $pass = md5($pass);
        $sql = "SELECT * FROM users WHERE username = '$uname' AND password_hash='$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $uname && $row['password_hash'] === $pass) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['name'] = ucfirst($row['firstname']);
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $row['password_hash'];
                $_SESSION['email'] = $row['email'];
                header("Location: home.php");
                exit();
            }
        //if the user does not exist, send them back to login page with error
        }else{
            header("Location: index.php?error=Incorrect username or password");
            exit();
        }

    }
//if a user attempts to access this page without hitting the login button, send them back to the login page without executing any other code
}else{
    header("Location: index.php");
    exit();
}
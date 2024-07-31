<?php
/*
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
*/

//Signup_action handles inserting users into the database if they enter valid credentials

//start user session and include database connection
session_start();
include "db_conn.php";

//Check to make sure signup form has been submitted
if (isset($_POST['name']) && isset($_POST['uname']) 
&& isset($_POST['password']) && isset($_POST['repassword'])
&& isset($_POST['email'])) {
    //clean all entries
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
    $name = validate($_POST['name']);
    $repass = validate($_POST['repassword']);
    $email = validate($_POST['email']);

    //if any entry was left blank, return to signup page with error message
    if (empty($name)) {
        header("Location: signup.php?error=Name Not Entered&uname=$uname");
        exit();
    }else if (empty($uname)) {
        header("Location: signup.php?error=User Name Not Entered&name=$name");
        exit();
    }else if (empty($pass)){
        header("Location: signup.php?error=Password Not Entered&name=$name&uname=$uname");
        exit();
    }else if (empty($repass)){
        header("Location: signup.php?error=Password Not Reentered&name=$name&uname=$uname");
        exit();
    }else if (empty($email)){
        header("Location: signup.php?error=Email Not Entered&name=$name&uname=$uname");
        exit();

    //if password entered do not match, return to signup page with error message
    }else if ($pass !== $repass) {
        header("Location: signup.php?error=Passwords do not match&name=$name&uname=$uname");
        exit();
    
    //if submission criteria was met, ensure a user by the same username does not exist. If the new username is unique, enter new user information into the database
    }else {
        //hash password
        $pass = md5($pass);

        //query the database for users with the same username. If query is not empty, the user must select a different username and they are redirected to the signup page with error message
        $sql = "SELECT * FROM users WHERE username = '$uname'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            header("Location: signup.php?error=Username already in use&name=$name");
            exit();
        //if the query is empty, insert new user information into the database and redirect them to the signup page with success message
        } else {
            $sql2 = "INSERT INTO users(firstname, username, password_hash, email) VALUES ('$name','$uname','$pass','$email')";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {
                header("Location: signup.php?registered=Account Successfully Created");
                exit();
            } else {
                header("Location: signup.php?error=Unknown Error Occurred");
                exit();
            }
          }
    }
//if form has not been submitted, redirect them to the signup page
}else{
    header("Location: signup.php");
    exit();
}
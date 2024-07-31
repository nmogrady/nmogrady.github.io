<?php
/*
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
*/

/*
Establish database connection parameters, and assign connection to $conn for use in querying
*/

$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "mysbd";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    echo "Connection Failed";
}
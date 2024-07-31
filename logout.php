<?php
/*
Created By: Noah O'Grady
KUID: 3071519
Last Edited: 5/10/24
*/

//End user session if logout is selected, and redirect to login page
session_start();

session_unset();
session_destroy();

header("Location: index.php");
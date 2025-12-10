<?php

ini_set('log_errors', 1);
ini_set('display_errors', 1);

session_start();

/*
 * $_SESSION['UserTYPE']
 * UserTYPE = 1 --> Parent
 * UserTYPE = 2 --> DRIVER
 * UserTYPE = 3 --> ADMIN
 *
 */



if($_SESSION["LoggedIN"]) {

    #If user logged in. redirect him to dashboard. Just to make it user friendly!

    if($_SESSION["UserTYPE"] == 'parent') {
        header("Location: Dashboard.php");

        #Redirect user to Parent Dashboard

    } elseif($_SESSION["UserTYPE"] == 'driver') {
        header("Location: Dashboard.php");
        #Redirect user to Driver Dashboard


    } elseif($_SESSION["UserTYPE"] == 'admin') {

        #Redirect user to Admin Dashboard
        header("Location: Dashboard.php");
    };


};


include_once "Template/iot_project_website.html";

?>



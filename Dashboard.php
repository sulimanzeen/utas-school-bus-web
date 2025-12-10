<?php
session_start();


if($_SESSION["LoggedIN"]) {

    if($_SESSION["UserTYPE"] == 'parent') {

        echo "You are a parent user!";


    } elseif($_SESSION["UserTYPE"] == 'driver') {
        echo "You are a Driver user!";

    } elseif($_SESSION["UserTYPE"] == 'admin') {
        echo "You are a Admin user!";


    };

} else {


    $domain = $_SERVER['HTTP_HOST'];
    $domain = "http://".$domain . "/";

    //header("Location: $domain");
}



<?php
session_start();

if(isset($_SESSION['LoggedIN'])){

    session_destroy();
    $domain = $_SERVER['HTTP_HOST'];
    $domain = "http://".$domain . "/";

    header("Location: $domain");
}

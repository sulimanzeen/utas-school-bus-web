<?php
session_start();


$userRole = ($_SESSION["UserTYPE"]);


if ($_SESSION["LoggedIN"]) {

    if ($_SESSION["UserTYPE"] == 'parent') {
     
		include_once "Template/parent_dashboard.php";
    } elseif ($_SESSION["UserTYPE"] == 'driver') {
       
		include_once "Template/driver_dashboard.php";
    } elseif ($_SESSION["UserTYPE"] == 'admin') {
        
		include_once "Template/admin_dashboard.php";
    }

    

} else {
    $domain = $_SERVER['HTTP_HOST'];
    $domain = "http://".$domain . "/";
    // header("Location: $domain");
}
?>

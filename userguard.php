<?php  

if(!isset($_SESSION["useronline"])){
    $_SESSION["errormsg"] = "Login to view profile";
    header("location:login.php");
    exit;
}




?>
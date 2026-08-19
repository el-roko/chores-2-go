<?php
if(!isset($_SESSION["adminonline"])){
    $_SESSION["errormsg"] = "You need to be logged in to access this page ";
    header("location:login.php");
    exit;
    
}

?>
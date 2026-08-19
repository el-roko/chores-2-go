<?php
if(isset($_SESSION["adminonline"])){
    header("location:dashboard.php");
    exit;
    
}

?>
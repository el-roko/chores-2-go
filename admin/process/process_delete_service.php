<?php
session_start();
require_once "../classes/Service.php";

$s = new Service;

if(isset($_POST["service_id"])){
    $service_id = $_POST["service_id"];
    if(empty($service_id)){
        $_SESSION["errormsg"] = "Invalid service.";
        header("location:../manage_services.php");
        exit;
    }

    $deleted = $s->delete_service($service_id);
    if($deleted){
        $_SESSION["feedback"] = "Service deleted successfully";
    } else {
        $_SESSION["errormsg"] = "Unable to delete service.";
    }
}

header("location:../manage_services.php");
exit;

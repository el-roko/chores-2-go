<?php
session_start();
require_once "../classes/Service.php";

$s = new Service;

if(isset($_POST["btn"])){
    $service_id = $_POST["service_id"] ?? null;
    $service_name = trim($_POST["servname"] ?? "");
    $service_desc = trim($_POST["desc"] ?? "");

    if(empty($service_id) || empty($service_name) || empty($service_desc)){
        $_SESSION["errormsg"] = "All inputs required";
        header("location:../manage_services.php");
        exit;
    }

    $rsp = $s->update_service($service_id, $service_name, $service_desc);
    if($rsp === true){
        $_SESSION["feedback"] = "Service updated successfully";
    } else {
        $_SESSION["errormsg"] = "Unable to update service.";
    }
    header("location:../manage_services.php");
    exit;
}

header("location:../manage_services.php");
exit;

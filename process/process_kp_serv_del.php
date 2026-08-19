<?php
session_start();
require_once "../classes/Keeper.php";
$kp = new Keeper;

if(isset($_POST['service_id'])){
    $serviceId = intval($_POST['service_id']);
    $keeperId = null;

    if(isset($_SESSION['useronline'])){
        $keeperId = is_array($_SESSION['useronline']) && isset($_SESSION['useronline']['keeper_id'])
            ? intval($_SESSION['useronline']['keeper_id'])
            : intval($_SESSION['useronline']);
    }

    if(!$keeperId){
        $_SESSION['errormsg'] = "Invalid user session.";
        header("Location:../keeper_profile.php");
        exit;
    }

    $deleted = $kp->delete_service($serviceId, $keeperId);

    if($deleted){
        $_SESSION['feedback'] = "Service removed successfully.";
    } else {
        $_SESSION['errormsg'] = "Failed to remove service.";
    }
}
header("Location:../keeper_profile.php");
exit;

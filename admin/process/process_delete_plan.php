<?php
session_start();
require_once "../classes/Service.php";

$s = new Service;

if(isset($_POST["plan_id"])){
    $plan_id = $_POST["plan_id"];
    if(empty($plan_id)){
        $_SESSION["errormsg"] = "Invalid plan.";
        header("location:../manage_plan.php");
        exit;
    }

    $deleted = $s->delete_plan($plan_id);
    if($deleted){
        $_SESSION["feedback"] = "Plan deleted successfully";
    } else {
        $_SESSION["errormsg"] = "Unable to delete plan.";
    }
}

header("location:../manage_plan.php");
exit;

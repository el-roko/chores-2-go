<?php
session_start();
require_once "../classes/Service.php";

$s = new Service;

if(isset($_POST["btn"])){
    $plan_id = $_POST["plan_id"] ?? null;
    $plan_name = trim($_POST["servname"] ?? "");
    $plan_desc = trim($_POST["desc"] ?? "");

    if(empty($plan_id) || empty($plan_name) || empty($plan_desc)){
        $_SESSION["errormsg"] = "All inputs required";
        header("location:../manage_plan.php");
        exit;
    }

    $rsp = $s->update_plan($plan_id, $plan_name, $plan_desc);
    if($rsp === true){
        $_SESSION["feedback"] = "Plan updated successfully";
    } else {
        $_SESSION["errormsg"] = "Unable to update plan.";
    }
    header("location:../manage_plan.php");
    exit;
}

header("location:../manage_plan.php");
exit;

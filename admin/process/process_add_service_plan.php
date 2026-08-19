<?php
session_start();
require_once "../classes/Service.php";

$s = new Service;

if(isset($_POST["btn"])){
    $plan = trim($_POST["servname"] ?? "");
    $desc = trim($_POST["desc"] ?? "");
   
            if(empty($plan) || empty($desc)){
                $_SESSION["errormsg"] = "All inputs required";
                header("location:../add_services_plan_form.php");
                exit;
            }
                $rsp = $s->add_service_plan($plan,$desc);
                    if($rsp == true){
                         $_SESSION["feedback"] = "Service_plan Created succefully";
                        header("location:../manage_plan.php");
                        exit;
                    }else{
                        $_SESSION["err"] ="Oops Sorry try again";
                        header("location:../add_services_plan_form.php");
                        exit;
                    }
               
            
}else{
    header("location:add_services-plan_form.php");
    exit;
}





?>
<?php
session_start();
require_once "../classes/Service.php";

$s = new Service;

if(isset($_POST["btn"])){
    $service_name = $_POST["servname"];
    $service_desc = $_POST["desc"];
   
            if(empty($service_name) || empty($service_desc)){
                $_SESSION["errormsg"] = "All inputs required";
                header("location:../add_services_form.php");
                exit;
            }
                $rsp = $s->add_service($service_name,$service_desc);
                    if($rsp == true){
                         $_SESSION["feedback"] = "Service Created succefully";
                        header("location:../manage_services.php");
                        exit;
                    }else{
                        $_SESSION["err"] ="Oops Sorry try again";
                        header("location:../add_services_form.php");
                        exit;
                    }
               
            
}else{
    header("location:../admin/add_services_form.php");
    exit;
}





?>
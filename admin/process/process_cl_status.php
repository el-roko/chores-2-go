<?php   
session_start();
require_once "../classes/Admin.php";

$ad = new Admin;


if(isset($_POST["client_id"]) && isset($_POST["status"])) {

    $client_id =(int) $_POST["client_id"];
    $status = trim($_POST["status"]);
    // var_dump($status);
    //             die;

            if(!empty($client_id) && !empty($status)){
                $stat =$ad->update_client_status($client_id, $status);
                
                        if($stat){
                            $_SESSION["feedback"]= "Successful";
                            header("Location:../manage_client.php");
                            exit;
                        }else{
                            $_SESSION["errormsg"]="Failed";
                            header("Location:../manage_client.php");
                            exit;
                        }
            }
}else{
    header("Location:../manage_client.php");
    exit;
}







?>
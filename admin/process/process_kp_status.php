<?php   
session_start();
require_once "../classes/Admin.php";

$ad = new Admin;


if(isset($_POST["keeper_id"]) && isset($_POST["status"])) {

    $keeper_id =(int) $_POST["keeper_id"];
    $status = trim($_POST["status"]);
    // var_dump($status);
    //             die;

            if(!empty($keeper_id) && !empty($status)){
                $stat =$ad->update_keeper_status($keeper_id, $status);
                
                        if($stat){
                            $_SESSION["feedback"]= "Successful";
                            header("Location:../manage_keeper.php");
                            exit;
                        }else{
                            $_SESSION["errormsg"]="Failed";
                            header("Location:../manage_keeper.php");
                            exit;
                        }
            }
}else{
    header("Location:../manage_keeper.php");
    exit;
}







?>
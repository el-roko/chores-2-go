<?php
session_start();
require_once "../classes/Keeper.php";
$k = new Keeper;

if(isset($_POST["btnchangepwd"])){
    $oldpass = $_POST["currentpwd"];
    $newpass = $_POST["newpwd"];
    $confirmpass = $_POST["newpwd1"];

        if(empty($oldpass) || empty($newpass) || empty($confirmpass)){
                $_SESSION["errormsg"] = "Input fields must not be empty";
                header("Location:change_password.php");
                exit;
        }

        if($newpass !== $confirmpass){
           $_SESSION["errormsg"] = "Password does not match";
            header("Location:change_password.php");
                exit;
        }
        
        
       
            $update = $k->update_password($_SESSION["useronline"], $oldpass, $newpass);
                if($update){
                    $_SESSION["feedback"] = "Password updated successfully";
                     header("Location:keeper_profile.php");
                        exit;
                }else{
                    $_SESSION["errormsg"] = "Sorry couldn't update try again later";
                     header("Location:change_password.php");
                         exit;
                }
       
            



}else{
    header("location:../");
}
<?php
session_start();

    require_once "../classes/Client.php";
    $cl = new Client;

    require_once "../classes/Keeper.php";
    $kp = new Keeper;

//    if(isset($_POST["role"])){
         $email = $_GET["email"];
    $role = $_GET["role"];

    if($role == "client"){
        $chck = $cl->check_clemail($email);
            if($chck == false){
                echo "Database error";
            }else{
                echo $chck;
            }
    }else{
        $chck = $kp->check_kpemail($email);
            if($chck == false){
                echo "database error";
            }else{
                echo "$chck";
            }
    }
  // }
   //else{
   // $_SESSION["errormsg"] = "Select Role befor proceding";
   
   //}







?>
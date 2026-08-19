<?php
session_start();
require_once "../classes/Client.php";
$cl = new Client;

require_once "../classes/Keeper.php";
$kp = new Keeper;


if(isset($_POST["btnreg"])){
    
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = $_POST["pwd1"];
    $con_password = $_POST["pwd2"];

  

     if(empty($firstname) || empty($lastname) || empty($role) || empty($phone) || empty($email) || empty($password)){
        $_SESSION["errormsg"] = "Fill all input fields";
          header("location:../reg.php");
          exit;
     }elseif($password != $con_password){
        $_SESSION["errormsg"] = "Passwords must match";
         header("location:../reg.php");
         exit;
     }

     if($role == "client"){
                $response = $cl->register_client($firstname,$lastname,$email,$phone,$password);
            if($response){
                $_SESSION['useronline'] = $response;
            
                $_SESSION["feedback"] = "Registration Successful";
                header("location:../client_profile.php");
                exit;
            }else{
                $_SESSION["errormsg"] = "Registration Failed ";
                header("location:../reg.php");
                exit;
            }
     }elseif($role == "keeper"){
                $response = $kp->register_keeper($firstname,$lastname,$email,$phone,$password);
            if($response){
                $_SESSION['useronline'] = $response;
    
                $_SESSION["feedback"] = "Registration Successful";
                header("location:../keeper_profile.php");
                exit;
            }else{
                $_SESSION["errormsg"] = "Registration Failed ";
                header("location:../reg.php");
                exit;
            }
     }

     


 }else{
     $_SESSION["errormsg"] = "Please complete the form fields";
     header("location:../reg.php");
     exit;
}


?>
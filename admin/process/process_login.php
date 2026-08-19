<?php
session_start();
require_once "../classes/Admin.php";


if(isset($_POST["btnlogin"])){
    $email =$_POST["email"];
    $password =$_POST["pwd"];
        if(empty($email) || empty($password)){  
            $_SESSION["errormsg"] = "All input fields must be filled";
             header("location:../login.php");
            exit;
        }
                $ad = new Admin;
                $res = $ad->admin_login($email, $password);
   
                if ((int)$res > 0) {
                    $_SESSION["adminonline"] = $res; 
                    header("Location: ../dashboard.php");
                    exit;
                } else {
                    $_SESSION["errormsg"] = "Invalid email or password";
                    header("Location: ../login.php");
                    exit;
                }
                          

    }else{
         header("location:../login.php");
          exit;
        }





?>
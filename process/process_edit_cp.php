<?php
session_start();
require_once "../classes/Client.php";
$c = new Client;


if(isset($_POST["email"])){
    $fn = $_POST["fname"];
    $ln = $_POST["lname"];
    $gender = $_POST["sex"];
    $dob = $_POST["dob"];
    $ph = $_POST["phone"];
    $em = $_POST["email"];
    $ad = $_POST["address"];
    $mar = $_POST["mstatus"];
    $state = $_POST["state"];
    $lga = $_POST["lga"];
  
   
  
    


        if(empty($fn) || empty($ln) || empty($gender) || empty($em) || empty($ph) || empty($mar) || empty($ad) || empty($state)){
                echo "<div class='alert alert-danger'>Please fill in your details</div>";
                    exit;
        }else{
   
        $clp = $c->update_profile($fn,$ln,$gender,$dob,$ph,$em,$ad,$mar,$state,$lga,$_SESSION["useronline"]);
                if($clp === true){
                    $_SESSION["feedback"] = "<div class='alert alert-success'>Updated Successfully</div>";
                    header("location:../client_profile.php");
                    exit;
                }else{
                    $_SESSION["errormsg"] = "<div class='alert alert-danger'>Oops update failed try again: $clp</div>";
                     header("location:../edit_clientprofile.php");
                     exit;
                }
    }


    

  


}else{
   $_SESSION["errormsg"] = "<div class='alert alert-danger'>Invalid request</div>";
    header("location:../edit_clientprofile.php");
    exit;
}


   


?>
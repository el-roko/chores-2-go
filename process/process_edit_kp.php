<?php
session_start();
require_once "../classes/Keeper.php";
$k = new Keeper;

if(isset($_POST["email"])){
    $fn = $_POST["fname"];
    $ln = $_POST["lname"];
    $gender = $_POST["sex"];
    $dob = $_POST["dob"];
    $ph = $_POST["phone"];
    $em = $_POST["email"];
    $ad = $_POST["address"];
    $mar = $_POST["mstatus"];
    $st = $_POST["state"];

        if(isset($_POST["lga"])){
             $lga = $_POST["lga"];
        }
   
  
       
   
  
    


        if(empty($fn) || empty($ln) || empty($gender) || empty($em) || empty($ph) || empty($mar) ||  empty($ad) || empty($st) || empty($lga)){
        
                header("location:../edit_keeperprofile.php");
                $_SESSION["errormsg"] = "<div class='alert alert-danger'>Please fill in all input fields</div>";
                    exit;
        }else{
   
        $kpp = $k->update_profile($fn,$ln,$gender,$dob,$ph,$em,$ad,$mar,$st,$lga,$_SESSION["useronline"]);
                 
                if($kpp === true){
                    $_SESSION["feedback"] = "<div class='alert alert-success'>Updated Successfully</div>";
                    header("location:../keeper_profile.php");
                    exit;
                }else{
                    $_SESSION["errormsg"] = "<div class='alert alert-danger'>Oops update failed try again: $kpp</div>";
                     header("location:../edit_keeperprofile.php");
                     exit;
                }
    }
    


}else{
   $_SESSION["errormsg"] = "<div class='alert alert-danger'>Invalid request</div>";
    header("location:../edit_keeper_profile.php");
    exit;
}


?>
<?php
session_start();
require_once "../classes/Client.php";

$cl = new Client;

if(isset($_POST["btn"])){

    $id = $_POST["id"];
    $msg = $_POST["msg"];
    $rating = $_POST["rate"];
    

        if(empty($id) || empty($msg) || empty($rating)){
            $_SESSION["errormsg"] = "Fill all input fields";
            header("Location:../review.php");
            exit;
        }else{
            $review = $cl->review($id,$rating,$msg);
                if($rating){
                    $_SESSION["feedback"] = "Review submitted succefully";
                    header("Location:../client_profile.php");
                    exit;
                }else{
                    $_SESSION["errormsg"] = "Please try again";
                    header("Location:../review.php");
                    exit;
                }
        }
}else{
    header("Location:../client_profile.php");
    exit;
}








?>
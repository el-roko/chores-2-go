<?php
session_start();

require_once "../classes/Service.php";

$ser = new Service;

if(isset($_POST["btn"])){

    $client = $_POST['client'];
    $keeper = $_POST['keeper'];
    $cate = $_POST['category'];
    $plan = $_POST['plan'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $address = $_POST['address'];

        if(empty($client) || empty($keeper) || empty($cate) || empty($plan) || empty($date) || empty($time) || empty($address)){
            $_SESSION['errormsg'] = "All fields are required";
            header("location:../book.php");
            exit;

        }else{
            $book = $ser->book_service($client, $keeper, $cate, $plan, $date, $time, $address);
                if($book){
                    $_SESSION['feedback'] = "Booking successful";
                    header("location:../client_profile.php");
                    exit;
                    }else{
                        $_SESSION['errormsg'] = "Please try again";
                    }
        }

}else{
    $_SESSION['errormsg'] = "Invalid request";
    header("location:../book.php");
    exit;
}





?>
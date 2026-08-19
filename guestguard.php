<?php

    // if(isset($_SESSION["useronline"])){
    //      $role = $_SESSION["role"] ?? "guest"; 

    //     // $role = $_SESSION["role"];
    //     if($role == "client"){
    //     header("location:client_profile.php");
    //     exit;
    //     }elseif($role == "keeper"){
    //         header("location:keeper_profile.php");
    //         exit;
    //     }else{
    //         header("Location: login.php");
    //         exit;
    //     }
    // }


if(isset($_SESSION["useronline"])){
    header("location:home.php");
    exit;
    
}

// if(!isset($_SESSION["useronline"])) {
//     // Not logged in → send to login
//    // header("Location: login.php");
//     exit;
// }

// $role = $_SESSION["role"] ?? "guest";

// // Allow both client and keeper to stay on chat.php
// if(!in_array($role, ["client", "keeper"])) {
//     // Any other role → send to login
//     header("Location:home.php");
//     exit;
// }

// If role is client or keeper, just continue to chat.php





?>
<?php
session_start();

require_once "../classes/Client.php";
    $cl = new Client;

require_once "../classes/Keeper.php";
    $kp = new Keeper;

    if(isset($_POST["btnlogin"])){
        $email = $_POST["email"];
        $password = $_POST["pwd"];
        $role = $_POST["role"];

        if(empty($email) || empty($password) || empty($role)){
            $_SESSION["errormsg"] = "Fill all input fields";
            header("location:../login.php");
            exit;
        }

            if($role == "client"){
                $rsp = $cl->client_login($email,$password);
                        if(is_array($rsp) &&  isset($rsp['client_id'])){
                                 if($rsp['status'] === "blocked"){
                            $_SESSION["errormsg"] = "Your account has been blocked. Contact support.";
                            header("location:../login.php");
                            exit;
                        }
                        if($rsp['status'] !== "active"){
                            $_SESSION["errormsg"] = "Your account is not active.";
                            header("location:../login.php");
                            exit;
                        }
                             $_SESSION["useronline"] = $rsp['client_id'];
                               
                            $_SESSION["role"] = "client";
                            header("location:../client_profile.php");
                            exit;
                        }else{
                            $_SESSION["errormsg"] = $rsp;
                            header("location:../login.php");
                            exit;
                        }
            }elseif($role == "keeper"){
                $rsp = $kp->keeper_login($email,$password);
                        if(is_array($rsp) &&  isset($rsp['keeper_id'])){
                                 if($rsp['status'] === "blocked"){
                            $_SESSION["errormsg"] = "Your account has been blocked. Contact support@chores.com ";
                            header("location:../login.php");
                            exit;
                        }
                        if($rsp['status'] !== "active"){
                            $_SESSION["errormsg"] = "Your account is not active.";
                            header("location:../login.php");
                            exit;
                        }
                             $_SESSION["useronline"] = $rsp['keeper_id'];
                               
                            $_SESSION["role"] = "keeper";
                            header("location:../keeper_profile.php");
                            exit;
                        }else{
                            $_SESSION["errormsg"] = $rsp;
                            header("location:../login.php");
                            exit;
                        }
            }


    }else{
        $_SESSION["errormsg"] = "Fill Email and Password";
        header("location:../login.php");
        exit;
    }







?>
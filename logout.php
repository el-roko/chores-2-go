<?php
session_start();
require_once "classes/Client.php";
    $cl = new Client;




    $cl->logout();
    header("location:login.php");
    exit;




?>
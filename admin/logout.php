<?php
session_start();

require_once "classes/Admin.php";
$l = new Admin;
$lg = $l->logout();

header("location:login.php");
exit;

    ?>
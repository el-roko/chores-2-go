<?php
session_start();
require_once "../adminguard.php";
require_once "../classes/Review.php";

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["review_id"])){
    $rv = new Review;
    $rv->delete_review($_POST["review_id"]);
}

header("Location: ../manage_reviews.php");
exit;

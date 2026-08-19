<?php

require_once "classes/Client.php";
require_once "classes/Keeper.php";

$cl = new Client;
$kp = new Keeper;

$clientId = null;
if(isset($_SESSION["useronline"])){
    $clientId = is_array($_SESSION["useronline"]) && isset($_SESSION["useronline"]["client_id"])
        ? $_SESSION["useronline"]["client_id"]
        : $_SESSION["useronline"];
} elseif(isset($_SESSION["user_id"])){
    $clientId = $_SESSION["user_id"];
}

if(!$clientId){
    header("Location: login.php");
    exit;
}

// Get client data
$record = $cl->get_client_byid($clientId);
$show = $cl->show_origin($clientId);

// Fetch client bookings
$bookings = $cl->fetch_client_bookings($clientId);

// Handle booking cancellation
if(isset($_POST['cancel_booking'])) {
    $service_id = $_POST['service_id'];

    $result = $cl->cancel_booking($service_id, $clientId);

    if($result) {
        $_SESSION['feedback'] = "Your booking request has been cancelled successfully.";
        $_SESSION['feedback_type'] = "success";
    } else {
        $_SESSION['feedback'] = "Failed to cancel booking.";
        $_SESSION['feedback_type'] = "danger";
    }
    header("Location: cl_track_status.php");
    exit;
}

// Calculate stats
$total_bookings = count($bookings);
$pending_count = 0;
$completed_count = 0;
$cancelled_count = 0;

foreach($bookings as $b) {
    $status = strtolower($b['status'] ?? 'pending');
    if($status == 'pending') $pending_count++;
    else if($status == 'done') $completed_count++;
    else if($status == 'cancelled') $cancelled_count++;
}









?>
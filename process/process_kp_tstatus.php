<?php

require_once "classes/Keeper.php";

$kp = new Keeper;

$keeperId = null;
if(isset($_SESSION["useronline"])){
    $keeperId = is_array($_SESSION["useronline"]) && isset($_SESSION["useronline"]["keeper_id"])
        ? $_SESSION["useronline"]["keeper_id"]
        : $_SESSION["useronline"];
} elseif(isset($_SESSION["user_id"])){
    $keeperId = $_SESSION["user_id"];
}

if(!$keeperId){
    header("location:login.php");
    exit;
}

$record = $kp->get_keeper_byid($keeperId);
$show   = $kp->show_origin($keeperId);
$serv   = $kp->fetch_kp_services($keeperId);

// Fetch bookings using the Keeper class method
$bookings = $kp->fetch_kp_bookings($keeperId);

if(!is_array($bookings)){
    error_log("fetch_kp_bookings failed: " . $bookings);
    $bookings = [];
}

// Handle booking status update
if(isset($_POST['update_booking_status'])) {
    $service_id = $_POST['service_id'];
    $status = $_POST['status'];

    // Must match the DB enum exactly (all lowercase)
    $allowed_statuses = ['pending', 'done', 'cancelled', 'waiting'];
    if(in_array($status, $allowed_statuses)) {
        $result = $kp->update_booking_status($service_id, $status, $keeperId);
        if($result) {
            $_SESSION['feedback'] = "Booking #" . $service_id . " marked as " . ucfirst($status) . ".";
            $_SESSION['feedback_type'] = "success";
        } else {
            $_SESSION['feedback'] = "Failed to update booking status.";
            $_SESSION['feedback_type'] = "danger";
        }
    } else {
        $_SESSION['feedback'] = "Invalid status selected.";
        $_SESSION['feedback_type'] = "danger";
    }
    header("Location: kp_track_status.php");
    exit;
}

// Calculate counts
$waiting_count = 0; // new requests awaiting accept/decline
$active_count  = 0; // accepted, in progress
foreach($bookings as $b) {
    $s = strtolower($b['status'] ?? '');
    if($s == 'waiting') $waiting_count++;
    if($s == 'pending') $active_count++;
}

// Calculate stats
$stats = $kp->get_keeper_booking_stats($keeperId);





?>
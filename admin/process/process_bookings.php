<?php
session_start();

require_once "../classes/Service.php";

$service = new Service;

if (isset($_POST['update_status'])) {
    $service_id = (int)($_POST['service_id'] ?? 0);
    $status = $_POST['status'] ?? 'pending';

    if ($service->update_booking_status($service_id, $status)) {
        $_SESSION['feedback'] = 'Booking status updated successfully.';
        $_SESSION['feedback_type'] = 'success';
          header('Location: ../manage_bookings.php');
            exit;
    } else {
        $_SESSION['feedback'] = 'Unable to update booking status.';
        $_SESSION['feedback_type'] = 'danger';
          header('Location: ../manage_bookings.php');
            exit;
    }

   
}else{
     header('Location: ../manage_bookings.php');
    exit;
}













?>
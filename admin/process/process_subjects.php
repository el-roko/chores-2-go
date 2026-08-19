<?php

if (isset($_POST['update_status'])) {
    $service_id = $_POST['service_id'] ?? 0;
    $status = $_POST['status'] ?? 'pending';
    $allowed = ['pending', 'Done', 'Cancelled'];

    if (in_array($status, $allowed)) {
        try {
            $stmt = $p->connect()->prepare("UPDATE services SET status = ? WHERE service_id = ?");
            $stmt->execute([$status, $service_id]);
            $_SESSION['feedback'] = 'Booking status updated successfully.';
            $_SESSION['feedback_type'] = 'success';
        } catch (PDOException $e) {
            $_SESSION['feedback'] = 'Unable to update booking status.';
            $_SESSION['feedback_type'] = 'danger';
        }
    } else {
        $_SESSION['feedback'] = 'Invalid status selected.';
        $_SESSION['feedback_type'] = 'danger';
    }

    header('Location: monitor_subjects.php');
    exit;
}

$pending = 0; $completed = 0; $cancelled = 0;
foreach ($bookings as $b) {
    $status = strtolower($b['status'] ?? 'pending');
    if ($status === 'pending') $pending++;
    elseif ($status === 'done') $completed++;
    elseif ($status === 'cancelled') $cancelled++;
}



?>
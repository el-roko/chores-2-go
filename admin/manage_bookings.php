<?php
session_start();
require_once "adminguard.php";
require_once "classes/Admin.php";
require_once "classes/Service.php";

$p = new Admin;
$service = new Service;
$user = $p->get_admin_byid($_SESSION["adminonline"]);

$bookings = [];
$pending = 0;
$completed = 0;
$cancelled = 0;

$bookings = $service->manage_bookings();



foreach ($bookings as $b) {
    $status = strtolower($b['status'] ?? 'pending');
    if ($status === 'pending') {
        $pending++;
    } elseif ($status === 'done') {
        $completed++;
    } elseif ($status === 'cancelled') {
        $cancelled++;
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin · Monitor Subjects</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body { background:#f2f5f9; }
    .sidebar { background:#1f2c3d; min-height:100vh; color:#fff; }
    .sidebar .nav-link { color:#c7d0db; padding:0.7rem 1rem; border-radius:10px; }
    .sidebar .nav-link:hover, .sidebar .nav-link.active { background:#33465d; color:#fff; }
    .main-content { padding:1.5rem 2rem; }
    .card-modern { background:#fff; border:none; border-radius:20px; box-shadow:0 8px 24px rgba(0,0,0,0.04); }
    .stat-card { border-radius:18px; padding:1rem; }
    .status-badge { padding:0.3rem 0.7rem; border-radius:999px; font-size:0.75rem; font-weight:600; text-transform:capitalize; }
    .status-badge.pending { background:#fff3cd; color:#856404; }
    .status-badge.done { background:#d4edda; color:#155724; }
    .status-badge.cancelled { background:#f8d7da; color:#721c24; }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row g-0">
       <?php require_once "partials/admin_navbar.php"; ?>
   
    <div class="col-lg-12 col-md-9 main-content">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="mb-1">Monitor Bookings</h2>
          <p class="text-muted mb-0">Track active service requests and update their status.</p>
        </div>
        <span class="badge bg-light text-dark px-3 py-2">Welcome, <?php echo htmlspecialchars($user['admin_fname'] ?? 'Admin'); ?></span>
      </div>

      <?php if (!empty($_SESSION['feedback'])): ?>
        <div class="alert alert-<?php echo $_SESSION['feedback_type'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
          <?php echo htmlspecialchars($_SESSION['feedback']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['feedback'], $_SESSION['feedback_type']); ?>
      <?php endif; ?>

      <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card-modern stat-card"><h6 class="text-muted">Pending</h6><h3 class="fw-bold mb-0"><?php echo $pending; ?></h3></div></div>
        <div class="col-md-4"><div class="card-modern stat-card"><h6 class="text-muted">Completed</h6><h3 class="fw-bold mb-0"><?php echo $completed; ?></h3></div></div>
        <div class="col-md-4"><div class="card-modern stat-card"><h6 class="text-muted">Cancelled</h6><h3 class="fw-bold mb-0"><?php echo $cancelled; ?></h3></div></div>
      </div>

      <div class="card-modern p-3 p-md-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Current Bookings</h5>
          <span class="text-muted small"><?php echo count($bookings); ?> total</span>
        </div>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <td>S/N</td>
                <th>Client</th>
                <th>Keeper</th>
                <th>Service</th>
                <th>Plan</th>
                <th>Appointment</th>
                <th>Status</th>
                <th>Control</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($bookings)): ?>
                <?php $sn = 1; foreach ($bookings as $b): ?>
                  <?php $status = strtolower($b['status'] ?? 'pending'); ?>
                  <tr>
                    <td><?php echo $sn++ ?></td>
                    <td>
                      <div class="fw-semibold"><?php echo htmlspecialchars(($b['client_fname'] ?? 'N/A') . ' ' . ($b['client_lname'] ?? '')); ?></div>
                      <div class="small text-muted"><?php echo htmlspecialchars($b['cl_phone'] ?? ''); ?></div>
                    </td>
                    <td>
                      <div class="fw-semibold"><?php echo htmlspecialchars(($b['keeper_fname'] ?? 'N/A') . ' ' . ($b['keeper_lname'] ?? '')); ?></div>
                      <div class="small text-muted"><?php echo htmlspecialchars($b['kp_phone'] ?? ''); ?></div>
                    </td>
                    <td>
                      <div class="fw-semibold"><?php echo htmlspecialchars($b['service_categories_name'] ?? '—'); ?></div>
                      <div class="small text-muted"><?php echo htmlspecialchars(substr($b['service_address'] ?? '', 0, 40)); ?></div>
                    </td>
                    <td><?php echo htmlspecialchars($b['plan_name'] ?? '—'); ?></td>
                    <td>
                      <div><?php echo htmlspecialchars($b['service_date'] ?? '—'); ?></div>
                      <div class="small text-muted"><?php echo htmlspecialchars($b['service_time'] ?? '—'); ?></div>
                    </td>
                    <td><span class="status-badge <?php echo $status; ?>"><?php echo ucfirst($status); ?></span></td>
                    <td>
                      <form action="process/process_bookings.php" method="post" class="d-flex gap-2 align-items-center">
                        <input type="hidden" name="service_id" value="<?php echo (int)($b['service_id'] ?? 0); ?>">
                        <select name="status" class="form-select form-select-sm" style="max-width: 120px;">
                          <option value="pending" <?php echo $status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                          <option value="Done" <?php echo $status === 'done' ? 'selected' : ''; ?>>Done</option>
                          <option value="Cancelled" <?php echo $status === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-sm btn-dark">Save</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted py-4">No bookings found.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

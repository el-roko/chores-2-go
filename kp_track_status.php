<?php
session_start();
require_once "userguard.php";
require_once "process/process_kp_tstatus.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Track Status · Keeper Dashboard · Chores-2-Go</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Inter', sans-serif; }
    body {
      background: #f2f5f9;
      margin: 0;
      padding: 0;
    }
    .banner-modern {
      background: linear-gradient(145deg, #1a2639, #2a3b5c);
      padding: 2.5rem 1.5rem;
      border-radius: 0 0 40px 40px;
      margin-bottom: 2rem;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .banner-modern::after {
      content: '';
      position: absolute;
      top: -30%;
      right: -10%;
      width: 300px;
      height: 300px;
      background: rgba(255,255,255,0.02);
      border-radius: 50%;
      pointer-events: none;
    }
    .banner-modern h1 { font-weight: 700; letter-spacing: -0.02em; }
    .banner-modern p { opacity: 0.85; font-weight: 400; }
    .card-modern {
      background: #ffffff;
      border: none;
      border-radius: 24px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03), 0 4px 10px rgba(0, 0, 0, 0.02);
      transition: all 0.2s ease;
    }
    .card-modern:hover { box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05); }
    .profile-card {
      background: #ffffff;
      border-radius: 28px;
      padding: 2rem 1.5rem;
      text-align: center;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.02);
      border: 1px solid rgba(255,255,255,0.4);
      backdrop-filter: blur(2px);
      height: fit-content;
    }
    .profile-card img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      border-radius: 50%;
      border: 5px solid #eef2f7;
      box-shadow: 0 8px 20px rgba(0,0,0,0.04);
      margin-bottom: 1.2rem;
      background: #f0f4fa;
    }
    .profile-card h3 { font-weight: 700; color: #1e2a41; letter-spacing: -0.01em; }
    .badge-soft {
      background: #eef3fa;
      color: #1e2a41;
      font-weight: 500;
      padding: 0.5rem 1rem;
      border-radius: 40px;
      display: inline-block;
      margin: 0.2rem 0;
      font-size: 0.9rem;
      border: 1px solid #dfe7ef;
    }
    .badge-soft i { margin-right: 6px; color: #3a5a7a; }
    .info-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 8px 12px;
      margin-top: 0.5rem;
    }
    .info-grid .badge-soft { margin: 0; }
    .action-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; }
    .action-btn {
      background: white;
      border: 1px solid #eaf0f6;
      border-radius: 60px;
      padding: 0.6rem 1.6rem;
      font-weight: 500;
      color: #1e2a41;
      text-decoration: none;
      transition: 0.15s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.01);
    }
    .action-btn:hover {
      background: #f8fcff;
      border-color: #b6cae0;
      color: #0b1a2e;
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(0, 20, 40, 0.06);
    }
    .action-btn i { font-size: 1.2rem; color: #3a5a7a; }
    .table-modern { border-collapse: separate; border-spacing: 0 6px; width: 100%; }
    .table-modern thead th {
      background: #eef3fa;
      color: #1b2a40;
      font-weight: 600;
      font-size: 0.7rem;
      letter-spacing: 0.03em;
      text-transform: uppercase;
      padding: 0.7rem 0.7rem;
      border: none;
      border-radius: 0;
      white-space: nowrap;
    }
    .table-modern thead th:first-child { border-radius: 16px 0 0 16px; }
    .table-modern thead th:last-child { border-radius: 0 16px 16px 0; }
    .table-modern tbody tr {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.01);
      transition: 0.1s ease;
    }
    .table-modern tbody td {
      padding: 0.75rem 0.7rem;
      border: none;
      background: #fbfdff;
      border-bottom: 1px solid #eef3f8;
      font-weight: 450;
      color: #1f3145;
      vertical-align: middle;
      font-size: 0.85rem;
    }
    .table-modern tbody tr:last-child td { border-bottom: none; }
    .table-modern tbody td:first-child { border-radius: 12px 0 0 12px; }
    .table-modern tbody td:last-child { border-radius: 0 12px 12px 0; }
    .status-badge {
      padding: 0.2rem 0.9rem;
      border-radius: 40px;
      font-weight: 500;
      font-size: 0.7rem;
      text-transform: capitalize;
      display: inline-block;
    }
    .status-badge.waiting { background: #fff3cd; color: #856404; }
    .status-badge.pending { background: #cfe2ff; color: #084298; }
    .status-badge.done { background: #d4edda; color: #155724; }
    .status-badge.cancelled { background: #f8d7da; color: #721c24; }
    .section-title { font-weight: 600; color: #1b2a40; letter-spacing: -0.01em; }
    .footer-light {
      background: transparent;
      border-top: 1px solid #dee7ef;
      padding: 1.5rem 0;
      margin-top: 2.5rem;
      color: #4a617c;
    }
    .kp-booking-count {
      background: rgba(255,255,255,0.12);
      padding: 0.3rem 1.2rem;
      border-radius: 40px;
      font-size: 0.85rem;
    }
    .request-card {
      background: #f8fafc;
      border-radius: 16px;
      padding: 1rem 1.2rem;
      border-left: 4px solid #2a3b5c;
      margin-bottom: 1rem;
      transition: all 0.2s ease;
    }
    .request-card:hover { background: #f0f4fa; }
    .request-card.active-job { border-left-color: #2a7ae2; }
    .request-card .client-name { font-weight: 600; color: #1b2a40; }
    .request-card .service-detail { color: #4a617c; font-size: 0.85rem; }
    .btn-accept {
      background: #d4edda;
      color: #155724;
      border: none;
      border-radius: 40px;
      padding: 0.35rem 1.2rem;
      font-weight: 500;
      font-size: 0.78rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      transition: 0.15s ease;
    }
    .btn-accept:hover { background: #c3e6cb; }
    .btn-decline {
      background: #f8d7da;
      color: #721c24;
      border: none;
      border-radius: 40px;
      padding: 0.35rem 1.2rem;
      font-weight: 500;
      font-size: 0.78rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      transition: 0.15s ease;
    }
    .btn-decline:hover { background: #f5c6cb; }
    .feedback-alert { border-radius: 16px; border: none; padding: 0.8rem 1.2rem; }
    .stat-card-mini { background: #ffffff; border-radius: 16px; padding: 0.8rem 1.2rem; text-align: center; }
    .stat-card-mini .number { font-size: 1.5rem; font-weight: 700; color: #1b2a40; }
    .stat-card-mini .label { font-size: 0.7rem; text-transform: uppercase; color: #4a617c; letter-spacing: 0.03em; }
    @media (max-width: 768px) {
      .profile-card img { width: 150px; height: 150px; }
      .banner-modern h1 { font-size: 1.8rem; }
      .table-modern thead th, .table-modern tbody td { padding: 0.4rem 0.4rem; font-size: 0.7rem; }
      .request-card { padding: 0.8rem; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar -->
  <?php include_once "partials/navbar.php"; ?>

  <!-- Banner -->
  <div class="banner-modern">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1 class="display-6 fw-bold"><?php echo strtoupper($record["keeper_fname"] ?? 'Keeper'); ?>, Track Bookings</h1>
        <p class="lead fs-6">Monitor & manage your booking requests</p>
        <?php require_once "partials/feedback.php"; ?>
      </div>
      <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <span class="kp-booking-count">
          <i class="bi bi-calendar-check me-1"></i> <?php echo count($bookings); ?> bookings
        </span>
      </div>
    </div>
  </div>

  <!-- Feedback Message -->
  <?php if(isset($_SESSION['feedback'])): ?>
    <div class="feedback-alert alert alert-<?php echo $_SESSION['feedback_type'] ?? 'info'; ?> alert-dismissible fade show" role="alert">
      <i class="bi bi-info-circle me-2"></i><?php echo $_SESSION['feedback']; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['feedback']); unset($_SESSION['feedback_type']); ?>
  <?php endif; ?>

  <!-- Stats Row -->
  <div class="row g-3 mb-4">
    <div class="col-3">
      <div class="stat-card-mini">
        <div class="number"><?php echo $stats['total'] ?? 0; ?></div>
        <div class="label">Total</div>
      </div>
    </div>
    <div class="col-3">
      <div class="stat-card-mini">
        <div class="number" style="color:#856404;"><?php echo $stats['waiting'] ?? $waiting_count; ?></div>
        <div class="label">Waiting</div>
      </div>
    </div>
    <div class="col-3">
      <div class="stat-card-mini">
        <div class="number" style="color:#084298;"><?php echo $stats['pending'] ?? $active_count; ?></div>
        <div class="label">Active</div>
      </div>
    </div>
    <div class="col-3">
      <div class="stat-card-mini">
        <div class="number" style="color:#155724;"><?php echo $stats['done'] ?? ($stats['completed'] ?? 0); ?></div>
        <div class="label">Done</div>
      </div>
    </div>
  </div>

  <!-- Main row -->
  <div class="row g-4">

    <!-- LEFT: profile card -->
    <div class="col-lg-3 col-md-4">
      <div class="profile-card">
        <img src="uploads/<?php echo $record["kp_img"] ?? 'default.jpg'; ?>" alt="Profile Picture">
        <h3><?php echo strtoupper($record["keeper_fname"] ?? 'First') . " " . strtoupper($record["keeper_lname"] ?? 'Last'); ?></h3>
        <div class="badge-soft mb-2"><i class="bi bi-person-badge"></i> Keeper</div>
        <div class="info-grid">
          <?php if(isset($show["state_name"])){ ?>
            <span class="badge-soft"><i class="bi bi-geo-alt"></i> <?php echo ucwords($show["state_name"]); ?></span>
            <span class="badge-soft"><i class="bi bi-pin"></i> <?php echo ucwords($show["lga_name"]); ?></span>
          <?php } ?>
          <span class="badge-soft"><i class="bi bi-telephone"></i> <?php echo $record["kp_phone"] ?? 'N/A'; ?></span>
        </div>
        <hr class="my-3 opacity-25">
        <div class="d-flex justify-content-center gap-2 flex-wrap">
          <a href="edit_keeperprofile.php" class="action-btn" style="background:#f2f6fc;"><i class="bi bi-pencil-square"></i> Edit Profile</a>
          <a href="add_kp_services.php" class="action-btn"><i class="bi bi-plus-circle"></i> Add Service</a>
        </div>
      </div>
    </div>

    <!-- RIGHT: content area -->
    <div class="col-lg-9 col-md-8">

      <!-- Action cards -->
      <div class="card-modern p-3 p-md-4 mb-4">
        <div class="action-grid">
          <a href="edit_keeperprofile.php" class="action-btn"><i class="bi bi-pencil-square"></i> Edit Profile</a>
          <a href="add_kp_services.php" class="action-btn"><i class="bi bi-plus-circle"></i> Add Service</a>
          <a href="kp_track_status.php" class="action-btn"><i class="bi bi-clock-history"></i> Track Status</a>
          <a href="kp_service_rec.php" class="action-btn"><i class="bi bi-list-ul"></i> Service History</a>
        </div>
      </div>

      <!-- NEW REQUESTS (status = waiting) -->
      <div class="card-modern p-3 p-md-4 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="section-title mb-0"><i class="bi bi-clock-history me-2" style="color:#f5b342;"></i>New Requests</h5>
          <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-normal">
            <?php echo $waiting_count; ?> waiting
          </span>
        </div>

        <?php
          $waiting_bookings = array_filter($bookings, function($b) {
            return strtolower($b['status'] ?? '') == 'waiting';
          });
        ?>

        <?php if(!empty($waiting_bookings)): ?>
          <?php foreach($waiting_bookings as $b): ?>
            <div class="request-card">
              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="client-name">
                    <i class="bi bi-person-circle me-2"></i>
                    <?php echo htmlspecialchars($b['client_fname'] ?? 'N/A') . ' ' . htmlspecialchars($b['client_lname'] ?? ''); ?>
                  </div>
                  <div class="service-detail">
                    <i class="bi bi-telephone me-1"></i> <?php echo htmlspecialchars($b['cl_phone'] ?? 'N/A'); ?>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="service-detail">
                    <i class="bi bi-tag me-1"></i> <?php echo htmlspecialchars($b['service_categories_name'] ?? '—'); ?>
                  </div>
                  <div class="service-detail">
                    <i class="bi bi-clock me-1"></i> <?php echo htmlspecialchars($b['plan_name'] ?? '—'); ?>
                  </div>
                  <div class="service-detail">
                    <i class="bi bi-calendar3 me-1"></i> <?php echo htmlspecialchars($b['service_date'] ?? '—'); ?> at <?php echo htmlspecialchars($b['service_time'] ?? '—'); ?>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="service-detail">
                    <i class="bi bi-geo-alt me-1"></i> <?php echo htmlspecialchars(substr($b['service_address'] ?? '', 0, 25)) . (strlen($b['service_address'] ?? '') > 25 ? '...' : ''); ?>
                  </div>
                  <div class="mt-2 d-flex flex-wrap gap-2">
                    <form action="" method="post" class="d-inline">
                      <input type="hidden" name="service_id" value="<?php echo $b['service_id']; ?>">
                      <input type="hidden" name="status" value="pending">
                      <button type="submit" name="update_booking_status" class="btn-accept" onclick="return confirm('Accept this booking request?');">
                        <i class="bi bi-check-circle"></i> Accept
                      </button>
                    </form>
                    <form action="" method="post" class="d-inline">
                      <input type="hidden" name="service_id" value="<?php echo $b['service_id']; ?>">
                      <input type="hidden" name="status" value="cancelled">
                      <button type="submit" name="update_booking_status" class="btn-decline" onclick="return confirm('Decline this booking request?');">
                        <i class="bi bi-x-circle"></i> Decline
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="text-center text-muted py-4">
            <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
            No new requests — you're all caught up!
          </div>
        <?php endif; ?>
      </div>

      <!-- ACTIVE JOBS (status = pending) -->
      <div class="card-modern p-3 p-md-4 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="section-title mb-0"><i class="bi bi-play-circle me-2" style="color:#2a7ae2;"></i>Active Jobs</h5>
          <span class="badge bg-primary rounded-pill px-3 py-2 fw-normal">
            <?php echo $active_count; ?> in progress
          </span>
        </div>

        <?php
          $active_bookings = array_filter($bookings, function($b) {
            return strtolower($b['status'] ?? '') == 'pending';
          });
        ?>

        <?php if(!empty($active_bookings)): ?>
          <?php foreach($active_bookings as $b): ?>
            <div class="request-card active-job">
              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="client-name">
                    <i class="bi bi-person-circle me-2"></i>
                    <?php echo htmlspecialchars($b['client_fname'] ?? 'N/A') . ' ' . htmlspecialchars($b['client_lname'] ?? ''); ?>
                  </div>
                  <div class="service-detail">
                    <i class="bi bi-telephone me-1"></i> <?php echo htmlspecialchars($b['cl_phone'] ?? 'N/A'); ?>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="service-detail">
                    <i class="bi bi-tag me-1"></i> <?php echo htmlspecialchars($b['service_categories_name'] ?? '—'); ?>
                  </div>
                  <div class="service-detail">
                    <i class="bi bi-calendar3 me-1"></i> <?php echo htmlspecialchars($b['service_date'] ?? '—'); ?> at <?php echo htmlspecialchars($b['service_time'] ?? '—'); ?>
                  </div>
                </div>
                <div class="col-md-4 text-md-end">
                  <form action="" method="post" class="d-inline">
                    <input type="hidden" name="service_id" value="<?php echo $b['service_id']; ?>">
                    <input type="hidden" name="status" value="done">
                    <button type="submit" name="update_booking_status" class="btn-accept" onclick="return confirm('Mark this job as done?');">
                      <i class="bi bi-check2-all"></i> Mark as Done
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="text-center text-muted py-4">
            No active jobs right now.
          </div>
        <?php endif; ?>
      </div>

      <!-- ALL BOOKINGS TABLE -->
      <div class="card-modern p-3 p-md-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="section-title mb-0"><i class="bi bi-table me-2" style="color:#2a3b5c;"></i>All Bookings</h5>
          <span class="badge bg-light text-secondary rounded-pill px-3 py-2 fw-normal">
            <i class="bi bi-calendar-week me-1"></i> <?php echo count($bookings); ?> total
          </span>
        </div>

        <div class="table-responsive">
          <table class="table-modern">
            <thead>
              <tr>
                <th>#</th>
                <th>Client</th>
                <th>Service</th>
                <th>Plan</th>
                <th>Appointment</th>
                <th>Address</th>
                <th>Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($bookings)): ?>
                <?php $sn = 1; foreach($bookings as $b): ?>
                <?php $status = strtolower($b['status'] ?? 'waiting'); ?>
                <tr>
                  <td><span class="fw-bold text-secondary"><?php echo $sn++; ?></span></td>
                  <td>
                    <span class="fw-medium"><?php echo htmlspecialchars($b['client_fname'] ?? 'N/A'); ?> <?php echo htmlspecialchars($b['client_lname'] ?? ''); ?></span>
                  </td>
                  <td><span class="fw-medium"><?php echo htmlspecialchars($b['service_categories_name'] ?? '—'); ?></span></td>
                  <td><span class="fw-medium"><?php echo htmlspecialchars($b['plan_name'] ?? '—'); ?></span></td>
                  <td>
                    <span class="fw-medium">
                      <i class="bi bi-calendar3 me-1 text-secondary"></i><?php echo htmlspecialchars($b['service_date'] ?? '—'); ?>
                      <br><span class="text-muted small"><i class="bi bi-clock me-1"></i><?php echo htmlspecialchars($b['service_time'] ?? '—'); ?></span>
                    </span>
                  </td>
                  <td><span class="small"><?php echo htmlspecialchars(substr($b['service_address'] ?? '', 0, 20)) . (strlen($b['service_address'] ?? '') > 20 ? '...' : ''); ?></span></td>
                  <td>
                    <span class="status-badge <?php echo $status; ?>"><?php echo ucfirst($status); ?></span>
                  </td>
                  <td class="text-center">
                    <?php if($status == 'waiting'): ?>
                      <div class="d-flex flex-wrap gap-1 justify-content-center">
                        <form action="" method="post" class="d-inline">
                          <input type="hidden" name="service_id" value="<?php echo $b['service_id']; ?>">
                          <input type="hidden" name="status" value="pending">
                          <button type="submit" name="update_booking_status" class="btn-accept btn-sm" style="padding:0.2rem 0.8rem; font-size:0.7rem;" onclick="return confirm('Accept this booking request?');">
                            <i class="bi bi-check-circle"></i>
                          </button>
                        </form>
                        <form action="" method="post" class="d-inline">
                          <input type="hidden" name="service_id" value="<?php echo $b['service_id']; ?>">
                          <input type="hidden" name="status" value="cancelled">
                          <button type="submit" name="update_booking_status" class="btn-decline btn-sm" style="padding:0.2rem 0.8rem; font-size:0.7rem;" onclick="return confirm('Decline this booking request?');">
                            <i class="bi bi-x-circle"></i>
                          </button>
                        </form>
                      </div>
                    <?php elseif($status == 'pending'): ?>
                      <form action="" method="post" class="d-inline">
                        <input type="hidden" name="service_id" value="<?php echo $b['service_id']; ?>">
                        <input type="hidden" name="status" value="done">
                        <button type="submit" name="update_booking_status" class="btn-accept btn-sm" style="padding:0.2rem 0.8rem; font-size:0.7rem;" onclick="return confirm('Mark this job as done?');">
                          <i class="bi bi-check2-all"></i> Done
                        </button>
                      </form>
                    <?php elseif($status == 'done'): ?>
                      <span class="text-muted small"><i class="bi bi-check2-all"></i> Completed</span>
                    <?php elseif($status == 'cancelled'): ?>
                      <span class="text-muted small"><i class="bi bi-x-lg"></i> Cancelled</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center text-muted py-4">
                    <i class="bi bi-inbox me-2" style="font-size: 1.5rem;"></i><br>No bookings found yet.
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <!-- footer -->
  <?php require_once "partials/footer.php"; ?>

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
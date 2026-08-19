<?php
session_start();
 require_once "userguard.php";

require_once "classes/Client.php";
$cl = new Client;

$record = $cl->get_client_byid($_SESSION["useronline"]);
$show = $cl->show_origin($_SESSION["useronline"]);
$bookings = $cl->fetch_client_bookings($_SESSION["useronline"]); 

// var_dump($show);
// die();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Profile · Modern</title>
  <!-- Bootstrap 5 + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Google Font (Inter) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <style>
    * {
      font-family: 'Inter', sans-serif;
    }
    body {
      background: #f2f5f9;
      margin: 0;
      padding: 0;
    }
    /* soft shadow & rounded corners */
    .card-modern {
      background: #ffffff;
      border: none;
      border-radius: 24px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.04), 0 4px 10px rgba(0, 0, 0, 0.02);
      transition: all 0.2s ease;
    }
    .card-modern:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
    }
    .profile-banner {
      background: linear-gradient(145deg, #1a2639, #2a3b5c);
      padding: 2.5rem 1.5rem;
      border-radius: 0 0 40px 40px;
      margin-bottom: 2rem;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .profile-banner::after {
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
    .profile-banner h1 {
      font-weight: 700;
      letter-spacing: -0.02em;
    }
    .profile-banner p {
      opacity: 0.8;
      font-weight: 400;
      margin-bottom: 0.25rem;
    }
    .profile-card {
      background: #ffffff;
      border-radius: 28px;
      padding: 2rem 1.5rem;
      text-align: center;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03);
      border: 1px solid rgba(255,255,255,0.5);
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
    .profile-card h3 {
      font-weight: 700;
      color: #1e2a41;
      letter-spacing: -0.01em;
      margin-top: 0.2rem;
    }
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
    .badge-soft i {
      margin-right: 6px;
      color: #3a5a7a;
    }
    .info-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 8px 12px;
      margin-top: 0.5rem;
    }
    .info-grid .badge-soft {
      margin: 0;
    }
    .action-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 12px;
    }
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
    .action-btn i {
      font-size: 1.2rem;
      color: #3a5a7a;
    }
    .table-modern {
      border-collapse: separate;
      border-spacing: 0 6px;
      width: 100%;
    }
    .table-modern thead th {
      background: transparent;
      color: #3f5570;
      font-weight: 600;
      font-size: 0.8rem;
      letter-spacing: 0.03em;
      text-transform: uppercase;
      padding: 0.6rem 0.8rem;
      border: none;
    }
    .table-modern tbody tr {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.01);
      transition: 0.1s ease;
    }
    .table-modern tbody td {
      padding: 0.9rem 0.8rem;
      border: none;
      background: #fbfdff;
      border-bottom: 1px solid #eef3f8;
      font-weight: 500;
      color: #1f3145;
    }
    .table-modern tbody tr:last-child td {
      border-bottom: none;
    }
    .table-modern tbody td:first-child {
      border-radius: 12px 0 0 12px;
    }
    .table-modern tbody td:last-child {
      border-radius: 0 12px 12px 0;
    }
    .service-badge {
      background: #e6edf6;
      padding: 0.25rem 1rem;
      border-radius: 30px;
      font-weight: 500;
      font-size: 0.8rem;
      color: #1f3a5e;
      display: inline-block;
    }
    .section-title {
      font-weight: 600;
      color: #1b2a40;
      letter-spacing: -0.01em;
      margin-bottom: 0.5rem;
    }
    .footer-light {
      background: transparent;
      border-top: 1px solid #dee7ef;
      padding: 1.5rem 0;
      margin-top: 3rem;
      color: #4a617c;
    }
    /* remove extra duplicate row (kept for structure) */
    .duplicate-actions {
      display: none;
    }
    @media (max-width: 768px) {
      .profile-card img {
        width: 150px;
        height: 150px;
      }
      .profile-banner h1 {
        font-size: 1.8rem;
      }
    }
     .status-badge.pending { background: #fff3cd; color: #856404; }
    .status-badge.confirmed { background: #cce5ff; color: #004085; }
    .status-badge.completed { background: #d4edda; color: #155724; }
    .status-badge.cancelled { background: #f8d7da; color: #721c24; }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- navbar partial  -->
  <?php  include_once "partials/navbar.php"; ?>


  <!-- Profile Banner -->
  <div class="profile-banner">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1 class="fw-bold display-6">Welcome, <?php echo $record["client_fname"] ?? 'Client'; ?>!</h1>
        <p class="lead fs-6">Your personal dashboard · manage services &amp; history</p>
        <?php require_once "partials/feedback.php";  ?>
      </div>
      <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <span class="badge bg-white text-dark bg-opacity-15 px-4 py-2 rounded-pill fw-normal">
          <i class="bi bi-shield-check me-1"></i> client
        </span>
      </div>
    </div>
  </div>

  <!-- Main row: profile + info + table -->
  <div class="row g-4">

    <!-- LEFT: profile card -->
    <div class="col-lg-3 col-md-4">
      <div class="profile-card">
        <img src="uploads/<?php echo $record["cl_img_url"] ?? 'default.jpg'; ?>" alt="Profile Picture">
        <h3><?php echo $record["client_fname"] ?? 'First'; ?> <?php echo $record["client_lname"] ?? 'Last'; ?></h3>
        <div class="badge-soft mb-2"><i class="bi bi-person-badge"></i> Client</div>
        
        <div class="info-grid">
          <?php if(isset($show["state_name"])){ ?>
            <span class="badge-soft"><i class="bi bi-geo-alt"></i> <?php echo strtoupper($show["state_name"]); ?></span>
            <span class="badge-soft"><i class="bi bi-pin"></i> <?php echo strtoupper($show["lga_name"]); ?></span>
          <?php } ?>
          <span class="badge-soft"><i class="bi bi-telephone"></i> <?php echo $record["cl_phone"] ?? 'N/A'; ?></span>
        </div>
        <hr class="my-3 opacity-25">
        <div class="d-flex justify-content-center gap-2 flex-wrap">
          <!-- <a href="chat.php" class="action-btn" style="background:#f2f6fc;"><i class="bi bi-envelope"></i> Message</a> -->
          <a href="cl_track_status.php" class="action-btn"><i class="bi bi-calendar3"></i> Schedule</a>
        </div>
      </div>
    </div>

    <!-- RIGHT: actions + table -->
    <div class="col-lg-9 col-md-8">
      <!-- action cards (modern) -->
      <div class="card-modern p-3 p-md-4 mb-4">
        <div class="action-grid">
          <a href="edit_clientprofile.php" class="action-btn"><i class="bi bi-pencil-square"></i> Edit Profile</a>
          <a href="select_service.php" class="action-btn"><i class="bi bi-plus-circle"></i> Book a Service</a>
          <a href="cl_track_status.php" class="action-btn"><i class="bi bi-clock-history"></i> Track Status</a>
          <a href="cl_service_rec.php" class="action-btn"><i class="bi bi-list-ul"></i> Service History</a>
        </div>
      </div>

      <!-- table card: services & plans -->
      <div class="card-modern p-3 p-md-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h5 class="section-title mb-0"><i class="bi bi-grid-3x3-gap-fill me-2" style="color:#2a3b5c;"></i>Recent Booking</h5>
          <span class="badge bg-light text-secondary rounded-pill px-3 py-2 fw-normal">last 30 days</span>
        </div>
        <div class="table-responsive">
          <table class="table-modern">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Service</th>
                <th scope="col">Plan</th>
                <th scope="col" class="text-end">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $count = 1; foreach($bookings as $book):   ?>
              <tr>
                <td><span class="fw-bold text-secondary"><?php echo $count++ ?></span></td>
                <td><span class="service-badge"><i class="bi bi-droplet me-1"></i> <?php echo $book["service_categories_name"]; ?></span></td>
                <td><span class="fw-medium"><?php echo $book["plan_name"];  ?></span></td>
                <td>
                  <?php 
                    $status = strtolower($book["status"] ?? 'pending');
                    $class = 'pending';
                    if($status == 'confirmed' || $status == 'approved') $class = 'confirmed';
                    else if($status == 'completed' || $status == 'done') $class = 'completed';
                    else if($status == 'cancelled' || $status == 'canceled') $class = 'cancelled';
                  ?>
                  <span class="status-badge <?php echo $class; ?>"><?php echo ucfirst($status); ?></span>
                </td>
              </tr>
              <?php  endforeach;   ?>
               <?php if(empty($bookings)) { ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-4">
                  <i class="bi bi-inbox me-2"></i>No bookings found yet.
                </td>
              </tr>
              <?php } ?>
              <!-- you can add more rows dynamically -->
            </tbody>
          </table>
        </div>
        <div class="text-end mt-2">
          <a href="#" class="text-decoration-none small fw-medium" style="color:#2f4b73;">View all <i class="bi bi-chevron-right"></i></a>
        </div>
      </div>
    </div>
  </div>

  <!-- hidden duplicate actions (original markup kept but hidden) -->
  <div class="duplicate-actions">
    <div class="row my-5 justify-content-center">
      <div class="col-md-2"><div class="card action-card"><div class="card-body text-center"><a href="edit_clientprofile.php" class="card-link fw-bold">Edit Profile</a></div></div></div>
      <div class="col-md-2"><div class="card action-card"><div class="card-body text-center"><a href="select_service.php" class="card-link fw-bold">Book a Service</a></div></div></div>
      <div class="col-md-2"><div class="card action-card"><div class="card-body text-center"><a href="#" class="card-link fw-bold">Track Status</a></div></div></div>
      <div class="col-md-2"><div class="card action-card"><div class="card-body text-center"><a href="cl_service_rec.php" class="card-link fw-bold">Service History</a></div></div></div>
    </div>
  </div>

  <!-- footer partial -->
  <?php require_once "partials/footer.php"; ?>
 

</div> <!-- container-fluid -->

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
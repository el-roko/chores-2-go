<?php
session_start();
require_once "classes/Service.php";

  $keeper_id = $_GET["keeper_id"];
   $service_cate_id = $_SESSION['cate_id'];
   $service_plan_id = $_SESSION['plan_id'];
   $client_id = $_SESSION['useronline'];

    $s = new Service;
    $cate = $s->fetch_services($service_cate_id);
    $plan = $s->fetch_service_plan($service_plan_id);
      $planName = $s->get_service_plan_name($service_plan_id);
      $cateName = $s->get_service_category_name($service_cate_id);

    //  var_dump($cateName);
    //  die();

    

        if(isset($_GET["keeper_id"])) {
            $keeper_id = $_GET["keeper_id"];
         } 
     
   
//     echo "<pre>";
// echo "Service Category ID: " . $service_cate_id . "\n";
// echo "Service Plan ID: " . $service_plan_id . "\n";
// echo "Keeper ID: " . $keeper_id . "\n";
// echo "Client ID: " . $client_id . "\n";
// echo "</pre>";
// die;
   
   


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book a Service · Chores-2-Go</title>
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
      margin-bottom: 2.5rem;
      color: white;
      position: relative;
      overflow: hidden;
      text-align: center;
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
    .banner-modern h1 {
      font-weight: 700;
      letter-spacing: -0.02em;
    }
    .banner-modern p {
      opacity: 0.85;
      font-weight: 400;
    }
    .card-modern {
      background: #ffffff;
      border: none;
      border-radius: 28px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03), 0 4px 12px rgba(0, 0, 0, 0.02);
      padding: 2.5rem 2.5rem;
      max-width: 620px;
      margin: 0 auto 2rem;
      transition: all 0.2s ease;
    }
    .card-modern:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }
    .form-label {
      font-weight: 500;
      color: #1e2a41;
      font-size: 0.9rem;
      margin-bottom: 0.3rem;
    }
    .form-control, .form-select {
      border: 1px solid #e4eaf2;
      border-radius: 16px;
      padding: 0.7rem 1rem;
      font-size: 0.95rem;
      background: #fafcff;
      transition: 0.15s ease;
      box-shadow: none;
    }
    .form-control:focus, .form-select:focus {
      border-color: #2a3b5c;
      box-shadow: 0 0 0 4px rgba(42, 59, 92, 0.08);
      background: white;
    }
    textarea.form-control {
      border-radius: 16px;
      resize: vertical;
      min-height: 80px;
    }
    .btn-primary-modern {
      background: #1a2639;
      border: none;
      border-radius: 40px;
      padding: 0.85rem 2rem;
      font-weight: 600;
      color: white;
      transition: 0.15s ease;
      letter-spacing: 0.01em;
      width: 100%;
    }
    .btn-primary-modern:hover {
      background: #2a3b5c;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(26, 38, 57, 0.15);
      color: white;
    }
    .badge-soft {
      background: #eef3fa;
      color: #1e2a41;
      font-weight: 500;
      padding: 0.3rem 1.2rem;
      border-radius: 40px;
      font-size: 0.8rem;
    }
    .footer-light {
      background: transparent;
      border-top: 1px solid #dee7ef;
      padding: 1.5rem 0;
      margin-top: 2rem;
      color: #4a617c;
    }
    .navbar-custom {
      background: transparent;
      padding: 1rem 0;
    }
    .navbar-custom .brand {
      font-weight: 700;
      color: #1a2639;
      text-decoration: none;
      font-size: 1.3rem;
    }
    .navbar-custom .brand i {
      color: #2a3b5c;
      margin-right: 8px;
    }
    .booking-summary {
      background: #f5f8fc;
      border-radius: 16px;
      padding: 1rem 1.5rem;
      margin-bottom: 1.5rem;
      border: 1px solid #e8eef5;
    }
    .booking-summary .label {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #6f8aa5;
      font-weight: 600;
    }
    .booking-summary .value {
      font-weight: 600;
      color: #1a2639;
    }
    @media (max-width: 768px) {
      .card-modern { padding: 1.8rem 1.2rem; }
      .banner-modern { padding: 2rem 1rem; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar  -->
  <?php  include_once "partials/navbar.php"; ?>


  <!-- Banner -->
  <div class="banner-modern">
    <h1 class="display-6 fw-bold">Book a Service</h1>
    <p class="lead fs-6">Schedule your preferred service at your convenience</p>
      <?php require_once "partials/feedback.php"; ?>
  </div>

  <!-- Booking Form -->
  <div class="card-modern">
    <h3 class="text-center mb-4" style="font-weight:600; color:#1b2a40; letter-spacing:-0.01em;">
      <i class="bi bi-pencil-square me-2" style="color:#2a3b5c;"></i>Service Details
    </h3>

  

    <form action="process/process_booking.php" method="post">
      <!-- Hidden fields -->
      <div class="mb-3">
        <input type="hidden" name="keeper" value="<?php echo $keeper_id ?? ''; ?>">
        <input type="hidden" name="client" value="<?php echo $client_id ?? ''; ?>">
        <input type="hidden" name="category" value="<?php echo $service_cate_id ?? ''; ?>">
        <input type="hidden" name="plan" value="<?php echo $service_plan_id ?? ''; ?>">
      </div>

      <!-- Quick summary of selected service -->
      <div class="booking-summary">
        <div class="row g-2">
          <div class="col-6">
            <div class="label">Service Category</div>
            <div class="value"><?php echo htmlspecialchars($cateName ?? '—'); ?></div>
          </div>
          <div class="col-6">
            <div class="label">Plan</div>
            <div class="value"><?php echo htmlspecialchars($planName ?? '—'); ?></div>
          </div>
        </div>
      </div>

      <!-- Date -->
      <div class="mb-3">
        <label for="date" class="form-label"><i class="bi bi-calendar3 me-1"></i>Preferred Date</label>
        <input type="date" name="date" id="date" class="form-control" required>
      </div>

      <!-- Time -->
      <div class="mb-3">
        <label for="time" class="form-label"><i class="bi bi-clock me-1"></i>Preferred Time</label>
        <input type="time" name="time" id="time" class="form-control" required>
      </div>

      <!-- Address -->
      <div class="mb-4">
        <label for="address" class="form-label"><i class="bi bi-geo-alt me-1"></i>Service Address</label>
        <textarea name="address" id="address" class="form-control" rows="3" required placeholder="Enter full address for service delivery"></textarea>
      </div>

      <!-- Submit -->
      <div class="text-center">
        <button type="submit" class="btn btn-primary-modern" name="btn">
          <i class="bi bi-check2-circle me-2"></i>Submit Booking
        </button>
      </div>
    </form>
  </div>

  <!-- footer partial -->
  <?php include_once "partials/footer.php"; ?>
 

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
session_start();
require_once "classes/Service.php";
 require_once "userguard.php";

$ser = new Service;
$cate = $ser->fetch_service_categories();
$plan = $ser->fetch_service_plan();
// var_dump($cate);
// die();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Booking · Chores-2-Go</title>
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
      position: relative;
      background: linear-gradient(145deg, #1a2639, #2a3b5c);
      min-height: 45vh;
      border-radius: 0 0 40px 40px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
      padding: 3rem 1.5rem;
      margin-bottom: 2.5rem;
    }
    .banner-modern::after {
      content: '';
      position: absolute;
      top: -30%;
      right: -10%;
      width: 350px;
      height: 350px;
      background: rgba(255,255,255,0.02);
      border-radius: 50%;
      pointer-events: none;
    }
    .banner-modern .hero-text {
      position: relative;
      z-index: 2;
      max-width: 700px;
    }
    .banner-modern h1 {
      font-weight: 700;
      letter-spacing: -0.02em;
      font-size: 2.8rem;
    }
    .banner-modern p {
      font-size: 1.15rem;
      opacity: 0.85;
      font-weight: 400;
    }
    .card-modern {
      background: #ffffff;
      border: none;
      border-radius: 28px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03), 0 4px 12px rgba(0, 0, 0, 0.02);
      padding: 2.5rem 2.5rem;
      transition: all 0.2s ease;
    }
    .card-modern:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }
    .form-label {
      font-weight: 600;
      color: #1e2a41;
      font-size: 0.9rem;
      margin-bottom: 0.4rem;
    }
    .form-select {
      border: 1px solid #e4eaf2;
      border-radius: 16px;
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
      background: #fafcff;
      transition: 0.15s ease;
      box-shadow: none;
      cursor: pointer;
    }
    .form-select:focus {
      border-color: #2a3b5c;
      box-shadow: 0 0 0 4px rgba(42, 59, 92, 0.08);
      background: white;
    }
    .btn-primary-modern {
      background: #1a2639;
      border: none;
      border-radius: 40px;
      padding: 0.85rem 3rem;
      font-weight: 600;
      color: white;
      transition: 0.15s ease;
      letter-spacing: 0.01em;
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
      margin-top: 2.5rem;
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
    .search-icon-wrap {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    .input-group-icon {
      position: relative;
    }
    .input-group-icon .form-select {
      padding-left: 2.8rem;
    }
    .input-group-icon .icon-left {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #4a617c;
      font-size: 1.1rem;
      pointer-events: none;
    }
    @media (max-width: 768px) {
      .banner-modern { min-height: 35vh; padding: 2rem 1rem; }
      .banner-modern h1 { font-size: 2rem; }
      .card-modern { padding: 1.8rem 1.2rem; }
      .btn-primary-modern { padding: 0.75rem 2rem; width: 100%; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar  -->
  <?php  require_once "partials/navbar.php"; ?>
 

  <!-- Banner Section -->
  <div class="banner-modern">
    <div class="hero-text">
      <h1 class="fw-bold">Search for a Booking</h1>
      <p class="lead">Select your preferred category and plan to find available services</p>
      <?php require_once "partials/feedback.php"; ?>
    </div>
  </div>

  <!-- Search Form Section -->
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card-modern">
        <h3 class="text-center mb-4" style="font-weight:600; color:#1b2a40; letter-spacing:-0.01em;">
          <i class="bi bi-sliders2 me-2" style="color:#2a3b5c;"></i>Find Your Service
        </h3>

        <form action="process/process_selectkp_service.php" method="post">
          <!-- Category -->
          <div class="mb-4">
            <label for="select_cate" class="form-label"><i class="bi bi-tag me-1"></i>Select Category</label>
            <div class="input-group-icon">
              <span class="icon-left"><i class="bi bi-grid-3x3-gap-fill"></i></span>
              <select name="cate" id="select_cate" class="form-select" style="padding-left:2.8rem;">
                <?php foreach($cate as $c){ ?>
                  <option value="<?php echo $c["service_cate_id"]; ?>"><?php echo $c["service_categories_name"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- Plan -->
          <div class="mb-4">
            <label for="select_plan" class="form-label"><i class="bi bi-clock me-1"></i>Select Plan</label>
            <div class="input-group-icon">
              <span class="icon-left"><i class="bi bi-calendar2-week"></i></span>
              <select name="plan" id="select_plan" class="form-select" style="padding-left:2.8rem;">
                <?php foreach($plan as $p){ ?>
                  <option value="<?php echo $p["plan_id"]; ?>"><?php echo $p["plan_name"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <!-- Submit -->
          <div class="text-center mt-4">
            <button class="btn btn-primary-modern" name="btn">
              <i class="bi bi-search me-2"></i>Search
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once "partials/footer.php"; ?>


</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
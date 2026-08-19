<?php
require_once "guestguard.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome · Chores-2-Go</title>
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

    /* Hero Banner */
    .banner-modern {
      position: relative;
      background: linear-gradient(145deg, #1a2639, #2a3b5c);
      min-height: 65vh;
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
      width: 400px;
      height: 400px;
      background: rgba(255,255,255,0.02);
      border-radius: 50%;
      pointer-events: none;
    }
    .banner-modern .hero-text {
      position: relative;
      z-index: 2;
      max-width: 800px;
    }
    .banner-modern h1 {
      font-weight: 700;
      letter-spacing: -0.02em;
      font-size: 2.8rem;
      line-height: 1.2;
    }
    .banner-modern p {
      font-size: 1.15rem;
      opacity: 0.85;
      font-weight: 400;
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

    /* Card Modern */
    .card-modern {
      background: #ffffff;
      border: none;
      border-radius: 24px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03), 0 4px 10px rgba(0, 0, 0, 0.02);
      transition: all 0.2s ease;
      padding: 2rem;
      height: 100%;
      text-align: center;
    }
    .card-modern:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
      transform: translateY(-4px);
    }
    .card-modern .icon-circle {
      width: 64px;
      height: 64px;
      background: #eef3fa;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      color: #1a2639;
      margin: 0 auto 1rem;
    }
    .card-modern h5 {
      font-weight: 700;
      color: #1b2a40;
    }
    .card-modern p {
      color: #4a617c;
      font-size: 0.95rem;
    }
    .card-modern .link-arrow {
      color: #1a2639;
      text-decoration: none;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: 0.15s ease;
      margin-top: 0.5rem;
    }
    .card-modern .link-arrow:hover {
      color: #2a3b5c;
      gap: 10px;
    }

    .section-title {
      font-weight: 700;
      color: #1b2a40;
      letter-spacing: -0.01em;
    }
    .section-title i {
      color: #2a3b5c;
      margin-right: 0.5rem;
    }

    @media (max-width: 768px) {
      .banner-modern { min-height: 45vh; padding: 2rem 1rem; }
      .banner-modern h1 { font-size: 2rem; }
      .banner-modern p { font-size: 1rem; }
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
      <h1 class="fw-bold">Welcome to CHORES-2-GO</h1>
      <p class="lead">Your sure plug to trustworthy freelance housekeepers around you!</p>
      <?php require_once "partials/feedback.php";  ?>
    </div>
  </div>

  <!-- Welcome Section -->
  <div class="row mb-4">
    <div class="col-12 text-center">
      <h3 class="section-title"><i class="bi bi-rocket-takeoff-fill"></i>Get Started Today</h3>
      <p class="text-muted" style="font-size:1.05rem;">Join our platform and connect with reliable housekeepers ready to serve your needs.</p>
    </div>
  </div>

  <!-- Auth Cards -->
  <div class="row g-4 justify-content-center">
    <div class="col-md-5">
      <div class="card-modern">
        <div class="icon-circle"><i class="bi bi-person-plus"></i></div>
        <h5>New Here?</h5>
        <p>Join our platform to enjoy our premium services.</p>
        <a href="reg.php" class="link-arrow">Register <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card-modern">
        <div class="icon-circle"><i class="bi bi-box-arrow-in-right"></i></div>
        <h5>Already Have an Account?</h5>
        <p>Login to access your personalized dashboard and manage your services.</p>
        <a href="login.php" class="link-arrow">Login <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once "partials/footer.php"; ?>
  

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
session_start();
 require_once "userguard.php";
 require_once "classes/Client.php";

$cl = new Client;

 $reviews = $cl->fetch_reviews();

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home · Chores-2-Go</title>
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
      min-height: 70vh;
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
    .banner-modern h4 {
      font-weight: 500;
      letter-spacing: 0.05em;
      opacity: 0.85;
      font-size: 1.1rem;
      text-transform: uppercase;
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
    .btn-outline-modern {
      border: 2px solid rgba(255,255,255,0.4);
      border-radius: 60px;
      padding: 0.8rem 2.8rem;
      font-weight: 600;
      color: white;
      text-decoration: none;
      transition: 0.2s ease;
      display: inline-block;
      background: rgba(255,255,255,0.05);
    }
    .btn-outline-modern:hover {
      background: white;
      color: #1a2639;
      transform: translateY(-3px);
      box-shadow: 0 12px 28px rgba(0,0,0,0.15);
      border-color: white;
    }
    .btn-primary-modern {
      background: white;
      border: none;
      border-radius: 60px;
      padding: 0.8rem 2.8rem;
      font-weight: 600;
      color: #1a2639;
      text-decoration: none;
      transition: 0.2s ease;
      display: inline-block;
    }
    .btn-primary-modern:hover {
      background: #f0f4fa;
      transform: translateY(-3px);
      box-shadow: 0 12px 28px rgba(0,0,0,0.1);
      color: #1a2639;
    }

    /* Welcome / Cards */
    .card-modern {
      background: #ffffff;
      border: none;
      border-radius: 24px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03), 0 4px 10px rgba(0, 0, 0, 0.02);
      transition: all 0.2s ease;
      padding: 2rem;
      height: 100%;
    }
    .card-modern:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
      transform: translateY(-4px);
    }
    .card-modern .icon-circle {
      width: 60px;
      height: 60px;
      background: #eef3fa;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      color: #1a2639;
      margin: 0 auto 1rem;
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

    /* Service cards */
    .service-card {
      background: #ffffff;
      border: none;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03);
      transition: all 0.2s ease;
      height: 100%;
    }
    .service-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
    }
    .service-card .card-img-top {
      height: 200px;
      object-fit: cover;
      background: #eef3fa;
    }
    .service-card .card-body h5 {
      font-weight: 700;
      color: #1b2a40;
    }
    .service-card .card-body p {
      color: #4a617c;
      font-size: 0.95rem;
    }

    /* Carousel */
    .carousel-modern .carousel-item {
      background: #ffffff;
      border-radius: 28px;
      padding: 2.5rem 2rem;
      box-shadow: 0 12px 30px rgba(0,0,0,0.03);
      text-align: center;
    }
    .carousel-modern .carousel-item p {
      font-size: 1.2rem;
      font-weight: 500;
      color: #1b2a40;
      font-style: italic;
    }
    .carousel-modern .carousel-item small {
      color: #2a3b5c;
      font-weight: 600;
      font-size: 0.95rem;
    }
    .carousel-control-modern {
      width: 40px;
      height: 40px;
      background: white;
      border-radius: 50%;
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
      top: 50%;
      transform: translateY(-50%);
      border: 1px solid #eaf0f6;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #1a2639;
      transition: 0.15s ease;
    }
    .carousel-control-modern:hover {
      background: #f2f6fc;
      color: #1a2639;
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
      margin-top: 3rem;
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
    .welc {
      animation: fadeInUp 0.8s ease forwards;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 768px) {
      .banner-modern { min-height: 50vh; padding: 2rem 1rem; }
      .banner-modern h1 { font-size: 2rem; }
      .banner-modern p { font-size: 1rem; }
      .service-card .card-img-top { height: 160px; }
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
      <h4 class="fw-bold">Welcome to CHORES-2-GO</h4>
      <h1 class="py-3 px-2">Too busy to tidy your space?<br><span style="color:#b6cae0;">No problem, we’ve got you covered</span></h1>
      <p>Let’s clean your space</p>
      <a class="btn btn-primary-modern mt-3" href="select_service.php">BOOK NOW <i class="bi bi-arrow-right ms-2"></i></a>
      <?php require_once "partials/feedback.php";   ?>
    </div>
  </div>

  <!-- Welcome Section -->
  <div class="row g-4 mt-2">
    <div class="col-md-6">
      <div class="card-modern text-center">
        <div class="icon-circle"><i class="bi bi-hand-thumbs-up"></i></div>
        <h3 class="fw-bolder" style="color:#1b2a40;">Welcome to CHORES-2-GO</h3>
        <p class="mt-3" style="color:#4a617c;">At CHORES-2-GO we understand time is precious, and that’s why we’re dedicated to serving your needs exactly when you need us.</p>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card-modern text-center">
        <div class="icon-circle"><i class="bi bi-stars"></i></div>
        <h3 class="fw-bolder" style="color:#1b2a40;">A Trial Will Convince You</h3>
        <p class="mt-3" style="color:#4a617c;">Are you a corporate worker, professional, or someone with limited time for chores? No worries — CHORES-2-GO has you covered.</p>
      </div>
    </div>
  </div>

  <!-- Service Cards -->
  <div class="row g-4 mt-3">
    <div class="col-md-4">
      <div class="service-card">
        <img src="assets/img/ban.jpg" class="card-img-top" alt="Cleaning">
        <div class="card-body text-center">
          <h5 class="fw-bold">Home Cleaning</h5>
          <p>Professional cleaning tailored to your schedule.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="service-card">
        <img src="assets/img/dry.jpg" class="card-img-top" alt="Laundry">
        <div class="card-body text-center">
          <h5 class="fw-bold">Laundry &amp; Ironing</h5>
          <p>Fresh clothes delivered right to your door.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="service-card">
        <img src="assets/img/veg.jpg" class="card-img-top" alt="Grocery">
        <div class="card-body text-center">
          <h5 class="fw-bold">Grocery Shopping</h5>
          <p>Save time with our reliable shopping service.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA -->
  <div class="row mt-4">
    <div class="col-12 text-center">
      <div class="card-modern" style="background: #eef3fa; padding: 2.5rem 1.5rem;">
        <h3 class="fw-bolder" style="color:#1b2a40;">Book us today for any of our services</h3>
        <a href="book_service.php" class="btn btn-primary-modern mt-3" style="background:#1a2639; color:white;">Get Started <i class="bi bi-arrow-right ms-2"></i></a>
      </div>
    </div>
  </div>

  <!-- Reviews Carousel -->
  <div class="row mt-5">
    <div class="col-12 text-center">
      <h3 class="section-title mb-4"><i class="bi bi-chat-quote-fill"></i>What Our Clients Say</h3>
    </div>
    <div class="col-lg-8 offset-lg-2">
      <div id="reviewCarousel" class="carousel slide carousel-modern" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php $first = true; 
        foreach($reviews["reviews"] as $rev): ?>
          <div class="carousel-item <?php echo $first ? 'active' : ''; ?> text-center">
            <p><?php echo $rev["messages"]; ?></p>
            <small>— <?php echo $rev["client_fname"]." ".$rev["client_lname"]; ?></small>
          </div>
        <?php $first = false; endforeach; ?>
      </div>

        <button class="carousel-control-prev carousel-control-modern" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev" style="position:absolute; left:-20px;">
          <i class="bi bi-chevron-left"></i>
        </button>
        <button class="carousel-control-next carousel-control-modern" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next" style="position:absolute; right:-20px;">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once "partials/footer.php"; ?>


</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
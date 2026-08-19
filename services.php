<?php
session_start();
    require_once "classes/Service.php";
     require_once "userguard.php";

    $s = new Service;
    $cate = $s->fetch_services();
  


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Available Services · Chores-2-Go</title>
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
      border-radius: 24px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03), 0 4px 10px rgba(0, 0, 0, 0.02);
      transition: all 0.25s ease;
      overflow: hidden;
      height: 100%;
      padding: 1.8rem 1.5rem;
      text-align: center;
    }
    .card-modern:hover {
      transform: translateY(-6px);
      box-shadow: 0 24px 48px rgba(0, 0, 0, 0.06);
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
    .card-modern .card-title {
      font-weight: 700;
      color: #1b2a40;
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
    }
    .card-modern .card-text {
      color: #4a617c;
      font-size: 0.95rem;
      line-height: 1.6;
      margin-bottom: 0;
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
    .section-title {
      font-weight: 600;
      color: #1b2a40;
      letter-spacing: -0.01em;
    }
    .service-count {
      background: #f5f8fc;
      border-radius: 40px;
      padding: 0.3rem 1.5rem;
      font-size: 0.85rem;
      color: #4a617c;
    }
    @media (max-width: 768px) {
      .banner-modern { padding: 2rem 1rem; }
      .card-modern { padding: 1.5rem 1rem; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar  -->
  <?php  require_once "partials/navbar.php"; ?>


  <!-- Banner -->
  <div class="banner-modern">
    <h1 class="display-6 fw-bold">Available Services</h1>
    <p class="lead fs-6">Choose from our trusted housekeeping services</p>
  </div>

  <!-- Service Cards -->
  <div class="row g-4 justify-content-center">
    <?php foreach($cate as $cat){ ?>
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card-modern">
          <div class="icon-circle">
            <i class="bi bi-tools"></i>
          </div>
          <h5 class="card-title">
            <?php echo $cat["service_categories_name"]; ?>
          </h5>
          <p class="card-text">
            <?php echo $cat["service_description"]; ?>
          </p>
          <div class="mt-2">
            <span class="badge bg-light text-secondary rounded-pill px-3 py-1 fw-normal">
              <i class="bi bi-check-circle-fill text-success me-1" style="font-size:0.7rem;"></i> available
            </span>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Footer -->
  <?php require_once "partials/footer.php"; ?>
  <div class="footer-light text-center small">
    <span class="text-secondary">&copy; 2026 · Chores-2-Go · services</span>
  </div>

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
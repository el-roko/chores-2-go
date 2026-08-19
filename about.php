<?php
session_start();
 require_once "userguard.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us · Chores-2-Go</title>
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
    .about-banner {
      background: linear-gradient(145deg, #1a2639, #2a3b5c);
      padding: 3.5rem 1.5rem;
      border-radius: 0 0 40px 40px;
      margin-bottom: 2.5rem;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .about-banner::after {
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
    .about-banner h1 {
      font-weight: 700;
      letter-spacing: -0.02em;
    }
    .about-banner p {
      opacity: 0.85;
      font-weight: 400;
    }
    .card-modern {
      background: #ffffff;
      border: none;
      border-radius: 24px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03), 0 4px 10px rgba(0, 0, 0, 0.02);
      padding: 2rem 2rem;
      margin-bottom: 2rem;
      transition: all 0.2s ease;
    }
    .card-modern:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }
    .section-title {
      font-weight: 700;
      color: #1b2a40;
      letter-spacing: -0.01em;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .section-title i {
      color: #2a3b5c;
      font-size: 1.6rem;
    }
    .icon-feature {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 48px;
      height: 48px;
      background: #eef3fa;
      border-radius: 16px;
      color: #1a2639;
      font-size: 1.4rem;
      margin-right: 0.75rem;
      flex-shrink: 0;
    }
    .feature-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .feature-list li {
      display: flex;
      align-items: center;
      padding: 0.5rem 0;
      font-weight: 450;
      color: #1f3145;
      border-bottom: 1px solid #f0f4fa;
    }
    .feature-list li:last-child {
      border-bottom: none;
    }
    .feature-list li i {
      color: #2a3b5c;
      font-size: 1.2rem;
      width: 2rem;
      text-align: center;
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
    .contact-link {
      color: #1a2639;
      text-decoration: none;
      font-weight: 500;
      transition: 0.15s ease;
    }
    .contact-link:hover {
      color: #2a3b5c;
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .about-banner { padding: 2.5rem 1rem; }
      .card-modern { padding: 1.5rem 1.2rem; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar  -->
  <?php  require_once "partials/navbar.php"; ?>
 

  <!-- Banner -->
  <div class="about-banner">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1 class="display-5 fw-bold">About Chores-2-Go</h1>
        <p class="lead fs-5">Your trusted partner for everyday chores, delivered with ease and professionalism.</p>
      </div>
      <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <span class="badge bg-white text-dark bg-opacity-15 px-4 py-2 rounded-pill fw-normal">
          <i class="bi bi-star-fill me-1 text-warning"></i> since 2026
        </span>
      </div>
    </div>
  </div>

  <div class="container px-0">

    <!-- Mission -->
    <div class="card-modern">
      <h2 class="section-title"><i class="bi bi-bullseye"></i> Our Mission</h2>
      <p class="fs-6" style="color: #1f3145; line-height: 1.7;">
        At <strong>Chores-2-Go</strong>, our mission is simple: to make life easier by connecting busy individuals and families with reliable freelance helpers for everyday tasks. 
        From cleaning and laundry to grocery runs and handyman services, we ensure that your chores are handled quickly, affordably, and with care.
      </p>
    </div>

    <!-- Vision -->
    <div class="card-modern">
      <h2 class="section-title"><i class="bi bi-eye"></i> Our Vision</h2>
      <p class="fs-6" style="color: #1f3145; line-height: 1.7;">
        We envision a world where no one feels overwhelmed by household responsibilities. 
        By leveraging technology and a network of skilled freelancers, we aim to redefine convenience and empower people to focus on what truly matters.
      </p>
    </div>

    <!-- What We Offer -->
    <div class="card-modern">
      <h2 class="section-title"><i class="bi bi-grid-3x3-gap-fill"></i> What We Offer</h2>
      <ul class="feature-list">
        <li><i class="bi bi-house-door"></i> Home cleaning and organization</li>
        <li><i class="bi bi-cart"></i> Grocery shopping and delivery</li>
        <li><i class="bi bi-droplet"></i> Laundry and ironing services</li>
        <li><i class="bi bi-tools"></i> Handyman and repair tasks</li>
        <li><i class="bi bi-heart-pulse"></i> Pet care and walking</li>
      </ul>
      <p class="mt-3 mb-0" style="color: #3f5570;">
        Whether it’s a one-time request or a recurring service, Chores-2-Go provides flexible options tailored to your lifestyle.
      </p>
    </div>

    <!-- Why Choose Us -->
    <div class="card-modern">
      <h2 class="section-title"><i class="bi bi-check-circle"></i> Why Choose Chores-2-Go?</h2>
      <div class="row g-3">
        <div class="col-md-6">
          <div class="d-flex align-items-start gap-2">
            <span class="icon-feature"><i class="bi bi-shield-check"></i></span>
            <div><strong>Trusted Freelancers</strong><br><span style="color:#3f5570;">Every helper is vetted and trained to deliver quality service.</span></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-start gap-2">
            <span class="icon-feature"><i class="bi bi-wallet2"></i></span>
            <div><strong>Affordable Pricing</strong><br><span style="color:#3f5570;">Transparent rates with no hidden fees.</span></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-start gap-2">
            <span class="icon-feature"><i class="bi bi-clock"></i></span>
            <div><strong>Convenience</strong><br><span style="color:#3f5570;">Book services anytime, anywhere, with just a few clicks.</span></div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-start gap-2">
            <span class="icon-feature"><i class="bi bi-headset"></i></span>
            <div><strong>Customer Support</strong><br><span style="color:#3f5570;">Our team is always available to assist you.</span></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact -->
    <div class="card-modern text-center">
      <h2 class="section-title justify-content-center"><i class="bi bi-chat-dots"></i> Get in Touch</h2>
      <p style="color: #1f3145; max-width: 500px; margin: 0 auto 1.2rem;">
        Ready to simplify your life? Reach out to us today and let Chores-2-Go take care of the rest.
      </p>
      <div class="d-flex flex-wrap justify-content-center gap-4">
        <div>
          <i class="bi bi-envelope-fill me-2" style="color:#2a3b5c;"></i>
          <a href="mailto:info@chores2go.com" class="contact-link">info@chores2go.com</a>
        </div>
        <div>
          <i class="bi bi-telephone-fill me-2" style="color:#2a3b5c;"></i>
          <a href="tel:+2348001234567" class="contact-link">+234 800 123 4567</a>
        </div>
      </div>
    </div>

  </div> <!-- container -->

  <!-- footer partial -->
  <?php require_once "partials/footer.php"; ?>
  

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
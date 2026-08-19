<?php
session_start();
 require_once "guestguard.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login · Chores-2-Go</title>
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
    .form-check-input:checked {
      background-color: #1a2639;
      border-color: #1a2639;
    }
    .form-check-label {
      font-size: 0.9rem;
      color: #4a617c;
    }
    .auth-link {
      color: #2a3b5c;
      font-weight: 500;
      text-decoration: none;
      transition: 0.15s ease;
    }
    .auth-link:hover {
      color: #1a2639;
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .banner-modern { padding: 2rem 1rem; }
      .card-modern { padding: 1.8rem 1.2rem; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar  -->
  <?php  require_once "partials/navbar.php"; ?>
  

  <!-- Banner -->
  <div class="banner-modern">
    <h1 class="display-6 fw-bold">Welcome to CHORES-2-GO</h1>
    <p class="lead fs-6">Login to access your account</p>
    <?php require_once "partials/feedback.php"; ?>
  </div>

  <!-- Login Card -->
  <div class="row justify-content-center">
    <div class="col-lg-4 col-md-6">
      <div class="card-modern">
        <h4 class="text-center mb-4" style="font-weight:600; color:#1b2a40; letter-spacing:-0.01em;">
          <i class="bi bi-person-circle me-2" style="color:#2a3b5c;"></i>Login
        </h4>

        <form action="process/process_login.php" method="post" id="loginForm">
          <!-- Role Select -->
          <div class="mb-3">
            <label for="role" class="form-label"><i class="bi bi-person-badge me-1"></i>Select Role</label>
            <select name="role" id="role" required class="form-select">
              <option value="" selected>Select Role</option>
              <option value="client">Client</option>
              <option value="keeper">Keeper</option>
            </select>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label"><i class="bi bi-envelope me-1"></i>Email</label>
            <input type="text" name="email" id="email" class="form-control" required placeholder="your@email.com">
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label for="pwd" class="form-label"><i class="bi bi-lock me-1"></i>Password</label>
            <input type="password" name="pwd" id="pwd" class="form-control" required placeholder="••••••••">
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" id="show_pwd">
              <label class="form-check-label" for="show_pwd">Show password</label>
            </div>
          </div>

          <!-- Submit -->
          <div class="text-center mt-4">
            <button class="btn btn-primary-modern" name="btnlogin">
              <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>
          </div>

          <!-- Register link -->
          <div class="text-center mt-3">
            <span style="color:#4a617c;">Don't have an account?</span>
            <a href="reg.php" class="auth-link ms-1">Register</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once "partials/footer.php"; ?>
 

</div> <!-- container-fluid -->

<script src="assets/jquery.js"></script>
<script>
  $(function(){
    $('#show_pwd').change(function(){
      var status = $(this).prop('checked');
      if(status){
        $('#pwd').attr('type','text');
      } else {
        $('#pwd').attr('type','password');
      }
    });
  });
</script>
</body>
</html>
<?php
session_start();
 require_once "userguard.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password · Chores-2-Go</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Inter', sans-serif; }
    body { background: #f2f5f9; margin: 0; padding: 0; }
    .banner-modern {
      background: linear-gradient(145deg, #1a2639, #2a3b5c);
      padding: 2.5rem 1.5rem;
      border-radius: 0 0 40px 40px;
      margin-bottom: 2.5rem;
      color: white;
      text-align: center;
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
    }
    .card-modern {
      background: #ffffff;
      border: none;
      border-radius: 28px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03), 0 4px 12px rgba(0, 0, 0, 0.02);
      padding: 2.5rem;
    }
    .form-label { font-weight: 500; color: #1e2a41; font-size: 0.9rem; }
    .form-control {
      border: 1px solid #e4eaf2;
      border-radius: 16px;
      padding: 0.7rem 1rem;
      font-size: 0.95rem;
      background: #fafcff;
    }
    .form-control:focus {
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
      width: 100%;
    }
    .btn-primary-modern:hover {
      background: #2a3b5c;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(26, 38, 57, 0.15);
    }
    .form-check-label { font-size: 0.9rem; color: #4a617c; }
    .auth-link { color: #2a3b5c; font-weight: 500; text-decoration: none; }
    .auth-link:hover { color: #1a2639; text-decoration: underline; }
    .section-title { font-weight: 600; color: #1b2a40; }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar -->
  <?php require_once "partials/navbar.php"; ?>

  <!-- Banner -->
  <div class="banner-modern">
    <h1 class="display-6 fw-bold">Change Your Password</h1>
    <p class="lead fs-6">Keep your account secure by updating your password</p>
    <?php require_once "partials/feedback.php"; ?>
  </div>

  <!-- Password Change Card -->
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card-modern">
        <h2 class="text-center mb-4 section-title">
          <i class="bi bi-shield-lock me-2" style="color:#2a3b5c;"></i>Password Change Form
        </h2>

        <?php require_once "partials/feedback.php"; ?>

        <form action="process/process_update_clpwd.php" method="post">
          <div class="mb-3">
            <label for="currentpwd" class="form-label"><i class="bi bi-lock me-1"></i>Current Password</label>
            <input type="password" name="currentpwd" id="currentpwd" class="form-control pwd" required placeholder="••••••••">
          </div>

          <div class="mb-3">
            <label for="newpwd" class="form-label"><i class="bi bi-lock-fill me-1"></i>New Password</label>
            <input type="password" name="newpwd" id="newpwd" class="form-control pwd" required placeholder="••••••••">
          </div>

          <div class="mb-3">
            <label for="confirmnewpwd" class="form-label"><i class="bi bi-lock-fill me-1"></i>Confirm New Password</label>
            <input type="password" name="newpwd1" id="confirmnewpwd" class="form-control pwd" required placeholder="••••••••">
          </div>

          <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" id="spwd">
            <label class="form-check-label" for="spwd"><i class="bi bi-eye me-1"></i>Show password</label>
          </div>

          <div class="text-center mt-4">
            <button class="btn btn-primary-modern" name="btnchangepwd">
              <i class="bi bi-arrow-repeat me-2"></i>Update Password
            </button>
          </div>

          <div class="text-center mt-3">
            <a href="dashboard.php" class="auth-link">Back to Dashboard</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php require_once "partials/footer.php"; ?>
 

</div>

<script src="assets/jquery.js"></script>
<script>
  $(document).ready(function(){
    // Show/hide password
    $("#spwd").change(function(){
      var status = $(this).prop("checked");
      if(status){
        $(".pwd").attr("type","text");
      } else {
        $(".pwd").attr("type","password");
      }
    });
  });
</script>
</body>
</html>

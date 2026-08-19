<?php
session_start();
    require_once "classes/Keeper.php";
     require_once "userguard.php";

    $k = new Keeper;
    $keeper = $k->get_keeper();
    $role = $_SESSION['role'] ?? null;

   
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Keeper · Chores-2-Go</title>
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
    .banner-modern h2 {
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
    }
    .card-modern:hover {
      transform: translateY(-6px);
      box-shadow: 0 24px 48px rgba(0, 0, 0, 0.06);
    }
    .card-modern .card-img-top {
      height: 220px;
      object-fit: cover;
      background: #eef3fa;
    }
    .card-modern .card-body {
      padding: 1.5rem 1.5rem 1.8rem;
      text-align: center;
    }
    .card-modern .card-title {
      font-weight: 700;
      color: #1b2a40;
      font-size: 1.1rem;
      margin-bottom: 0.2rem;
    }
    .card-modern .keeper-badge {
      display: inline-block;
      background: #eef3fa;
      color: #1a2639;
      font-size: 0.7rem;
      font-weight: 600;
      padding: 0.2rem 1rem;
      border-radius: 30px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin-bottom: 0.8rem;
    }
    .card-modern .info-line {
      font-size: 0.9rem;
      color: #4a617c;
      margin-bottom: 0.3rem;
    }
    .card-modern .info-line i {
      color: #2a3b5c;
      width: 1.3rem;
      text-align: center;
    }
    .btn-primary-modern {
      background: #1a2639;
      border: none;
      border-radius: 40px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      color: white;
      transition: 0.15s ease;
      width: 100%;
      text-decoration: none;
      display: inline-block;
    }
    .btn-primary-modern:hover {
      background: #2a3b5c;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(26, 38, 57, 0.15);
      color: white;
    }
    .btn-outline-modern {
      background: transparent;
      border: 1px solid #d0dae8;
      border-radius: 40px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      color: #1e2a41;
      transition: 0.15s ease;
      width: 100%;
      text-decoration: none;
      display: inline-block;
    }
    .btn-outline-modern:hover {
      background: #f2f6fc;
      border-color: #a0b4cc;
      color: #1a2639;
    }
    .btn-secondary-modern {
      background: #eef3fa;
      border: none;
      border-radius: 40px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      color: #4a617c;
      width: 100%;
      cursor: not-allowed;
      display: inline-block;
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
    .empty-state {
      text-align: center;
      padding: 3rem 1rem;
    }
    .empty-state i {
      font-size: 3.5rem;
      color: #d0dae8;
      margin-bottom: 1rem;
    }
    .empty-state h5 {
      color: #1b2a40;
      font-weight: 600;
    }
    .empty-state p {
      color: #4a617c;
    }
    .section-title {
      font-weight: 600;
      color: #1b2a40;
      letter-spacing: -0.01em;
    }
    @media (max-width: 768px) {
      .banner-modern { padding: 2rem 1rem; }
      .card-modern .card-img-top { height: 180px; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar  -->
  <?php  include_once "partials/navbar.php"; ?>


  <!-- Banner -->
  <div class="banner-modern">
    <h2 class="display-6 fw-bold">Select Keeper</h2>
    <p class="lead fs-6">Browse available keepers and choose the right one for your service</p>
    <?php require_once "partials/feedback.php";   ?>
  </div>

  <!-- Keeper Cards -->
  <div class="row justify-content-center g-4">
    <?php if(isset($_SESSION["keeper"]) && is_array($_SESSION["keeper"]) && count($_SESSION["keeper"]) > 0){ ?>
      <div class="col-12">
        <h3 class="section-title text-center mb-4">
          <i class="bi bi-person-rolodex me-2" style="color:#2a3b5c;"></i>Keepers Found:
        </h3>
      </div>
      <?php foreach($_SESSION["keeper"] as $kp){ 
            $img = !empty($kp['kp_img']) ? $kp['kp_img'] : 'default.png';
            $fname = htmlspecialchars($kp['keeper_fname'] ?? '');
            $lname = htmlspecialchars($kp['keeper_lname'] ?? '');
            $gender = htmlspecialchars($kp['keeper_gender'] ?? '');
            $service = htmlspecialchars($kp['service_categories_name'] ?? 'Unspecified');
            $keeper_id = $kp['keeper_id'] ?? '';
      ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="card-modern">
            <img src="uploads/<?php echo $img; ?>" class="card-img-top" alt="Profile Photo">
            <div class="card-body">
              <span class="keeper-badge"><i class="bi bi-shield-check me-1"></i>Keeper</span>
              <h5 class="card-title"><?php echo $fname . ' ' . $lname; ?></h5>
              <input type="hidden" name="keeper_id" value="<?php echo htmlspecialchars($keeper_id); ?>">
              
              <div class="info-line"><i class="bi bi-gender-ambiguous"></i> <?php echo $gender ?: 'Not specified'; ?></div>
              <div class="info-line"><i class="bi bi-tag"></i> <?php echo $service; ?></div>
              
              <div class="mt-3">
                <?php if($role === 'client' && !empty($keeper_id)): ?>
                  <a href="book.php?keeper_id=<?php echo urlencode($keeper_id); ?>" class="btn btn-primary-modern">
                    <i class="bi bi-calendar-plus me-2"></i>Book
                  </a>
                <?php elseif($role !== 'client' && isset($_SESSION['useronline'])): ?>
                  <span class="btn-secondary-modern"><i class="bi bi-lock me-2"></i>Book</span>
                <?php else: ?>
                  <a href="login.php" class="btn btn-outline-modern"><i class="bi bi-box-arrow-in-right me-2"></i>Login to Book</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php } else { ?>
      <div class="col-12">
        <div class="empty-state">
          <i class="bi bi-person-x"></i>
          <h5>No keepers found</h5>
          <p>No keepers available for this category and plan. Please try a different selection.</p>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Footer -->
  <?php require_once "partials/footer.php"; ?>
  

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
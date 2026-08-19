<?php
session_start();
    require_once "classes/Service.php";

    $s = new Service;
    $cate = $s->fetch_services();
    $plan= $s->fetch_service_plan();


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services · Chores-2-Go</title>
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
      min-height: 40vh;
      border-radius: 0 0 40px 40px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
      padding: 3rem 1.5rem;
      margin-bottom: 2rem;
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
      padding: 2rem 2rem;
      transition: all 0.2s ease;
    }
    .card-modern:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }
    .section-title {
      font-weight: 700;
      color: #1b2a40;
      letter-spacing: -0.01em;
      margin-bottom: 1.5rem;
    }
    .section-title i {
      color: #2a3b5c;
      margin-right: 0.5rem;
    }
    .form-select-modern {
      border: 1px solid #e4eaf2;
      border-radius: 16px;
      padding: 0.7rem 1rem;
      font-size: 0.95rem;
      background: #fafcff;
      transition: 0.15s ease;
      box-shadow: none;
    }
    .form-select-modern:focus {
      border-color: #2a3b5c;
      box-shadow: 0 0 0 4px rgba(42, 59, 92, 0.08);
      background: white;
    }
    .table-modern {
      border-collapse: separate;
      border-spacing: 0 6px;
      width: 100%;
    }
    .table-modern thead th {
      background: #eef3fa;
      color: #1b2a40;
      font-weight: 600;
      font-size: 0.8rem;
      letter-spacing: 0.03em;
      text-transform: uppercase;
      padding: 0.8rem 1rem;
      border: none;
      border-radius: 0;
    }
    .table-modern thead th:first-child {
      border-radius: 16px 0 0 16px;
    }
    .table-modern thead th:last-child {
      border-radius: 0 16px 16px 0;
    }
    .table-modern tbody tr {
      background: #ffffff;
      border-radius: 16px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.01);
      transition: 0.1s ease;
    }
    .table-modern tbody td {
      padding: 0.9rem 1rem;
      border: none;
      background: #fbfdff;
      border-bottom: 1px solid #eef3f8;
      font-weight: 450;
      color: #1f3145;
      vertical-align: middle;
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
    .checkbox-custom {
      width: 20px;
      height: 20px;
      accent-color: #1a2639;
      cursor: pointer;
    }
    .btn-primary-modern {
      background: #1a2639;
      border: none;
      border-radius: 40px;
      padding: 0.8rem 2.5rem;
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
    .sn {
      font-weight: 600;
      color: #2a3b5c;
      background: #eef3fa;
      padding: 0.2rem 0.8rem;
      border-radius: 30px;
      font-size: 0.8rem;
      display: inline-block;
    }
    @media (max-width: 768px) {
      .banner-modern { min-height: 30vh; padding: 2rem 1rem; }
      .card-modern { padding: 1.5rem 1rem; }
      .table-modern thead th, .table-modern tbody td { padding: 0.6rem 0.6rem; font-size: 0.85rem; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar  -->
  <?php  require_once "partials/navbar.php"; ?>
 

  <!-- Banner -->
  <div class="banner-modern">
    <div>
      <h1 class="display-5 fw-bold">Select Your Service Plan</h1>
      <p class="lead fs-5">Choose from our trusted housekeeping services tailored to your needs</p>
        <?php require_once "partials/feedback.php"; ?>
    </div>
  </div>

  <!-- Services Section -->
  <div class="row">
    <div class="col-12">
      <h2 class="section-title text-center"><i class="bi bi-star-fill" style="color:#f5b342;"></i> Available Services</h2>
    
    </div>
  </div>

  <div class="row justify-content-center mt-3">
    <div class="col-lg-10">
      <div class="card-modern">
        <form action="process/process_kp_services.php" method="post">

          <!-- Plan Selector -->
          <div class="mb-4 text-center">
            <label for="plan" class="form-label fw-semibold" style="color:#1b2a40;">Select Preferred Plan</label>
            <select name="plan" id="plan" class="form-select-modern w-50 mx-auto">
              <?php foreach($plan as $p){ ?>
                <option value="<?php echo $p["plan_id"]; ?>"><?php echo $p["plan_name"]; ?></option>
              <?php } ?>
            </select>
          </div>

          <!-- Services Table -->
          <div class="table-responsive">
            <table class="table-modern">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th class="text-center">Select</th>
                </tr>
              </thead>
              <tbody>
                <?php $count = 1; foreach($cate as $cat){ ?>
                  <tr>
                    <td><span class="sn"><?php echo $count++ ?></span></td>
                    <td><strong><?php echo $cat["service_categories_name"]; ?></strong></td>
                    <td><?php echo $cat["service_description"]; ?></td>
                    <td class="text-center">
                      <input type="checkbox" name="services[]" value="<?php echo $cat["service_cate_id"]; ?>" class="checkbox-custom">
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

          <div class="text-end mt-4">
            <button class="btn btn-primary-modern" name="btn">
              <i class="bi bi-plus-circle me-2"></i>Add Services
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- footer partial -->
  <?php require_once "partials/footer.php"; ?>
 

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
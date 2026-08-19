<?php
session_start();
require_once "userguard.php";

require_once "classes/Keeper.php";
$kp = new Keeper;


$record = $kp->get_keeper_byid($_SESSION["useronline"]);
$state = $kp->fetch_all_state();


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Keeper Profile · Modern</title>
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
    .card-modern {
      background: #ffffff;
      border: none;
      border-radius: 28px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03), 0 4px 12px rgba(0, 0, 0, 0.02);
      transition: all 0.2s ease;
      padding: 2rem 1.8rem;
    }
    .card-modern:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
    }
    .profile-banner {
      background: linear-gradient(145deg, #1a2639, #2a3b5c);
      padding: 2.2rem 1.5rem;
      border-radius: 0 0 40px 40px;
      margin-bottom: 2rem;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .profile-banner::after {
      content: '';
      position: absolute;
      top: -30%;
      right: -5%;
      width: 260px;
      height: 260px;
      background: rgba(255,255,255,0.02);
      border-radius: 50%;
      pointer-events: none;
    }
    .profile-banner h1 {
      font-weight: 700;
      letter-spacing: -0.02em;
    }
    .profile-banner p {
      opacity: 0.8;
      font-weight: 400;
    }
    .profile-card {
      background: #ffffff;
      border-radius: 28px;
      padding: 2rem 1.5rem;
      text-align: center;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.02);
      border: 1px solid rgba(255,255,255,0.4);
      backdrop-filter: blur(2px);
      height: 100%;
    }
    .profile-card img {
      width: 160px;
      height: 160px;
      object-fit: cover;
      border-radius: 50%;
      border: 5px solid #eef2f7;
      box-shadow: 0 8px 20px rgba(0,0,0,0.04);
      margin-bottom: 1rem;
      background: #f0f4fa;
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
      padding: 0.8rem 2rem;
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
    .btn-outline-modern {
      background: transparent;
      border: 1px solid #d0dae8;
      border-radius: 40px;
      padding: 0.7rem 1.8rem;
      font-weight: 500;
      color: #1e2a41;
      transition: 0.15s ease;
    }
    .btn-outline-modern:hover {
      background: #f2f6fc;
      border-color: #a0b4cc;
    }
    .radio-group label {
      margin-right: 1.5rem;
      font-weight: 450;
      color: #1f3145;
    }
    .radio-group input[type="radio"] {
      margin-right: 0.4rem;
      accent-color: #1a2639;
      transform: scale(1.1);
    }
    .footer-light {
      background: transparent;
      border-top: 1px solid #dee7ef;
      padding: 1.5rem 0;
      margin-top: 2.5rem;
      color: #4a617c;
    }
    .badge-soft {
      background: #eef3fa;
      color: #1e2a41;
      font-weight: 500;
      padding: 0.3rem 1.2rem;
      border-radius: 40px;
      font-size: 0.8rem;
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
    @media (max-width: 768px) {
      .profile-card img { width: 130px; height: 130px; }
      .card-modern { padding: 1.5rem 1rem; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar  -->
  <?php  require_once "partials/navbar.php"; ?>


  <!-- Banner -->
  <div class="profile-banner">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1 class="fw-bold display-6">Update Your Profile</h1>
        <p class="lead fs-6">Keep your keeper information fresh and accurate</p>
        <?php require_once "partials/feedback.php"; ?>
      </div>
      <div class="col-md-4 text-md-end mt-2 mt-md-0">
        <span class="badge bg-white text-dark bg-opacity-15 px-4 py-2 rounded-pill fw-normal">
          <i class="bi bi-pencil-square me-1"></i> edit mode
        </span>
      </div>
    </div>
  </div>

  <!-- Profile Image + Form row -->
  <div class="row g-4">

    <!-- LEFT: image update card -->
    <div class="col-lg-4 col-md-5">
      <div class="profile-card">
        <form action="process/process_kp_image.php" method="post" enctype="multipart/form-data">
          <img src="uploads/<?php echo $record["kp_img"] ?? 'default.jpg'; ?>" alt="Profile Picture">
          <div class="mb-3">
            <input type="file" name="image" id="image" class="form-control" accept="image/png,image/jpg,image/jpeg" style="border-radius:40px; padding:0.5rem 1rem;">
          </div>
          <button class="btn btn-primary-modern w-100" name="btnimg"><i class="bi bi-cloud-upload me-2"></i>Change Picture</button>
        </form>
        <div class="mt-3 text-muted small">
          <i class="bi bi-info-circle"></i> JPG, PNG · max 5MB
        </div>
      </div>
    </div>

    <!-- RIGHT: update form -->
    <div class="col-lg-8 col-md-7">
      <div class="card-modern">
        <h2 class="section-title mb-4" style="font-weight:600; color:#1b2a40; letter-spacing:-0.01em;">
          <i class="bi bi-pencil-square me-2" style="color:#2a3b5c;"></i>Edit details
        </h2>

        <form action="process/process_edit_kp.php" method="post" id="editform">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="fname" class="form-label">First Name</label>
              <input type="text" name="fname" id="fname" value="<?php echo $record["keeper_fname"] ?? ''; ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="lname" class="form-label">Last Name</label>
              <input type="text" name="lname" id="lname" value="<?php echo $record["keeper_lname"] ?? ''; ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" value="<?php echo $record["kp_email"] ?? ''; ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="tel" name="phone" id="phone" value="<?php echo $record["kp_phone"] ?? ''; ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="dob" class="form-label">Date of Birth</label>
              <input type="date" name="dob" id="dob" value="<?php echo $record["keeper_dateofbirth"] ?? ''; ?>" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="mstatus" class="form-label">Marital Status</label>
              <select name="mstatus" id="mstatus" class="form-select">
                <option value="single" <?php if(($record['kp_marital'] ?? '')=='single') echo 'selected'; ?>>Single</option>
                <option value="married" <?php if(($record['kp_marital'] ?? '')=='married') echo 'selected'; ?>>Married</option>
                <option value="divorced" <?php if(($record['kp_marital'] ?? '')=='divorced') echo 'selected'; ?>>Divorced</option>
                <option value="widow" <?php if(($record['kp_marital'] ?? '')=='widow') echo 'selected'; ?>>Widow</option>
                <option value="widower" <?php if(($record['kp_marital'] ?? '')=='widower') echo 'selected'; ?>>Widower</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="state" class="form-label">State</label>
              <select name="state" id="state" class="form-select">
                <option value="">Select State</option>
                <?php foreach($state as $s){ 
                  $selected = (($record["state_id"] ?? '') == $s["state_id"]) ? "selected" : "";
                  echo "<option value=".$s["state_id"]." $selected>".$s["state_name"]."</option>";
                } ?>
              </select>
            </div>
            <div class="col-md-6">
              <label for="lga" class="form-label">Local Government Area</label>
              <select name="lga" id="lga" class="form-select">
                <?php
                  $lgas = $kp->fetch_lga_by_state($record["state_id"] ?? 0);
                  foreach($lgas as $l){
                    $selected = (($record["local_garea_id"] ?? '') == $l["lga_id"]) ? "selected" : "";
                    echo "<option value='{$l["lga_id"]}' $selected>{$l["lga_name"]}</option>";
                  }
                ?>
              </select>
            </div>
            <div class="col-md-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" name="address" id="address" value="<?php echo $record["kp_address"] ?? ''; ?>" class="form-control" required>
            </div>
            <div class="col-md-12">
              <div class="radio-group">
                <label class="form-label d-block mb-1">Gender</label>
                <div>
                  <input type="radio" name="sex" id="msex" value="male" <?php if(($record['keeper_gender'] ?? '')=='male') echo 'checked'; ?>>
                  <label for="msex" class="me-3">Male</label>
                  <input type="radio" name="sex" id="fsex" value="female" <?php if(($record['keeper_gender'] ?? '')=='female') echo 'checked'; ?>>
                  <label for="fsex">Female</label>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex gap-3 mt-4 flex-wrap">
            <button class="btn btn-primary-modern px-5" name="btnup" id="btnup"><i class="bi bi-check2-circle me-2"></i>Update</button>
            <a href="keeper_profile.php" class="btn btn-outline-modern"><i class="bi bi-arrow-left me-2"></i>Cancel</a>
            <a href="change_password.php" class="btn btn-outline-modern"><i class="bi bi-lock me-2"></i>Change Password</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- footer partial -->
  <?php require_once "partials/footer.php"; ?>
   

</div> <!-- container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/jquery.js"></script>
<script>
  $(function(){
    var savedState = $("#state").val();
    var savedLga   = "<?php echo isset($record['local_garea_id']) ? $record['local_garea_id'] : ''; ?>";

    function loadLgas(stateId, selectedLga) {
      if(!stateId) {
        $("#lga").html("<option value=\"\">Select LGA</option>");
        return;
      }
      $.ajax({
        url: "process/process_state_kp.php",
        type: "POST",
        data: {state_id: stateId, saved_lga: selectedLga},
        success: function(data){
          $("#lga").html(data);
        }
      });
    }

    if(savedState){
      loadLgas(savedState, savedLga);
    } else {
      $("#lga").html("<option value=\"\">Select LGA</option>");
    }

    $("#state").change(function(){
      var state = $(this).val();
      loadLgas(state, "");
    });
  });
</script>
</body>
</html>
<?php
session_start();
require_once "classes/Keeper.php";
 require_once "userguard.php";
$s = new Keeper;
$services = $s->fetch_kp_services($_SESSION["useronline"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Services · Chores-2-Go</title>
    <?php require_once "partials/style.php"; ?>
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
            transition: all 0.2s ease;
            padding: 1.8rem 2rem;
            margin-bottom: 1.5rem;
        }
        .card-modern:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }
        .service-icon {
            width: 48px;
            height: 48px;
            background: #eef3fa;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #1a2639;
            flex-shrink: 0;
        }
        .service-name {
            font-weight: 600;
            color: #1b2a40;
            font-size: 1.05rem;
        }
        .service-plan {
            color: #4a617c;
            font-weight: 500;
            font-size: 0.9rem;
            background: #f0f4fa;
            padding: 0.2rem 1rem;
            border-radius: 30px;
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
        @media (max-width: 768px) {
            .banner-modern { padding: 2rem 1rem; }
            .card-modern { padding: 1.2rem 1.2rem; }
        }
    </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

    <!-- Navbar  -->
    <?php  require_once "partials/navbar.php"; ?>
   

    <!-- Banner -->
    <div class="banner-modern">
        <h1 class="display-6 fw-bold">My Services</h1>
        <p class="lead fs-6">Services you offer to clients</p>
          <?php require_once "partials/feedback.php";   ?>
    </div>

    <!-- Services List -->
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <?php if($services !== false && !empty($services)){ ?>
                <?php foreach($services as $ser){ ?>
                    <div class="card-modern">
                        <div class="d-flex align-items-center gap-3">
                            <div class="service-icon">
                                <i class="bi bi-tools"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="service-name"><?php echo $ser["service_categories_name"]; ?></div>
                                <span class="service-plan"><i class="bi bi-clock me-1"></i><?php echo $ser["plan_name"]; ?></span>
                            </div>
                            <div>
                                <span class="badge bg-light text-secondary rounded-pill px-3 py-2 fw-normal">
                                    <i class="bi bi-check-circle-fill text-success me-1"></i> active
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="card-modern empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5>No services added yet</h5>
                    <p>Start by adding your first service to attract clients.</p>
                    <a href="add_kp_services.php" class="btn btn-primary-modern" style="background:#1a2639; color:white; border-radius:40px; padding:0.6rem 2rem; text-decoration:none; font-weight:600; display:inline-block; margin-top:0.5rem;">
                        <i class="bi bi-plus-circle me-2"></i>Add Service
                    </a>
                </div>
            <?php } ?>

            <!-- Action link -->
            <div class="text-center mt-3">
                <a href="add_kp_services.php" class="text-decoration-none" style="color:#2a3b5c; font-weight:500;">
                    <i class="bi bi-plus-circle me-1"></i> Add more services
                </a>
            </div>

        </div>
    </div>

    <!-- footer partial -->
    <?php require_once "partials/footer.php"; ?>
   

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
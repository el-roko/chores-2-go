<?php
session_start();
    require_once "classes/Admin.php";
    require_once "adminguard.php";

    $t = new Admin;
    $tt = $t->total_clients();

    $k = new Admin;
    $kk =$k->total_keepers();

    $total = $tt + $kk;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once "partials/admin_style.php"; ?>
</head>
<body>
    <div class="container-fluid">
        <?php require_once "partials/admin_navbar.php"; ?>

                <div class="row mt-4 mx-4 d-flex justify-content-between">
                        <div class="col-md-3 card" style="width: 18rem;">
                            <div class="card-body text-center">
                                <h5 class="card-title text-uppercase fw-bold">Total Clients</h5>
                                <h3 class="card-text py-3 fw-bold"><?php echo $tt;  ?></h3>
                            </div>
                        </div>  
                        <div class="col-md-3  card" style="width: 18rem;">
                            <div class="card-body text-center">
                                <h5 class="card-title text-uppercase fw-bold">Total Keepers</h5>
                                <h3 class="card-text py-3 fw-bold"><?php echo $kk; ?></h3>
                            </div>
                        </div>  
                        <div class="col-md-3 card" style="width: 18rem;">
                            <div class="card-body text-center">
                                <h5 class="card-title text-uppercase fw-bold">Total Users</h5>
                                <h3 class="card-text py-3 fw-bold"><?php echo $total;  ?></h3>
                            </div>
                        </div>  
                </div>
                <div class="row"></div>
                <div class="row"></div>
            </div>

        </div>
    </div>


    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
    <script src="jquery.js"></script>
</body>
</html>     

<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Emmanuel">
    <meta name="robots" name="noindex,nofollow">
    <meta name="description" name="join the best platform for household in need of freelance house keepers">
    <title>Categories · Chores-2-Go</title>
    <?php require_once "partials/style.php";  ?>
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
        }
        .section-title i {
            color: #2a3b5c;
            margin-right: 0.5rem;
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
            font-size: 0.78rem;
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
            padding: 0.7rem 2.2rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            transition: 0.15s ease;
            letter-spacing: 0.01em;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
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
        .category-badge {
            background: #eef3fa;
            padding: 0.2rem 1rem;
            border-radius: 30px;
            font-weight: 500;
            font-size: 0.85rem;
            color: #1a2639;
            display: inline-block;
        }
        @media (max-width: 768px) {
            .banner-modern { padding: 2rem 1rem; }
            .card-modern { padding: 1.5rem 1rem; }
            .table-modern thead th, .table-modern tbody td { padding: 0.6rem 0.6rem; font-size: 0.82rem; }
        }
    </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

    <!-- Navbar  -->
    <?php  require_once "partials/navbar.php"; ?>


    <!-- Banner -->
    <div class="banner-modern">
        <h1 class="display-6 fw-bold">Select Categories</h1>
        <p class="lead fs-6">Choose the service categories that match your needs</p>
    </div>

    <!-- Categories Table -->
    <div class="row justify-content-center mt-2">
        <div class="col-lg-8 col-md-10">
            <div class="card-modern">
                <h3 class="section-title text-center mb-4">
                    <i class="bi bi-list-check"></i>Available Categories
                </h3>

                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th class="text-center">Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="fw-bold text-secondary">1</span></td>
                                <td><span class="category-badge"><i class="bi bi-clock me-1"></i>Hourly</span></td>
                                <td>Flexible hourly service</td>
                                <td class="text-center"><input type="checkbox" class="checkbox-custom"></td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">2</span></td>
                                <td><span class="category-badge"><i class="bi bi-sun me-1"></i>A Day</span></td>
                                <td>Full day service coverage</td>
                                <td class="text-center"><input type="checkbox" class="checkbox-custom"></td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">3</span></td>
                                <td><span class="category-badge"><i class="bi bi-calendar-week me-1"></i>Twice a Week</span></td>
                                <td>Bi-weekly scheduled visits</td>
                                <td class="text-center"><input type="checkbox" class="checkbox-custom"></td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">4</span></td>
                                <td><span class="category-badge"><i class="bi bi-calendar3 me-1"></i>Thrice a Week</span></td>
                                <td>Three times weekly service</td>
                                <td class="text-center"><input type="checkbox" class="checkbox-custom"></td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">5</span></td>
                                <td><span class="category-badge"><i class="bi bi-file-earmark-text me-1"></i>Contract</span></td>
                                <td>Long-term commitment plan</td>
                                <td class="text-center"><input type="checkbox" class="checkbox-custom"></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td class="text-center pt-3">
                                    <a href="search_booking.php" class="btn btn-primary-modern">
                                        <i class="bi bi-check2-circle"></i>Done
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- footer partial -->
    <?php require_once "partials/footer.php"; ?>
  

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
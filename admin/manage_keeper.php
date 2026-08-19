<?php  
session_start();
require_once "adminguard.php";
require_once "classes/Admin.php";

$p = new Admin;
$user = $p->get_admin_byid($_SESSION["adminonline"]);

$kp = $p->total_keepers();
$keepers = $p->fetch_keepers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin · Keepers</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font -->
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
        /* Sidebar styles */
        .sidebar {
            background: #ffffff;
            border-right: 1px solid #eef3fa;
            min-height: 100vh;
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar .brand {
            font-weight: 700;
            color: #1a2639;
            font-size: 1.2rem;
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid #eef3fa;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar .brand i {
            color: #2a3b5c;
            font-size: 1.4rem;
        }
        .sidebar .nav-link {
            color: #4a617c;
            padding: 0.7rem 1.5rem;
            border-radius: 12px;
            margin: 0.2rem 0.8rem;
            font-weight: 500;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .sidebar .nav-link i {
            font-size: 1.1rem;
            color: #4a617c;
            width: 1.5rem;
            text-align: center;
        }
        .sidebar .nav-link:hover {
            background: #eef3fa;
            color: #1a2639;
        }
        .sidebar .nav-link:hover i {
            color: #1a2639;
        }
        .sidebar .nav-link.active {
            background: #eef3fa;
            color: #1a2639;
            font-weight: 600;
        }
        .sidebar .nav-link.active i {
            color: #1a2639;
        }
        .sidebar .nav-link.logout {
            color: #b04040;
            margin-top: 1rem;
        }
        .sidebar .nav-link.logout i {
            color: #b04040;
        }
        .sidebar .nav-link.logout:hover {
            background: #fde8e8;
        }

        .main-content {
            padding: 1.5rem 2rem;
        }

        .top-bar {
            background: #ffffff;
            border-radius: 20px;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .top-bar .greeting h5 {
            font-weight: 600;
            color: #1b2a40;
            margin: 0;
        }
        .top-bar .greeting span {
            color: #4a617c;
            font-size: 0.9rem;
        }
        .top-bar .admin-badge {
            background: #eef3fa;
            padding: 0.4rem 1.2rem;
            border-radius: 40px;
            font-weight: 500;
            font-size: 0.85rem;
            color: #1a2639;
        }

        .stat-card {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            padding: 1.5rem 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
            height: 100%;
            border: 1px solid rgba(255,255,255,0.5);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.04);
        }
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 0.8rem;
        }
        .stat-card .stat-icon.blue { background: #e8f0fe; color: #2a3b5c; }
        .stat-card .stat-icon.green { background: #e6f5ed; color: #1a7a4a; }
        .stat-card .stat-icon.orange { background: #fef0e6; color: #b06a2a; }
        .stat-card .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1b2a40;
            margin: 0;
            line-height: 1.2;
        }
        .stat-card .stat-label {
            color: #4a617c;
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .table-section {
            background: #ffffff;
            border-radius: 24px;
            padding: 1.5rem 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.02);
            margin-top: 2rem;
        }
        .table-section .section-title {
            font-weight: 600;
            color: #1b2a40;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .table-section .section-title i {
            color: #2a3b5c;
        }

        .table-modern {
            border-collapse: separate;
            border-spacing: 0 4px;
            width: 100%;
        }
        .table-modern thead th {
            background: #eef3fa;
            color: #1b2a40;
            font-weight: 600;
            font-size: 0.72rem;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            padding: 0.7rem 1rem;
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
            border-radius: 12px;
            transition: 0.1s ease;
        }
        .table-modern tbody td {
            padding: 0.7rem 1rem;
            border: none;
            border-bottom: 1px solid #f0f4fa;
            font-weight: 450;
            color: #1f3145;
            vertical-align: middle;
            font-size: 0.88rem;
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

        .btn-outline-modern {
            background: transparent;
            border: 1px solid #d0dae8;
            border-radius: 40px;
            padding: 0.25rem 1rem;
            font-weight: 500;
            color: #1e2a41;
            transition: 0.15s ease;
            font-size: 0.78rem;
        }
        .btn-outline-modern:hover {
            background: #f2f6fc;
            border-color: #a0b4cc;
        }
        .btn-outline-modern.danger {
            border-color: #f5c6cb;
            color: #a04040;
        }
        .btn-outline-modern.danger:hover {
            background: #fde8e8;
            border-color: #d08080;
        }
        .btn-outline-modern.success {
            border-color: #c3e6cb;
            color: #1a7a4a;
        }
        .btn-outline-modern.success:hover {
            background: #e6f5ed;
            border-color: #8fc9a0;
        }

        .status-badge {
            padding: 0.2rem 1rem;
            border-radius: 40px;
            font-weight: 500;
            font-size: 0.7rem;
            display: inline-block;
        }
        .status-badge.active { background: #d4edda; color: #155724; }
        .status-badge.inactive { background: #f8d7da; color: #721c24; }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                height: auto;
                position: relative;
            }
            .main-content {
                padding: 1rem;
            }
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            .stat-number {
                font-size: 1.8rem !important;
            }
            .table-section {
                padding: 1rem;
            }
            .table-modern thead th, .table-modern tbody td {
                padding: 0.4rem 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid px-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <?php include "partials/admin_navbar.php"; ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                  <?php require_once "partials/feedback.php";  ?>

                <!-- Top Bar -->
                <div class="top-bar">
                    <div class="greeting">
                        <h5><i class="bi bi-person-circle me-2" style="color:#2a3b5c;"></i>Welcome, <?php echo htmlspecialchars($user['admin_fname'] ?? 'Admin'); ?></h5>
                        <span>Keeper management</span>
                    </div>
                    <div class="admin-badge">
                        <i class="bi bi-shield-check me-1"></i> Administrator
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon blue"><i class="bi bi-person-badge-fill"></i></div>
                            <p class="stat-number"><?php echo $kp; ?></p>
                            <p class="stat-label">Total Keepers</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon green"><i class="bi bi-person-check-fill"></i></div>
                            <p class="stat-number">
                                <?php
                                    $activeCount = 0;
                                    foreach ($keepers as $keeper) {
                                        if ($keeper['status'] === "active") {
                                            $activeCount++;
                                        }
                                    }
                                    echo $activeCount;
                                ?>
                            </p>
                            <p class="stat-label">Active Keepers</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon orange"><i class="bi bi-person-x-fill"></i></div>
                            <p class="stat-number">
                                 <?php 
                                    $inactiveCount = 0; 
                                    foreach ($keepers as $keeper) {
                                       if ($keeper['status'] === "inactive" || $keeper['status'] === "blocked") {
                                                $inactiveCount++;
                                            }

                                    }
                                    echo $inactiveCount;
                                ?>
                            </p>
                            <p class="stat-label">Inactive Keepers</p>
                        </div>
                    </div>
                </div>

                <!-- Keepers Table -->
                <div class="table-section">
                    <div class="section-title">
                        <i class="bi bi-person-lines-fill"></i> All Keepers
                    </div>

                    <div class="table-responsive">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Registered On</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($keepers as $keeper): ?>
                                <tr>
                                    <td><span class="fw-bold text-secondary"><?php echo $keeper['keeper_id']; ?></span></td>
                                    <td><?php echo htmlspecialchars($keeper['keeper_fname'].' '.$keeper['keeper_lname']); ?></td>
                                    <td><?php echo htmlspecialchars($keeper['kp_email']); ?></td>
                                    <td><span class="text-muted small"><?php echo date("Y-m-d H:i", strtotime($keeper['registered_on'])); ?></span></td>
                                    <td>
                                         <?php if($keeper['status'] === "active"): ?>
                                        <span class="status-badge active"><?php echo $keeper['status']; ?></span>
                                        <?php else: ?>
                                            <span class="status-badge inactive">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <form action="process/process_kp_status.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="keeper_id" value="<?php echo $keeper['keeper_id']; ?>">
                                            <input type="hidden" name="status" value="blocked">
                                            <button type="submit" class="btn btn-outline-modern danger" name="btn">
                                                <i class="bi bi-ban me-1"></i>Block
                                            </button>
                                        </form>

                                        <form action="process/process_kp_status.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="keeper_id" value="<?php echo $keeper['keeper_id']; ?>">
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit" class="btn btn-outline-modern success" name="btn1">
                                                <i class="bi bi-check-circle me-1"></i>Unblock
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if(empty($keepers)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox me-2"></i>No keepers found
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
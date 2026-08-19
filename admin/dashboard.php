<?php  
session_start();
require_once "adminguard.php";
require_once "classes/Admin.php";

$p = new Admin;
$user = $p->get_admin_byid($_SESSION["adminonline"]);

$cl = $p->total_clients();
$kp = $p->total_keepers();
$total = $cl + $kp;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard · Chores-2-Go</title>
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

        /* Main content */
        .main-content {
            padding: 1.5rem 2rem;
        }

        /* Top bar */
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

        /* Stats cards */
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
        .stat-card .stat-icon.purple { background: #f0ecf9; color: #5a4a8a; }
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

        /* Recent activity */
        .activity-card {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            padding: 1.5rem 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.02);
            margin-top: 2rem;
        }
        .activity-card .section-title {
            font-weight: 600;
            color: #1b2a40;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .activity-card .section-title i {
            color: #2a3b5c;
        }
        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f0f4fa;
        }
        .activity-item:last-child {
            border-bottom: none;
        }
        .activity-item .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2a3b5c;
            flex-shrink: 0;
        }
        .activity-item .activity-dot.green { background: #1a7a4a; }
        .activity-item .activity-dot.orange { background: #d68a2c; }
        .activity-item .activity-text {
            color: #1f3145;
            font-weight: 450;
            flex: 1;
        }
        .activity-item .activity-time {
            color: #4a617c;
            font-size: 0.8rem;
        }

        /* Responsive */
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

                <!-- Top Bar -->
                <div class="top-bar">
                    <div class="greeting">
                        <h5><i class="bi bi-person-circle me-2" style="color:#2a3b5c;"></i>Welcome, <?php echo htmlspecialchars($user['admin_fname'] ?? 'Admin'); ?></h5>
                        <span>Dashboard overview</span>
                    </div>
                    <div class="admin-badge">
                        <i class="bi bi-shield-check me-1"></i> Administrator
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
                            <p class="stat-number"><?php echo $cl; ?></p>
                            <p class="stat-label">Total Clients</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon green"><i class="bi bi-person-badge-fill"></i></div>
                            <p class="stat-number"><?php echo $kp; ?></p>
                            <p class="stat-label">Total Keepers</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon purple"><i class="bi bi-person-circle"></i></div>
                            <p class="stat-number"><?php echo $total; ?></p>
                            <p class="stat-label">Total Users</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="activity-card">
                    <div class="section-title">
                        <i class="bi bi-clock-history"></i> Recent Activity
                    </div>
                    <div class="activity-item">
                        <span class="activity-dot green"></span>
                        <span class="activity-text">New user registered</span>
                        <span class="activity-time">2 min ago</span>
                    </div>
                    <div class="activity-item">
                        <span class="activity-dot orange"></span>
                        <span class="activity-text">Order #1023 completed</span>
                        <span class="activity-time">1 hour ago</span>
                    </div>
                    <div class="activity-item">
                        <span class="activity-dot"></span>
                        <span class="activity-text">Admin updated settings</span>
                        <span class="activity-time">3 hours ago</span>
                    </div>
                </div>

            </div>
            <!-- End Main Content -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
session_start();
require_once "adminguard.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin · Bookings</title>
    <?php require_once "partials/admin_style.php"; ?>
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

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .page-header h3 {
            font-weight: 600;
            color: #1b2a40;
            margin: 0;
        }
        .page-header h3 i {
            color: #2a3b5c;
            margin-right: 0.5rem;
        }

        .btn-primary-modern {
            background: #1a2639;
            border: none;
            border-radius: 40px;
            padding: 0.6rem 1.8rem;
            font-weight: 600;
            color: white;
            transition: 0.15s ease;
            font-size: 0.9rem;
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
            padding: 0.3rem 1.2rem;
            font-weight: 500;
            color: #1e2a41;
            transition: 0.15s ease;
            font-size: 0.8rem;
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

        .table-modern {
            border-collapse: separate;
            border-spacing: 0 6px;
            width: 100%;
        }
        .table-modern thead th {
            background: #eef3fa;
            color: #1b2a40;
            font-weight: 600;
            font-size: 0.72rem;
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
            padding: 0.8rem 1rem;
            border: none;
            background: #fbfdff;
            border-bottom: 1px solid #eef3f8;
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
        .status-badge {
            padding: 0.2rem 1rem;
            border-radius: 40px;
            font-weight: 500;
            font-size: 0.7rem;
            text-transform: capitalize;
            display: inline-block;
        }
        .status-badge.pending { background: #fff3cd; color: #856404; }
        .status-badge.completed { background: #d4edda; color: #155724; }
        .status-badge.active { background: #cce5ff; color: #004085; }
        .status-badge.cancelled { background: #f8d7da; color: #721c24; }

        .empty-state td {
            text-align: center;
            padding: 2rem !important;
            color: #4a617c;
        }

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
            .page-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }
            .table-modern thead th, .table-modern tbody td {
                padding: 0.5rem 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid px-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <?php require_once "partials/admin_navbar.php"; ?>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">

                <!-- Top Bar -->
                <div class="top-bar">
                    <div class="greeting">
                        <h5><i class="bi bi-person-circle me-2" style="color:#2a3b5c;"></i>Admin Dashboard</h5>
                        <span>Manage bookings</span>
                    </div>
                    <div class="admin-badge">
                        <i class="bi bi-shield-check me-1"></i> Administrator
                    </div>
                </div>

                <!-- Page Header -->
                <div class="page-header">
                    <h3><i class="bi bi-calendar-check"></i>Latest Bookings</h3>
                    <button class="btn btn-primary-modern add_rec">
                        <i class="bi bi-plus-circle me-2"></i>Add Record
                    </button>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Client ID</th>
                                <th>Client Fname</th>
                                <th>Client Lname</th>
                                <th>Category ID</th>
                                <th>Status</th>
                                <th>Keeper ID</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="fw-bold text-secondary">10</span></td>
                                <td>Emeka</td>
                                <td>Odimgba</td>
                                <td><span class="badge bg-light text-secondary">1</span></td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>120</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-modern"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-outline-modern danger"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">133</span></td>
                                <td>Damilola</td>
                                <td>Oragun</td>
                                <td><span class="badge bg-light text-secondary">3</span></td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>62</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-modern"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-outline-modern danger"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">39</span></td>
                                <td>Festus</td>
                                <td>Farabele</td>
                                <td><span class="badge bg-light text-secondary">1</span></td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td>25</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-modern"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-outline-modern danger"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">60</span></td>
                                <td>Saturday</td>
                                <td>Ogologo</td>
                                <td><span class="badge bg-light text-secondary">1</span></td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>11</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-modern"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-outline-modern danger"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">40</span></td>
                                <td>Musa</td>
                                <td>Sani</td>
                                <td><span class="badge bg-light text-secondary">2</span></td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>120</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-modern"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-outline-modern danger"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">156</span></td>
                                <td>Temilola</td>
                                <td>Lagbaja</td>
                                <td><span class="badge bg-light text-secondary">2</span></td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td>10</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-modern"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-outline-modern danger"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-bold text-secondary">100</span></td>
                                <td>Ijeoma</td>
                                <td>Folarin</td>
                                <td><span class="badge bg-light text-secondary">3</span></td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td>12</td>
                                <td class="text-center">
                                    <button class="btn btn-outline-modern"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-outline-modern danger"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                            <tr class="empty">
                                <td colspan="7" style="text-align:center; padding:1.5rem; color:#4a617c;">
                                    <i class="bi bi-inbox me-2"></i>End of records
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <?php require_once "partials/admin_ext.php"; ?>
</body>
</html>
<?php  
session_start();
require_once "adminguard.php";
require_once "classes/Admin.php";
require_once "classes/Service.php";

$p = new Admin;
$user = $p->get_admin_byid($_SESSION["adminonline"]);

$se = new Service;

$cl = $p->total_clients();
$kp = $p->total_keepers();
$total = $cl + $kp;

$ser = $se->fetch_service_plan();

$plan_to_edit = null;
if(isset($_GET["edit_id"])){
    $plan_to_edit = $se->get_plan($_GET["edit_id"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin · Service Plans</title>
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
            text-decoration: none;
            display: inline-block;
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
        .btn-outline-modern.primary {
            border-color: #b8d4f0;
            color: #1a4a7a;
        }
        .btn-outline-modern.primary:hover {
            background: #e8f0fe;
            border-color: #8ab4f8;
        }

        .edit-card {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            padding: 2rem 2rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.02);
            margin-bottom: 2rem;
            border-left: 4px solid #f5b342;
        }
        .edit-card .edit-title {
            font-weight: 600;
            color: #1b2a40;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .edit-card .edit-title i {
            color: #f5b342;
        }

        .form-control {
            border: 1px solid #e4eaf2;
            border-radius: 16px;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            background: #fafcff;
            transition: 0.15s ease;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: #2a3b5c;
            box-shadow: 0 0 0 4px rgba(42, 59, 92, 0.08);
            background: white;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }
        .form-label {
            font-weight: 500;
            color: #1e2a41;
            font-size: 0.9rem;
        }

        .btn-primary-modern {
            background: #1a2639;
            border: none;
            border-radius: 40px;
            padding: 0.6rem 2rem;
            font-weight: 600;
            color: white;
            transition: 0.15s ease;
        }
        .btn-primary-modern:hover {
            background: #2a3b5c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 38, 57, 0.15);
            color: white;
        }
        .btn-secondary-modern {
            background: #eef3fa;
            border: none;
            border-radius: 40px;
            padding: 0.6rem 2rem;
            font-weight: 600;
            color: #1e2a41;
            transition: 0.15s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-secondary-modern:hover {
            background: #e2e8f0;
            color: #1a2639;
        }

        .add-plan-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #1a2639;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.15s ease;
            font-size: 0.9rem;
        }
        .add-plan-link:hover {
            background: #2a3b5c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 38, 57, 0.15);
            color: white;
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
            .edit-card {
                padding: 1.5rem 1rem;
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
                        <span>Service plans management</span>
                    </div>
                    <div class="admin-badge">
                        <i class="bi bi-shield-check me-1"></i> Administrator
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon blue"><i class="bi bi-grid-3x3-gap-fill"></i></div>
                            <p class="stat-number"><?php echo $cl; ?></p>
                            <p class="stat-label">Total Services</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon green"><i class="bi bi-list-ul"></i></div>
                            <p class="stat-number"><?php echo $kp; ?></p>
                            <p class="stat-label">Total Plans</p>
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

                <!-- Edit Form (if editing) -->
                <?php if($plan_to_edit): ?>
                <div class="edit-card">
                    <div class="edit-title">
                        <i class="bi bi-pencil-square"></i> Edit Service Plan
                    </div>
                    <form action="process/process_edit_plan.php" method="post">
                        <input type="hidden" name="plan_id" value="<?php echo $plan_to_edit['plan_id']; ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="servname" class="form-label"><i class="bi bi-tag me-1"></i>Plan Name</label>
                                <input type="text" name="servname" id="servname" class="form-control" value="<?php echo htmlspecialchars($plan_to_edit['plan_name']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="desc" class="form-label"><i class="bi bi-text-paragraph me-1"></i>Description</label>
                                <textarea name="desc" id="desc" class="form-control" required><?php echo htmlspecialchars($plan_to_edit['plan_desc']); ?></textarea>
                            </div>
                            <div class="col-12 text-end mt-3">
                                <a href="manage_plan.php" class="btn-secondary-modern me-2"><i class="bi bi-x-circle me-1"></i>Cancel</a>
                                <button type="submit" name="btn" class="btn-primary-modern"><i class="bi bi-check2-circle me-1"></i>Update Plan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php endif; ?>

                <!-- Plans Table -->
                <div class="table-section">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="section-title">
                            <i class="bi bi-list-ul"></i> Service Plans
                        </div>
                        <a href="add_services_plan_form.php" class="add-plan-link">
                            <i class="bi bi-plus-circle"></i> Add Plan
                        </a>
                    </div>

                    <div class="table-responsive mt-2">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>Plan ID</th>
                                    <th>Plan Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ser as $s){ ?>
                                <tr>
                                    <td><span class="fw-bold text-secondary"><?php echo $s["plan_id"]; ?></span></td>
                                    <td><span class="fw-medium"><?php echo htmlspecialchars($s["plan_name"]); ?></span></td>
                                    <td><?php echo htmlspecialchars($s["plan_desc"]); ?></td>
                                    <td class="text-center">
                                        <a href="manage_plan.php?edit_id=<?php echo $s['plan_id']; ?>" class="btn-outline-modern primary"><i class="bi bi-pencil me-1"></i>Edit</a>
                                        <form action="process/process_delete_plan.php" method="post" class="d-inline">
                                            <input type="hidden" name="plan_id" value="<?php echo $s['plan_id']; ?>">
                                            <button type="submit" class="btn-outline-modern danger" onclick="return confirm('Delete this plan?');"><i class="bi bi-trash3 me-1"></i>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(empty($ser)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox me-2"></i>No service plans found
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
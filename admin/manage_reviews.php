<?php
session_start();
require_once "adminguard.php";
require_once "classes/Admin.php";
require_once "classes/Review.php";

$p = new Admin;
$user = $p->get_admin_byid($_SESSION["adminonline"]);

$rv = new Review;

$total_reviews = $rv->total_reviews();
$avg_rating    = $rv->average_rating();
$low_rated     = $rv->total_low_rated();

$filter = $_GET["filter"] ?? null; // null | 'low' | 'high'
$reviews = $rv->fetch_reviews($filter);

$review_to_view = null;
if(isset($_GET["view_id"])){
    $review_to_view = $rv->get_review($_GET["view_id"]);
}

// small helper to render star icons for a given rating
function render_stars($rating){
    $rating = (int) $rating;
    $html = '';
    for($i = 1; $i <= 5; $i++){
        $html .= $i <= $rating
            ? '<i class="bi bi-star-fill" style="color:#f5b342;"></i>'
            : '<i class="bi bi-star" style="color:#d0dae8;"></i>';
    }
    return $html;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin · Reviews</title>
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
        .stat-card .stat-icon.amber { background: #fdf2e3; color: #a3701a; }
        .stat-card .stat-icon.red { background: #fde8e8; color: #a04040; }
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

        .comment-preview {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            max-width: 380px;
            color: #4a617c;
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

        .view-card {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            padding: 2rem 2rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.02);
            margin-bottom: 2rem;
            border-left: 4px solid #f5b342;
        }
        .view-card .view-title {
            font-weight: 600;
            color: #1b2a40;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .view-card .view-title i {
            color: #f5b342;
        }
        .view-card .meta-label {
            font-weight: 500;
            color: #4a617c;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 0.2rem;
        }
        .view-card .meta-value {
            font-weight: 500;
            color: #1b2a40;
            margin-bottom: 1rem;
        }
        .view-card .comment-full {
            background: #fafcff;
            border: 1px solid #e4eaf2;
            border-radius: 16px;
            padding: 1rem 1.2rem;
            color: #1f3145;
            line-height: 1.6;
        }

        .filter-pills {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .filter-pill {
            border: 1px solid #d0dae8;
            background: #ffffff;
            border-radius: 40px;
            padding: 0.35rem 1rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: #4a617c;
            text-decoration: none;
        }
        .filter-pill:hover {
            background: #f2f6fc;
            color: #1a2639;
        }
        .filter-pill.active {
            background: #1a2639;
            border-color: #1a2639;
            color: #ffffff;
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
            .view-card {
                padding: 1.5rem 1rem;
            }
            .comment-preview {
                max-width: 160px;
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
                        <span>Reviews management</span>
                    </div>
                    <div class="admin-badge">
                        <i class="bi bi-shield-check me-1"></i> Administrator
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon blue"><i class="bi bi-chat-square-text-fill"></i></div>
                            <p class="stat-number"><?php echo $total_reviews; ?></p>
                            <p class="stat-label">Total Reviews</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon amber"><i class="bi bi-star-fill"></i></div>
                            <p class="stat-number"><?php echo number_format($avg_rating, 1); ?></p>
                            <p class="stat-label">Average Rating</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon red"><i class="bi bi-exclamation-triangle-fill"></i></div>
                            <p class="stat-number"><?php echo $low_rated; ?></p>
                            <p class="stat-label">Low Rated (&le;2&#9733;)</p>
                        </div>
                    </div>
                </div>

                <!-- Review Detail (if viewing) -->
                <?php if($review_to_view): ?>
                <div class="view-card mt-4">
                    <div class="view-title">
                        <i class="bi bi-chat-square-text"></i> Review Detail
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="meta-label">Client</div>
                            <div class="meta-value"><?php echo htmlspecialchars($review_to_view['reviewer_name']); ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="meta-label">Rating</div>
                            <div class="meta-value"><?php echo render_stars($review_to_view['rating']); ?></div>
                        </div>
                    </div>
                    <div class="meta-label mt-2">Message</div>
                    <div class="comment-full mb-3"><?php echo nl2br(htmlspecialchars($review_to_view['messages'])); ?></div>
                    <div class="text-end">
                        <a href="manage_reviews.php" class="btn-secondary-modern"><i class="bi bi-x-circle me-1"></i>Close</a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Reviews Table -->
                <div class="table-section">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="section-title">
                            <i class="bi bi-chat-square-text"></i> All Reviews
                        </div>
                        <div class="filter-pills">
                            <a href="manage_reviews.php" class="filter-pill <?php echo !$filter ? 'active' : ''; ?>">All</a>
                            <a href="manage_reviews.php?filter=high" class="filter-pill <?php echo $filter === 'high' ? 'active' : ''; ?>">4-5 Stars</a>
                            <a href="manage_reviews.php?filter=low" class="filter-pill <?php echo $filter === 'low' ? 'active' : ''; ?>">1-2 Stars</a>
                        </div>
                    </div>

                    <div class="table-responsive mt-2">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Rating</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reviews as $r){ ?>
                                <tr>
                                    <td><span class="fw-bold text-secondary">#<?php echo $r["review_id"]; ?></span></td>
                                    <td><span class="fw-medium"><?php echo htmlspecialchars($r["reviewer_name"]); ?></span></td>
                                    <td><?php echo render_stars($r["rating"]); ?></td>
                                    <td><div class="comment-preview"><?php echo htmlspecialchars($r["messages"]); ?></div></td>
                                    <td><?php echo date("M j, Y", strtotime($r["created_at"])); ?></td>
                                    <td class="text-center text-nowrap">
                                        <a href="manage_reviews.php?view_id=<?php echo $r['review_id']; ?>" class="btn-outline-modern primary"><i class="bi bi-eye me-1"></i>View</a>
                                        <form action="process/process_delete_review.php" method="post" class="d-inline">
                                            <input type="hidden" name="review_id" value="<?php echo $r['review_id']; ?>">
                                            <button type="submit" class="btn-outline-modern danger" onclick="return confirm('Delete this review? This cannot be undone.');"><i class="bi bi-trash3 me-1"></i>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(empty($reviews)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox me-2"></i>No reviews found
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

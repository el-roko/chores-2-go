

     <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            color: #fff;
        }
        .sidebar h4 {
            padding: 20px;
            border-bottom: 1px solid #495057;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            transition: 0.3s;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #495057;
            border-radius: 5px;
        }
        .dashboard-card {
            transition: transform 0.2s ease-in-out;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .notification i {
            position: relative;
        }
        .notification .badge {
            position: absolute;
            top: 22px;
            right: 160px;
            background: red;
        }
    </style>




        <?php if(isset($_SESSION["adminonline"])){ ?>

<div class="col-md-3 sidebar">
                <h4>Admin Panel</h4>
                <ul class="nav flex-column p-2">
                    <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="manage_client.php" class="nav-link"><i class="fa-solid fa-users me-2"></i> Manage Client</a></li>
                    <li class="nav-item"><a href="manage_keeper.php" class="nav-link"><i class="fa-solid fa-user-shield me-2"></i> Manage Keepers</a></li>
                    <li class="nav-item"><a href="manage_services.php" class="nav-link"><i class="fa-solid fa-gear me-2"></i> Manage Services</a></li>
                    <li class="nav-item"><a href="manage_bookings.php" class="nav-link"><i class="fa-solid fa-gear me-2"></i> Manage Bookings</a></li>
                    <li class="nav-item"><a href="manage_reviews.php" class="nav-link"><i class="fa-solid fa-gear me-2"></i> Manage review</a></li>
                    <li class="nav-item"><a href="manage_plan.php" class="nav-link"><i class="fa-solid fa-user-shield me-2"></i> Manage Plan</a></li>
                    <li class="nav-item"><a href="add_services_form.php" class="nav-link"><i class="fa-solid fa-gear me-2"></i> Add Services</a></li>
                    <li class="nav-item"><a href="add_services_plan_form.php" class="nav-link"><i class="fa-solid fa-gear me-2"></i> Add Plan</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>

             <!-- Main Content -->
            <div class="col-md-9 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Welcome, <?php echo $user["admin_fname"]; ?> 👋</h2>
                    <div>
                        <span class="notification me-3">
                            <i class="fa-solid fa-bell fa-2xl text-warning"></i>
                            <!-- <span class="badge text-light">42</span> -->
                        </span>
                        <span class="fw-bold"><?php echo $user["admin_fname"]. " ". $user["admin_lname"]; ?> <small class="text-muted">(Admin)</small></span>
                    </div>
                </div>

                     <?php } ?>
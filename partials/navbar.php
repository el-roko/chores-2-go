<?php
//  session_start();
// if(isset($role)){
$role = $_SESSION["role"] ?? "guest";
//}

?>

<div class="row my-3">
  <div class="col-md-12">
    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg bg-transparent px-0 py-2">
      <div class="container-fluid px-0">
        <a class="navbar-brand fw-bold" href="home.php" style="color:#1a2639; font-size:1.4rem; letter-spacing:-0.02em;">
          <i class="bi bi-house-heart-fill me-2" style="color:#2a3b5c;"></i>CHORES-2-GO
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                aria-label="Toggle navigation" style="padding:0.5rem 0.8rem; background:#eef3fa; border-radius:12px;">
          <span class="navbar-toggler-icon" style="font-size:0.9rem;"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto fw-500" style="gap:0.2rem;">

           <?php if(!isset($_SESSION["useronline"])) { ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php"><i class="bi bi-house me-1"></i>Welcome</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="reg.php"><i class="bi bi-person-plus me-1"></i>Register</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link active" href="home.php"><i class="bi bi-house-fill me-1"></i>Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.php"><i class="bi bi-info-circle me-1"></i>About</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="chat.php"><i class="bi bi-chat-dots me-1"></i>Chat</a>
            </li> -->

            <?php 
              if ($role === "client") {
                echo "<li class='nav-item'><a class='nav-link' href='select_service.php'><i class='bi bi-calendar-plus me-1'></i>Booking</a></li>";
                echo "<li class='nav-item'><a class='nav-link' href='client_profile.php'><i class='bi bi-person-circle me-1'></i>Profile</a></li>";
                // echo "<li class='nav-item'><a class='nav-link' href='services.php'><i class='bi bi-grid-3x3-gap-fill me-1'></i>Services</a></li>";
                echo "<li class='nav-item'><a class='nav-link' href='review.php'><i class='bi bi-star me-1'></i>Reviews</a></li>";
              } elseif ($role === "keeper") {
                echo "<li class='nav-item'><a class='nav-link' href='keeper_profile.php'><i class='bi bi-person-circle me-1'></i>Profile</a></li>";
                echo "<li class='nav-item'><a class='nav-link' href='add_kp_services.php'><i class='bi bi-plus-circle me-1'></i>Services</a></li>";
              }
            ?>

            <li class="nav-item">
              <a class="nav-link" href="#" style="color:#a04040;"><i class="bi bi-person me-1"></i><?php echo "$role";    ?></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="logout.php" style="color:#a04040;"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
            </li>
            
          <?php } ?>
                    <!-- Badge for logged in user's role -->
                <div class="ms-auto d-flex align-items-center">
                    <?php if ($role === 'client'): ?>
                      <span class="badge bg-primary rounded-pill">
                        <i class="bi bi-person-circle me-1"></i> Client
                      </span>
                    <?php elseif ($role === 'keeper'): ?>
                      <span class="badge bg-success rounded-pill">
                        <i class="bi bi-briefcase-fill me-1"></i> Keeper
                      </span>
                    <?php else: ?>
                      <span class="badge bg-secondary rounded-pill">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Guest
                      </span>
                    <?php endif; ?>
                  </div>

          </ul>
        </div>
      </div>
    </nav>
  </div>
</div>

<!-- Custom CSS -->
<style>
  /* Navbar styles matching the modern theme */
  .nav-link {
    position: relative;
    padding: 0.5rem 1rem;
    border-radius: 40px;
    font-weight: 500;
    color: #1e2a41 !important;
    transition: all 0.2s ease;
    font-size: 0.92rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }
  .nav-link i {
    font-size: 1rem;
    color: #4a617c;
    transition: color 0.2s ease;
  }
  .nav-link:hover {
    background: #eef3fa;
    color: #1a2639 !important;
    transform: translateY(-1px);
  }
  .nav-link:hover i {
    color: #1a2639;
  }
  .nav-link.active {
    background: #eef3fa;
    color: #1a2639 !important;
    font-weight: 600;
  }
  .nav-link.active i {
    color: #1a2639;
  }
  .navbar-brand {
    font-weight: 700;
    color: #1a2639;
  }
  .navbar-brand i {
    color: #2a3b5c;
  }
  .navbar-toggler:focus {
    box-shadow: none;
  }
  @media (max-width: 992px) {
    .nav-link {
      padding: 0.5rem 0.8rem;
      border-radius: 12px;
    }
    .navbar-nav {
      gap: 0.3rem !important;
      padding-top: 0.8rem;
    }
  }
</style>
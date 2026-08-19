<?php
session_start();
 require_once "userguard.php";
 require_once "partials/helper.php";

 require_once "classes/Client.php";
$cl = new Client;

$record = $cl->get_client_byid($_SESSION["useronline"]);
$reviews = $cl->fetch_reviews();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reviews · Chores-2-Go</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <?php require_once "partials/style.php"; ?>
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
      padding: 2rem 2rem;
      margin-bottom: 1.5rem;
    }
    .card-modern:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    }
    .review-card {
      background: #ffffff;
      border: none;
      border-radius: 24px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.03);
      padding: 1.8rem 2rem;
      margin-bottom: 1.5rem;
      transition: all 0.2s ease;
      border-left: 4px solid #2a3b5c;
    }
    .review-card:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
      transform: translateY(-2px);
    }
    .review-author {
      font-weight: 600;
      color: #1a2639;
    }
    .review-role {
      color: #4a617c;
      font-size: 0.85rem;
    }
    .star-rating {
      color: #f5b342;
      font-size: 1.1rem;
      letter-spacing: 2px;
    }
    .review-text {
      color: #1f3145;
      font-size: 0.98rem;
      line-height: 1.6;
      margin: 0.5rem 0 0.8rem;
    }
    .form-label {
      font-weight: 500;
      color: #1e2a41;
      font-size: 0.9rem;
      margin-bottom: 0.3rem;
    }
    .form-control, .form-select {
      border: 1px solid #e4eaf2;
      border-radius: 16px;
      padding: 0.7rem 1rem;
      font-size: 0.95rem;
      background: #fafcff;
      transition: 0.15s ease;
      box-shadow: none;
    }
    .form-control:focus, .form-select:focus {
      border-color: #2a3b5c;
      box-shadow: 0 0 0 4px rgba(42, 59, 92, 0.08);
      background: white;
    }
    textarea.form-control {
      border-radius: 16px;
      resize: vertical;
      min-height: 100px;
    }
    .btn-primary-modern {
      background: #1a2639;
      border: none;
      border-radius: 40px;
      padding: 0.7rem 2.5rem;
      font-weight: 600;
      color: white;
      transition: 0.15s ease;
      letter-spacing: 0.01em;
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
    .section-title {
      font-weight: 600;
      color: #1b2a40;
      letter-spacing: -0.01em;
    }
    .rating-summary {
      background: #f5f8fc;
      border-radius: 16px;
      padding: 1rem 1.5rem;
      display: inline-flex;
      align-items: center;
      gap: 0.8rem;
    }
    .rating-summary .big-number {
      font-size: 2rem;
      font-weight: 700;
      color: #1a2639;
    }
    @media (max-width: 768px) {
      .banner-modern { padding: 2rem 1rem; }
      .card-modern { padding: 1.5rem 1.2rem; }
      .review-card { padding: 1.2rem 1.2rem; }
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-4">

  <!-- Navbar  -->
  <?php  require_once "partials/navbar.php"; ?>


  <!-- Banner -->
  <div class="banner-modern">
    <h1 class="display-6 fw-bold">Customer Reviews</h1>
    <p class="lead fs-6">See what our clients say about Chores-2-Go</p>
    <?php require_once "partials/feedback.php"; ?>
  </div>

  <div class="container px-0">

    <!-- Rating Summary -->
    <div class="text-center mb-4">
      <div class="rating-summary">
        <span class="big-number">4.7</span>
        <div>
          <div class="star-rating">★★★★★</div>
          <span style="color:#4a617c; font-size:0.85rem;">Based on <?php echo $reviews["count"];  ?> reviews</span>
        </div>
      </div>
    </div>

    <!-- Review Submission Form -->
    <div class="card-modern">
      <h3 class="section-title mb-3">
        <i class="bi bi-pencil-square me-2" style="color:#2a3b5c;"></i>Leave a Review
      </h3>
      <form action="process/process_review.php" method="post">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="name" class="form-label"><i class="bi bi-person me-1"></i>Your Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo $record['client_fname'] . ' ' . $record['client_lname']; ?>" disabled>
            <input type="hidden" class="form-control" name="id" id="name" value="<?php echo $record['client_id'] ?>" >
          </div>
          <div class="col-md-6">
            <label for="rating" class="form-label"><i class="bi bi-star me-1"></i>Rating</label>
            <select class="form-select" name="rate" id="rating">
              <option value="5">★★★★★ (Excellent)</option>
              <option value="4">★★★★☆ (Good)</option>
              <option value="3">★★★☆☆ (Average)</option>
              <option value="2">★★☆☆☆ (Poor)</option>
              <option value="1">★☆☆☆☆ (Terrible)</option>
            </select>
          </div>
          <div class="col-12">
            <label for="review" class="form-label"><i class="bi bi-chat me-1"></i>Your Review</label>
            <textarea class="form-control" id="review" name="msg" rows="4" placeholder="Write your feedback..."></textarea>
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary-modern" name="btn">
              <i class="bi bi-send me-2"></i>Submit Review
            </button>
          </div>
        </div>
      </form>
    </div>

    <!-- Existing Reviews -->
        <?php foreach ($reviews["reviews"] as $rev): ?>
      <div class="review-card">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <?php  
              $rating = (int)$rev["rating"]; // cast ENUM string to integer
              if ($rating === 1): ?>
                <span class="star-rating">★☆☆☆☆ (Terrible)</span>
              <?php elseif ($rating === 2): ?>
                <span class="star-rating">★★☆☆☆ (Poor)</span>
              <?php elseif ($rating === 3): ?>
                <span class="star-rating">★★★☆☆ (Average)</span>
              <?php elseif ($rating === 4): ?>
                <span class="star-rating">★★★★☆ (Good)</span>
              <?php elseif ($rating === 5): ?>
                <span class="star-rating">★★★★★ (Excellent)</span>
              <?php endif; ?>
          </div>
        <span class="badge-soft" style="font-size:0.7rem;">
          <i class="bi bi-clock me-1"></i>
          <?php echo timeAgo($rev["created_at"]); ?>
        </span>

        </div>
        <p class="review-text"><?php echo htmlspecialchars($rev["messages"]); ?></p>
        <div>
          <span class="review-author">
            <?php echo htmlspecialchars($rev["client_fname"] . " " . $rev["client_lname"]); ?>
          </span>
          <span class="review-role"> · Client</span>
        </div>
      </div>
    <?php endforeach; ?>




    <!-- <div class="review-card">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="star-rating">★★★★★</span>
        </div>
        <span class="badge-soft" style="font-size:0.7rem;"><i class="bi bi-clock me-1"></i>2 weeks ago</span>
      </div>
      <p class="review-text">"Chores-2-Go has been a lifesaver! I booked a cleaner last minute and the service was excellent."</p>
      <div>
        <span class="review-author">Sarah O.</span>
        <span class="review-role"> · Client</span>
      </div>
    </div>

    <div class="review-card">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="star-rating">★★★★☆</span>
        </div>
        <span class="badge-soft" style="font-size:0.7rem;"><i class="bi bi-clock me-1"></i>1 month ago</span>
      </div>
      <p class="review-text">"Great service overall. The handyman fixed my leaking tap quickly. Will definitely use again."</p>
      <div>
        <span class="review-author">David K.</span>
        <span class="review-role"> · Client</span>
      </div>
    </div>

    <div class="review-card">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="star-rating">★★★★★</span>
        </div>
        <span class="badge-soft" style="font-size:0.7rem;"><i class="bi bi-clock me-1"></i>3 months ago</span>
      </div>
      <p class="review-text">"I love how easy it is to book chores online. Affordable and reliable every time."</p>
      <div>
        <span class="review-author">Amina L.</span>
        <span class="review-role"> · Client</span>
      </div>
    </div> -->

  </div> <!-- container -->

  <!-- Footer -->
  <?php require_once "partials/footer.php"; ?>
  

</div> <!-- container-fluid -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
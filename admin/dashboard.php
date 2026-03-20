<?php include 'includes/admin_header.php'; 

$tours_count = $pdo->query("SELECT COUNT(*) FROM tours")->fetchColumn();
$reviews_count = $pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
$bookings_count = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$taxi_count = $pdo->query("SELECT COUNT(*) FROM taxi_bookings")->fetchColumn();
?>
<h2 class="fw-bold mb-4">Dashboard Overview</h2>
<div class="row g-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white border-0 shadow p-4 text-center rounded-4">
            <i class="fas fa-map fs-1 mb-2 opacity-75"></i>
            <h2 class="fw-bold"><?php echo $tours_count; ?></h2>
            <p class="mb-0 fw-medium">Total Tours</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white border-0 shadow p-4 text-center rounded-4">
            <i class="fas fa-star fs-1 mb-2 opacity-75"></i>
            <h2 class="fw-bold"><?php echo $reviews_count; ?></h2>
            <p class="mb-0 fw-medium">Guest Reviews</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark border-0 shadow p-4 text-center rounded-4">
            <i class="fas fa-calendar-check fs-1 mb-2 opacity-75"></i>
            <h2 class="fw-bold"><?php echo $bookings_count; ?></h2>
            <p class="mb-0 fw-medium">Tour Bookings</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-dark border-0 shadow p-4 text-center rounded-4">
            <i class="fas fa-taxi fs-1 mb-2 opacity-75"></i>
            <h2 class="fw-bold"><?php echo $taxi_count; ?></h2>
            <p class="mb-0 fw-medium">Taxi Bookings</p>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

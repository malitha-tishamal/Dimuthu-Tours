<?php include 'includes/admin_header.php'; 

$tours_count = $pdo->query("SELECT COUNT(*) FROM tours")->fetchColumn();
$reviews_count = $pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
$bookings_count = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$taxi_count = $pdo->query("SELECT COUNT(*) FROM taxi_bookings")->fetchColumn();
$safari_count = $pdo->query("SELECT COUNT(*) FROM safari_destinations")->fetchColumn();
?>
<h2 class="fw-bold mb-4">Dashboard Overview</h2>
<div class="row g-4 row-cols-1 row-cols-md-3 row-cols-lg-5">
    <div class="col">
        <div class="card bg-primary text-white border-0 shadow p-3 text-center rounded-4 h-100">
            <i class="fas fa-map fs-2 mb-2 opacity-75"></i>
            <h3 class="fw-bold"><?php echo $tours_count; ?></h3>
            <p class="mb-0 small fw-medium">Total Tours</p>
        </div>
    </div>
    <div class="col">
        <div class="card bg-success text-white border-0 shadow p-3 text-center rounded-4 h-100">
            <i class="fas fa-star fs-2 mb-2 opacity-75"></i>
            <h3 class="fw-bold"><?php echo $reviews_count; ?></h3>
            <p class="mb-0 small fw-medium">Guest Reviews</p>
        </div>
    </div>
    <div class="col">
        <div class="card bg-warning text-dark border-0 shadow p-3 text-center rounded-4 h-100">
            <i class="fas fa-calendar-check fs-2 mb-2 opacity-75"></i>
            <h3 class="fw-bold"><?php echo $bookings_count; ?></h3>
            <p class="mb-0 small fw-medium">Tour Bookings</p>
        </div>
    </div>
    <div class="col">
        <div class="card bg-info text-dark border-0 shadow p-3 text-center rounded-4 h-100">
            <i class="fas fa-taxi fs-2 mb-2 opacity-75"></i>
            <h3 class="fw-bold"><?php echo $taxi_count; ?></h3>
            <p class="mb-0 small fw-medium">Taxi Bookings</p>
        </div>
    </div>
    <div class="col">
        <div class="card bg-secondary text-white border-0 shadow p-3 text-center rounded-4 h-100">
            <i class="fas fa-leaf fs-2 mb-2 opacity-75"></i>
            <h3 class="fw-bold"><?php echo $safari_count; ?></h3>
            <p class="mb-0 small fw-medium">Safaris</p>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

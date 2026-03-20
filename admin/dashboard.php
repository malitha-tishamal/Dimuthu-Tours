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

<div class="mt-5">
    <h4 class="fw-bold mb-4 text-dark"><i class="fas fa-tools me-2 text-primary"></i>Developer & Technical Support</h4>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#developerModal">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <img src="../assets/developer.jpg" class="rounded-circle shadow-sm border border-primary border-2" style="width: 100px; height: 100px; object-fit: cover;" alt="Developer">
                </div>
                <div class="col-md-6 mb-3 mb-md-0 text-center text-md-start">
                    <h4 class="fw-bold mb-1">Malitha Tishamal</h4>
                    <p class="text-primary fw-semibold mb-2">Systems Developer & Web Consultant</p>
                    <p class="text-muted small mb-0">For any technical issues, system updates, or new features, please contact the developer directly for priority support.</p>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <div class="d-flex flex-column gap-2">
                        <a href="https://wa.me/94785530992" target="_blank" class="btn btn-success fw-bold rounded-pill px-4 shadow-sm">
                            <i class="fab fa-whatsapp me-2"></i> WhatsApp Support
                        </a>
                        <div class="d-flex justify-content-center justify-content-md-end gap-2 mt-2">
                             <a href="http://malithatishamal.42web.io" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-globe"></i></a>
                             <a href="https://www.linkedin.com/in/malitha-tishamal" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

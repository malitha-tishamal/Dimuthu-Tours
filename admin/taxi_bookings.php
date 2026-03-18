<?php include 'includes/admin_header.php'; 

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['delete_taxi'])) {
        $id = $_POST['taxi_id'];
        $pdo->prepare("DELETE FROM taxi_bookings WHERE id=?")->execute([$id]);
        $msg = "Taxi booking deleted.";
    }
}

$bookings = $pdo->query("SELECT * FROM taxi_bookings ORDER BY date ASC")->fetchAll();
?>

<h2 class="fw-bold mb-4">Taxi Bookings</h2>

<?php if($msg): ?>
    <div class="alert alert-success py-2 w-50"><?php echo $msg; ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="ps-4">Req. Date</th>
                        <th>Name</th>
                        <th>Phone/WA</th>
                        <th>Vehicle Type</th>
                        <th class="pe-4 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bookings as $b): ?>
                    <tr>
                        <td class="ps-4 fw-bold text-primary"><?php echo date('M d, Y', strtotime($b['date'])); ?></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($b['name']); ?></td>
                        <td><i class="fas fa-phone-alt text-muted small me-2"></i><?php echo htmlspecialchars($b['phone']); ?></td>
                        <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($b['vehicle_type']); ?></span></td>
                        <td class="pe-4 text-end">
                            <form method="POST" onsubmit="return confirm('Delete this booking?');">
                                <input type="hidden" name="taxi_id" value="<?php echo $b['id']; ?>">
                                <button type="submit" name="delete_taxi" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

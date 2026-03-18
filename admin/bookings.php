<?php include 'includes/admin_header.php'; 

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['delete_booking'])) {
        $id = $_POST['booking_id'];
        $pdo->prepare("DELETE FROM bookings WHERE id=?")->execute([$id]);
        $msg = "Booking deleted successfully.";
    }
}

$bookings = $pdo->query("SELECT * FROM bookings ORDER BY id DESC")->fetchAll();
?>

<h2 class="fw-bold mb-4">Tour Bookings</h2>

<?php if($msg): ?>
    <div class="alert alert-success py-2 w-50"><?php echo $msg; ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="ps-4">Date Sub</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Tour Chosen</th>
                        <th>Message</th>
                        <th class="pe-4 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bookings as $b): ?>
                    <tr>
                        <td class="ps-4"><small class="text-muted"><?php echo date('M d, Y', strtotime($b['created_at'])); ?></small></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($b['name']); ?><br><small class="fw-normal text-muted"><?php echo htmlspecialchars($b['country']); ?></small></td>
                        <td>
                            <i class="fas fa-envelope text-muted"></i> <?php echo htmlspecialchars($b['email']); ?><br>
                            <i class="fab fa-whatsapp text-success"></i> <?php echo htmlspecialchars($b['whatsapp']); ?>
                        </td>
                        <td><span class="badge bg-primary"><?php echo htmlspecialchars($b['tour']); ?></span></td>
                        <td><small><?php echo htmlspecialchars(substr($b['message'], 0, 40)); ?>...</small></td>
                        <td class="pe-4 text-end">
                            <form method="POST" onsubmit="return confirm('Delete this booking?');">
                                <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                                <button type="submit" name="delete_booking" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
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

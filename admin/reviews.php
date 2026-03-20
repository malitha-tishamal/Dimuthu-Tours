<?php include 'includes/admin_header.php'; 

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve_review'])) {
        $id = $_POST['review_id'];
        $pdo->prepare("UPDATE reviews SET status='approved' WHERE id=?")->execute([$id]);
        $msg = "Review approved.";
    } elseif (isset($_POST['toggle_review'])) {
        $id = $_POST['review_id'];
        $new_status = $_POST['new_status'];
        $pdo->prepare("UPDATE reviews SET status=? WHERE id=?")->execute([$new_status, $id]);
        $msg = "Review status updated.";
    } elseif (isset($_POST['edit_review'])) {
        $id = $_POST['review_id'];
        $name = $_POST['name'];
        $country = $_POST['country'];
        $rating = $_POST['rating'];
        $message = $_POST['message'];
        $pdo->prepare("UPDATE reviews SET name=?, country=?, rating=?, message=? WHERE id=?")->execute([$name, $country, $rating, $message, $id]);
        $msg = "Review updated successfully.";
    } elseif (isset($_POST['delete_review'])) {
        $id = $_POST['review_id'];
        $pdo->prepare("DELETE FROM reviews WHERE id=?")->execute([$id]);
        $msg = "Review deleted.";
    }
}

$reviews = $pdo->query("SELECT * FROM reviews ORDER BY id DESC")->fetchAll();
?>

<h2 class="fw-bold mb-4">Manage Reviews</h2>

<?php if($msg): ?>
    <div class="alert alert-success py-2 w-50"><?php echo $msg; ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="ps-4">Name</th>
                        <th>Country</th>
                        <th>Rating</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th class="pe-4 text-end" style="min-width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($reviews as $r): ?>
                    <tr>
                        <td class="ps-4 fw-bold"><?php echo htmlspecialchars($r['name']); ?></td>
                        <td><?php echo htmlspecialchars($r['country']); ?></td>
                        <td class="text-warning">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <i class="fas fa-star <?php echo ($i <= $r['rating']) ? '' : 'text-muted opacity-25'; ?>"></i>
                            <?php endfor; ?>
                        </td>
                        <td><small><?php echo htmlspecialchars(substr($r['message'], 0, 50)); ?>...</small></td>
                        <td>
                            <?php if($r['status'] == 'approved'): ?>
                                <span class="badge bg-success">Approved</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-end">
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="review_id" value="<?php echo $r['id']; ?>">
                                <?php if($r['status'] == 'pending'): ?>
                                    <input type="hidden" name="new_status" value="approved">
                                    <button type="submit" name="toggle_review" class="btn btn-sm btn-success" title="Approve"><i class="fas fa-check"></i></button>
                                <?php else: ?>
                                    <input type="hidden" name="new_status" value="pending">
                                    <button type="submit" name="toggle_review" class="btn btn-sm btn-warning" title="Unapprove/Pending"><i class="fas fa-ban"></i></button>
                                <?php endif; ?>
                            </form>
                            
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editReviewModal<?php echo $r['id']; ?>" title="Edit"><i class="fas fa-edit"></i></button>

                            <form method="POST" class="d-inline" onsubmit="return confirm('Delete this review?');">
                                <input type="hidden" name="review_id" value="<?php echo $r['id']; ?>">
                                <button type="submit" name="delete_review" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($reviews as $r): ?>
<!-- Edit Review Modal -->
<div class="modal fade" id="editReviewModal<?php echo $r['id']; ?>" tabindex="-1">
  <div class="modal-dialog text-start">
    <form class="modal-content" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Edit Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="review_id" value="<?php echo $r['id']; ?>">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($r['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Country</label>
            <input type="text" name="country" class="form-control" value="<?php echo htmlspecialchars($r['country']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Rating</label>
            <div class="dropdown w-100">
                <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center py-2 rating-toggle-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <span class="selected-rating-text">
                        <?php 
                        for($i=1; $i<=5; $i++) {
                            echo '<i class="'.($i <= $r['rating'] ? 'fas' : 'far').' fa-star text-warning"></i>';
                        }
                        $labels = [5 => '5 - Excellent', 4 => '4 - Very Good', 3 => '3 - Average', 2 => '2 - Poor', 1 => '1 - Terrible'];
                        echo ' ' . $labels[$r['rating']];
                        ?>
                    </span>
                    <i class="fas fa-chevron-down small"></i>
                </button>
                <ul class="dropdown-menu w-100 shadow-sm border-0 mt-1 rounded-3">
                    <?php foreach($labels as $val => $text): ?>
                        <li><a class="dropdown-item py-2 admin-rating-opt" href="#" data-value="<?php echo $val; ?>">
                            <?php for($i=1; $i<=5; $i++) echo '<i class="'.($i <= $val ? 'fas' : 'far').' fa-star text-warning"></i>'; ?>
                            <?php echo ' ' . $text; ?>
                        </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <input type="hidden" name="rating" class="admin-final-rating" value="<?php echo $r['rating']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="4" required><?php echo htmlspecialchars($r['message']); ?></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="edit_review" class="btn btn-primary">Update Review</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const opts = document.querySelectorAll('.admin-rating-opt');
    opts.forEach(opt => {
        opt.addEventListener('click', function(e) {
            e.preventDefault();
            const val = this.getAttribute('data-value');
            const parent = this.closest('.mb-3');
            parent.querySelector('.admin-final-rating').value = val;
            parent.querySelector('.selected-rating-text').innerHTML = this.innerHTML;
        });
    });
});
</script>

<?php include 'includes/admin_footer.php'; ?>

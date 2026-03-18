<?php include 'includes/admin_header.php'; 

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['add_tour'])) {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $dur = $_POST['duration'];
        $img = $_POST['image_url']; // fallback
        
        if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
            $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $filename = uniqid().'.'.$ext;
            if(move_uploaded_file($_FILES['image_file']['tmp_name'], '../uploads/'.$filename)) {
                $img = 'uploads/'.$filename; // Relative to front-end index.php
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO tours (title, description, duration, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $desc, $dur, $img]);
        $msg = "Tour added successfully.";
    } elseif (isset($_POST['edit_tour'])) {
        $id = $_POST['tour_id'];
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $dur = $_POST['duration'];
        $img = $_POST['current_image'];
        
        if(!empty($_POST['image_url'])) {
            $img = $_POST['image_url'];
        }
        
        if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
            $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $filename = uniqid().'.'.$ext;
            if(move_uploaded_file($_FILES['image_file']['tmp_name'], '../uploads/'.$filename)) {
                $img = 'uploads/'.$filename;
            }
        }
        
        $stmt = $pdo->prepare("UPDATE tours SET title=?, description=?, duration=?, image=? WHERE id=?");
        $stmt->execute([$title, $desc, $dur, $img, $id]);
        $msg = "Tour updated successfully.";
    } elseif (isset($_POST['toggle_status'])) {
        $id = $_POST['tour_id'];
        $new_status = $_POST['new_status'];
        $pdo->prepare("UPDATE tours SET status=? WHERE id=?")->execute([$new_status, $id]);
        $msg = "Tour status updated.";
    } elseif (isset($_POST['delete_tour'])) {
        $id = $_POST['tour_id'];
        $pdo->prepare("DELETE FROM tours WHERE id=?")->execute([$id]);
        $msg = "Tour deleted successfully.";
    }
}

$tours = $pdo->query("SELECT * FROM tours ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Manage Tours</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTourModal"><i class="fas fa-plus me-2"></i>Add New Tour</button>
</div>

<?php if($msg): ?>
    <div class="alert alert-success"><?php echo $msg; ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="ps-4">Image</th>
                        <th>Title</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="pe-4 text-end" style="min-width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tours as $tour): ?>
                    <tr>
                        <td class="ps-4"><img src="../<?php echo htmlspecialchars($tour['image']); ?>" width="60" class="rounded shadow-sm" style="height: 40px; object-fit: cover;" onerror="this.src='<?php echo htmlspecialchars($tour['image']); ?>'"></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($tour['title']); ?></td>
                        <td><?php echo htmlspecialchars($tour['duration']); ?></td>
                        <td>
                            <?php if($tour['status'] == 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Disabled</span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-end">
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
                                <?php if($tour['status'] == 'active'): ?>
                                    <input type="hidden" name="new_status" value="disabled">
                                    <button type="submit" name="toggle_status" class="btn btn-sm btn-outline-warning" title="Disable"><i class="fas fa-ban"></i></button>
                                <?php else: ?>
                                    <input type="hidden" name="new_status" value="active">
                                    <button type="submit" name="toggle_status" class="btn btn-sm btn-outline-success" title="Activate"><i class="fas fa-check"></i></button>
                                <?php endif; ?>
                            </form>
                            
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTourModal<?php echo $tour['id']; ?>" title="Edit"><i class="fas fa-edit"></i></button>

                            <form method="POST" class="d-inline" onsubmit="return confirm('Delete this tour?');">
                                <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
                                <button type="submit" name="delete_tour" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($tours as $tour): ?>
<!-- Edit Modal -->
<div class="modal fade" id="editTourModal<?php echo $tour['id']; ?>" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content text-start" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Edit Tour</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="tour_id" value="<?php echo $tour['id']; ?>">
        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($tour['image']); ?>">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($tour['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Duration</label>
            <input type="text" name="duration" class="form-control" value="<?php echo htmlspecialchars($tour['duration']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($tour['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label>New Image Upload (Optional)</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label>New Image URL (Optional)</label>
            <input type="text" name="image_url" class="form-control" placeholder="https://...">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="edit_tour" class="btn btn-primary">Update Tour</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>

<!-- Add Modal -->
<div class="modal fade" id="addTourModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Add New Tour</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Duration</label>
            <input type="text" name="duration" class="form-control" placeholder="e.g. 5 Days / 4 Nights" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label>Image Upload</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
            <div class="form-text">OR provide an image URL below:</div>
        </div>
        <div class="mb-3">
            <label>Image URL</label>
            <input type="text" name="image_url" class="form-control" placeholder="https://...">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="add_tour" class="btn btn-primary">Save Tour</button>
      </div>
    </form>
  </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

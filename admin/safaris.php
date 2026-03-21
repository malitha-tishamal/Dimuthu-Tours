<?php include 'includes/admin_header.php'; 

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['add_safari'])) {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $img = $_POST['image_url']; // fallback
        
        if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
            $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $filename = 'safari_'.uniqid().'.'.$ext;
            if(move_uploaded_file($_FILES['image_file']['tmp_name'], '../uploads/'.$filename)) {
                $img = 'uploads/'.$filename;
            }
        }
        
        $stmt = $pdo->prepare("INSERT INTO safari_destinations (title, description, image) VALUES (?, ?, ?)");
        $stmt->execute([$title, $desc, $img]);
        $msg = "Safari destination added successfully.";
    } elseif (isset($_POST['edit_safari'])) {
        $id = $_POST['safari_id'];
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $img = $_POST['current_image'];
        
        if(!empty($_POST['image_url'])) {
            $img = $_POST['image_url'];
        }
        
        if(isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
            $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $filename = 'safari_'.uniqid().'.'.$ext;
            if(move_uploaded_file($_FILES['image_file']['tmp_name'], '../uploads/'.$filename)) {
                $img = 'uploads/'.$filename;
            }
        }
        
        $stmt = $pdo->prepare("UPDATE safari_destinations SET title=?, description=?, image=? WHERE id=?");
        $stmt->execute([$title, $desc, $img, $id]);
        $msg = "Safari destination updated successfully.";
    } elseif (isset($_POST['toggle_status'])) {
        $id = $_POST['safari_id'];
        $new_status = $_POST['new_status'];
        $pdo->prepare("UPDATE safari_destinations SET status=? WHERE id=?")->execute([$new_status, $id]);
        $msg = "Status updated.";
    } elseif (isset($_POST['delete_safari'])) {
        $id = $_POST['safari_id'];
        $pdo->prepare("DELETE FROM safari_destinations WHERE id=?")->execute([$id]);
        $msg = "Safari destination deleted successfully.";
    }
}

$safaris = $pdo->query("SELECT * FROM safari_destinations ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Manage Safari Destinations</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSafariModal"><i class="fas fa-plus me-2"></i>Add New Destination</button>
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
                        <th>Description</th>
                        <th>Status</th>
                        <th class="pe-4 text-end" style="min-width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($safaris as $s): ?>
                    <tr>
                        <td class="ps-4"><img src="../<?php echo htmlspecialchars($s['image']); ?>" width="60" class="rounded shadow-sm" style="height: 40px; object-fit: cover;" onerror="this.src='../assets/placeholder.jpg'"></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($s['title']); ?></td>
                        <td><?php echo htmlspecialchars(substr($s['description'], 0, 80)); ?>...</td>
                        <td>
                            <?php if($s['status'] == 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Disabled</span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-end">
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="safari_id" value="<?php echo $s['id']; ?>">
                                <?php if($s['status'] == 'active'): ?>
                                    <input type="hidden" name="new_status" value="disabled">
                                    <button type="submit" name="toggle_status" class="btn btn-sm btn-outline-warning" title="Disable"><i class="fas fa-ban"></i></button>
                                <?php else: ?>
                                    <input type="hidden" name="new_status" value="active">
                                    <button type="submit" name="toggle_status" class="btn btn-sm btn-outline-success" title="Activate"><i class="fas fa-check"></i></button>
                                <?php endif; ?>
                            </form>
                            
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editSafariModal<?php echo $s['id']; ?>" title="Edit"><i class="fas fa-edit"></i></button>

                            <form method="POST" class="d-inline" onsubmit="return confirm('Delete this destination?');">
                                <input type="hidden" name="safari_id" value="<?php echo $s['id']; ?>">
                                <button type="submit" name="delete_safari" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($safaris as $s): ?>
<!-- Edit Modal -->
<div class="modal fade" id="editSafariModal<?php echo $s['id']; ?>" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content text-start" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Edit Safari Destination</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="safari_id" value="<?php echo $s['id']; ?>">
        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($s['image']); ?>">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($s['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($s['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label>New Image Upload (Optional)</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label>New Image URL (Optional)</label>
            <input type="text" name="image_url" class="form-control" placeholder="assets/...">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="edit_safari" class="btn btn-primary">Update Destination</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>

<!-- Add Modal -->
<div class="modal fade" id="addSafariModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Add New Safari Destination</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label>Image Upload</label>
            <input type="file" name="image_file" class="form-control" accept="image/*">
            <div class="form-text">OR provide an image path/URL below:</div>
        </div>
        <div class="mb-3">
            <label>Image URL/Path</label>
            <input type="text" name="image_url" class="form-control" placeholder="assets/yala.png">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="add_safari" class="btn btn-primary">Save Destination</button>
      </div>
    </form>
  </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

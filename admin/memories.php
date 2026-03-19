<?php include 'includes/admin_header.php'; 

$msg = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['add_memory'])) {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $location = $_POST['location'];
        $date = $_POST['event_date'];
        
        try {
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("INSERT INTO travel_memories (title, description, location, event_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $desc, $location, $date]);
            $memory_id = $pdo->lastInsertId();
            
            // Handle multiple image uploads
            if(isset($_FILES['images'])) {
                $total_files = count($_FILES['images']['name']);
                for($i = 0; $i < min($total_files, 5); $i++) {
                    if($_FILES['images']['error'][$i] == 0) {
                        $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                        $filename = uniqid().'_'.$i.'.'.$ext;
                        $upload_path = '../assets/memories/' . $filename;
                        
                        if(move_uploaded_file($_FILES['images']['tmp_name'][$i], $upload_path)) {
                            $db_path = 'assets/memories/' . $filename;
                            $pdo->prepare("INSERT INTO memory_images (memory_id, image_path) VALUES (?, ?)")->execute([$memory_id, $db_path]);
                        }
                    }
                }
            }
            
            $pdo->commit();
            $msg = "Memory added successfully.";
        } catch (Exception $e) {
            if($pdo->inTransaction()) $pdo->rollBack();
            $error = "Failed to add memory: " . $e->getMessage();
        }
    } elseif (isset($_POST['edit_memory'])) {
        $id = $_POST['memory_id'];
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $location = $_POST['location'];
        $date = $_POST['event_date'];
        
        try {
            $stmt = $pdo->prepare("UPDATE travel_memories SET title=?, description=?, location=?, event_date=? WHERE id=?");
            $stmt->execute([$title, $desc, $location, $date, $id]);
            
            // Handle new image uploads (append if fewer than 5)
            if(isset($_FILES['images'])) {
                // Get current image count
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM memory_images WHERE memory_id = ?");
                $stmt->execute([$id]);
                $current_count = $stmt->fetchColumn();
                $remaining_slots = 5 - $current_count;
                
                $total_files = count($_FILES['images']['name']);
                for($i = 0; $i < min($total_files, $remaining_slots); $i++) {
                    if($_FILES['images']['error'][$i] == 0) {
                        $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                        $filename = uniqid().'_edit_'.$i.'.'.$ext;
                        $upload_path = '../assets/memories/' . $filename;
                        
                        if(move_uploaded_file($_FILES['images']['tmp_name'][$i], $upload_path)) {
                            $db_path = 'assets/memories/' . $filename;
                            $pdo->prepare("INSERT INTO memory_images (memory_id, image_path) VALUES (?, ?)")->execute([$id, $db_path]);
                        }
                    }
                }
            }
            $msg = "Memory updated successfully.";
        } catch (Exception $e) {
            $error = "Failed to update memory: " . $e->getMessage();
        }
    } elseif (isset($_POST['toggle_status'])) {
        $id = $_POST['memory_id'];
        $new_status = $_POST['new_status'];
        $pdo->prepare("UPDATE travel_memories SET status=? WHERE id=?")->execute([$new_status, $id]);
        $msg = "Memory " . ($new_status == 'active' ? 'enabled' : 'disabled') . " successfully.";
    } elseif (isset($_POST['delete_memory'])) {
        $id = $_POST['memory_id'];
        
        $images = $pdo->prepare("SELECT image_path FROM memory_images WHERE memory_id = ?");
        $images->execute([$id]);
        while($row = $images->fetch()) {
            if(file_exists('../' . $row['image_path'])) {
                unlink('../' . $row['image_path']);
            }
        }
        
        $pdo->prepare("DELETE FROM travel_memories WHERE id=?")->execute([$id]);
        $msg = "Memory deleted successfully.";
    } elseif (isset($_POST['delete_single_image'])) {
        $img_id = $_POST['image_id'];
        $stmt = $pdo->prepare("SELECT image_path FROM memory_images WHERE id = ?");
        $stmt->execute([$img_id]);
        $img = $stmt->fetch();
        if($img) {
            if(file_exists('../' . $img['image_path'])) {
                unlink('../' . $img['image_path']);
            }
            $pdo->prepare("DELETE FROM memory_images WHERE id = ?")->execute([$img_id]);
            $msg = "Image removed.";
        }
    }
}

$memories = $pdo->query("SELECT m.*, (SELECT image_path FROM memory_images WHERE memory_id = m.id LIMIT 1) as cover_image FROM travel_memories m ORDER BY id DESC")->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Travel Memories</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemoryModal"><i class="fas fa-plus me-2"></i>Add New Memory</button>
</div>

<?php if($msg): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo $msg; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>
<?php if($error): ?>
    <div class="alert alert-danger alert-dismissible fade show"><?php echo $error; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted">
                    <tr>
                        <th class="ps-4">Cover</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="pe-4 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($memories as $memory): ?>
                    <tr>
                        <td class="ps-4">
                            <?php if($memory['cover_image']): ?>
                                <img src="../<?php echo htmlspecialchars($memory['cover_image']); ?>" width="60" class="rounded shadow-sm" style="height: 40px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;"><i class="fas fa-image text-muted"></i></div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-bold"><?php echo htmlspecialchars($memory['title']); ?></td>
                        <td><?php echo htmlspecialchars($memory['location']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($memory['event_date'])); ?></td>
                        <td>
                            <?php if($memory['status'] == 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Disabled</span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-end">
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="memory_id" value="<?php echo $memory['id']; ?>">
                                <?php if($memory['status'] == 'active'): ?>
                                    <input type="hidden" name="new_status" value="disabled">
                                    <button type="submit" name="toggle_status" class="btn btn-sm btn-outline-warning" title="Disable"><i class="fas fa-ban"></i></button>
                                <?php else: ?>
                                    <input type="hidden" name="new_status" value="active">
                                    <button type="submit" name="toggle_status" class="btn btn-sm btn-outline-success" title="Enable"><i class="fas fa-check"></i></button>
                                <?php endif; ?>
                            </form>
                            
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editMemoryModal<?php echo $memory['id']; ?>" title="Edit"><i class="fas fa-edit"></i></button>
                            
                            <form method="POST" class="d-inline" onsubmit="return confirm('Delete this memory?');">
                                <input type="hidden" name="memory_id" value="<?php echo $memory['id']; ?>">
                                <button type="submit" name="delete_memory" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($memories as $memory): 
    $stmt = $pdo->prepare("SELECT * FROM memory_images WHERE memory_id = ?");
    $stmt->execute([$memory['id']]);
    $m_images = $stmt->fetchAll();
?>
<!-- Edit Modal -->
<div class="modal fade" id="editMemoryModal<?php echo $memory['id']; ?>" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Edit Travel Memory</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-start">
        <input type="hidden" name="memory_id" value="<?php echo $memory['id']; ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($memory['title']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($memory['location']); ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="event_date" class="form-control" value="<?php echo $memory['event_date']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($memory['description']); ?></textarea>
        </div>
        
        <label class="form-label">Current Images (Max 5)</label>
        <div class="row g-2 mb-3">
            <?php foreach($m_images as $img): ?>
            <div class="col-3 position-relative">
                <img src="../<?php echo $img['image_path']; ?>" class="img-fluid rounded border" style="height: 80px; width:100%; object-fit: cover;">
                <form method="POST" class="position-absolute top-0 end-0 p-1">
                    <input type="hidden" name="image_id" value="<?php echo $img['id']; ?>">
                    <button type="submit" name="delete_single_image" class="btn btn-danger btn-sm p-0 px-1 rounded-circle" title="Remove image">×</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if(count($m_images) < 5): ?>
        <div class="mb-3">
            <label class="form-label">Add Images (Remaining slots: <?php echo 5 - count($m_images); ?>)</label>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
        </div>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="edit_memory" class="btn btn-primary">Update Memory</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>

<!-- Add Modal -->
<div class="modal fade" id="addMemoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Add New Travel Memory</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. Amazing Day at Sigiriya" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" placeholder="e.g. Sigiriya, Sri Lanka" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="event_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Tell the story..." required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Images (Select up to 5 photos)</label>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
            <div class="form-text">You can hold Ctrl or Shift to select multiple images.</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="add_memory" class="btn btn-primary">Save Memory</button>
      </div>
    </form>
  </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

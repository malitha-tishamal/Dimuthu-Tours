<?php include 'includes/admin_header.php'; 

// Handle CRUD operations
$msg = '';
$err = '';

// Add Vehicle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_vehicle'])) {
    $name = $_POST['name'];
    $pax_count = $_POST['pax_count'];
    $icon_class = $_POST['icon_class'];
    
    $stmt = $pdo->prepare("INSERT INTO vehicles (name, pax_count, icon_class) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $pax_count, $icon_class])) {
        $msg = "Vehicle added successfully.";
    } else {
        $err = "Error adding vehicle.";
    }
}

// Edit Vehicle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_vehicle'])) {
    $id = $_POST['vehicle_id'];
    $name = $_POST['name'];
    $pax_count = $_POST['pax_count'];
    $icon_class = $_POST['icon_class'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE vehicles SET name=?, pax_count=?, icon_class=?, status=? WHERE id=?");
    if ($stmt->execute([$name, $pax_count, $icon_class, $status, $id])) {
        $msg = "Vehicle updated successfully.";
    } else {
        $err = "Error updating vehicle.";
    }
}

// Manage Images
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_images'])) {
    $v_id = $_POST['vehicle_id'];
    $upload_dir = '../uploads/vehicles/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $files = $_FILES['images'];
    $count = count($files['name']);
    
    // Check current image count
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM vehicle_images WHERE vehicle_id = ?");
    $stmt->execute([$v_id]);
    $current_count = $stmt->fetchColumn();
    
    if ($current_count + $count > 4) {
        $err = "Maximum 4 images allowed per vehicle.";
    } else {
        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] == 0) {
                $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                $filename = 'v_' . $v_id . '_' . time() . '_' . $i . '.' . $ext;
                $target = $upload_dir . $filename;
                
                if (move_uploaded_file($files['tmp_name'][$i], $target)) {
                    $stmt = $pdo->prepare("INSERT INTO vehicle_images (vehicle_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$v_id, 'uploads/vehicles/' . $filename]);
                }
            }
        }
        $msg = "Images uploaded successfully.";
    }
}

// Delete Image
if (isset($_GET['delete_image'])) {
    $img_id = $_GET['delete_image'];
    $stmt = $pdo->prepare("SELECT image_path FROM vehicle_images WHERE id = ?");
    $stmt->execute([$img_id]);
    $img = $stmt->fetch();
    if ($img) {
        @unlink('../' . $img['image_path']);
        $stmt = $pdo->prepare("DELETE FROM vehicle_images WHERE id = ?");
        $stmt->execute([$img_id]);
        $msg = "Image deleted.";
    }
}

// Fetch Vehicles
$stmt = $pdo->query("SELECT * FROM vehicles ORDER BY id ASC");
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($vehicles as &$v) {
    $stmt = $pdo->prepare("SELECT * FROM vehicle_images WHERE vehicle_id = ?");
    $stmt->execute([$v['id']]);
    $v['images'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0 text-dark">Manage Vehicles</h2>
    <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
        <i class="fas fa-plus me-2"></i>Add New Vehicle
    </button>
</div>

<?php if($msg): ?><div class="alert alert-success alert-dismissible fade show"><?php echo $msg; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
<?php if($err): ?><div class="alert alert-danger alert-dismissible fade show"><?php echo $err; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

<div class="row g-4">
    <?php foreach($vehicles as $v): ?>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="bg-light p-3 rounded-circle text-primary border shadow-sm">
                        <i class="<?php echo $v['icon_class']; ?> fs-3"></i>
                    </div>
                    <span class="badge <?php echo $v['status'] == 'active' ? 'bg-success' : 'bg-danger'; ?> rounded-pill">
                        <?php echo ucfirst($v['status']); ?>
                    </span>
                </div>
                <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($v['name']); ?></h5>
                <p class="text-muted small mb-3"><?php echo htmlspecialchars($v['pax_count']); ?></p>
                
                <h6 class="fw-bold small text-uppercase text-muted mb-2 tracking-wide">Vehicle Gallery (<?php echo count($v['images']); ?>/4)</h6>
                <div class="d-flex gap-2 mb-4">
                    <?php foreach($v['images'] as $img): ?>
                        <div class="position-relative">
                            <img src="../<?php echo $img['image_path']; ?>" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                            <a href="?delete_image=<?php echo $img['id']; ?>" class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger border border-light p-1" onclick="return confirm('Delete this image?')">
                                <i class="fas fa-times fs-small"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <?php if(count($v['images']) < 4): ?>
                        <button class="btn btn-light border border-dashed rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;" data-bs-toggle="modal" data-bs-target="#uploadModal<?php echo $v['id']; ?>">
                            <i class="fas fa-camera text-muted"></i>
                        </button>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm flex-grow-1 rounded-pill" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $v['id']; ?>"><i class="fas fa-edit me-1"></i> Edit Details</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal<?php echo $v['id']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Edit Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body p-4">
                        <input type="hidden" name="vehicle_id" value="<?php echo $v['id']; ?>">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Vehicle Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($v['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Pax Count / Capacity</label>
                            <input type="text" name="pax_count" class="form-control" value="<?php echo htmlspecialchars($v['pax_count']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Icon Class (FontAwesome)</label>
                            <input type="text" name="icon_class" class="form-control" value="<?php echo htmlspecialchars($v['icon_class']); ?>" required>
                            <small class="text-muted">e.g. fas fa-car, fas fa-shuttle-van</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" <?php echo $v['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo $v['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" name="edit_vehicle" class="btn btn-primary w-100 fw-bold rounded-pill py-2">Update Vehicle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Upload Images Modal -->
    <div class="modal fade" id="uploadModal<?php echo $v['id']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Upload Vehicle Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <input type="hidden" name="vehicle_id" value="<?php echo $v['id']; ?>">
                        <div class="bg-light p-4 rounded-3 text-center mb-3">
                            <i class="fas fa-cloud-upload-alt fs-1 text-primary opacity-50 mb-3"></i>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                            <p class="text-muted small mt-2 mb-0">Select up to <?php echo 4 - count($v['images']); ?> images</p>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" name="upload_images" class="btn btn-primary w-100 fw-bold rounded-pill py-2">Upload Gallery</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addVehicleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Add New Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Vehicle Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Luxury Mini Van" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pax Count / Capacity</label>
                        <input type="text" name="pax_count" class="form-control" placeholder="e.g. Max 6 pax" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Icon Class (FontAwesome)</label>
                        <input type="text" name="icon_class" class="form-control" placeholder="e.g. fas fa-shuttle-van" required>
                        <small class="text-muted">Icons: fas fa-car, fas fa-shuttle-van, fas fa-bus, fas fa-bus-alt</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" name="add_vehicle" class="btn btn-primary w-100 fw-bold rounded-pill py-2">Add Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

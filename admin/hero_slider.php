<?php include 'includes/admin_header.php'; 

$msg = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['add_slide'])) {
        $count_stmt = $pdo->query("SELECT COUNT(*) FROM hero_slides");
        $count = $count_stmt->fetchColumn();
        
        if($count >= 10) {
            $error = "Maximum 10 slides allowed.";
        } else {
            if(isset($_FILES['slide_image']) && $_FILES['slide_image']['error'] == 0) {
                $ext = pathinfo($_FILES['slide_image']['name'], PATHINFO_EXTENSION);
                $filename = 'hero_' . uniqid() . '.' . $ext;
                $upload_path = '../assets/hero/' . $filename;
                
                if(move_uploaded_file($_FILES['slide_image']['tmp_name'], $upload_path)) {
                    $db_path = 'assets/hero/' . $filename;
                    $stmt = $pdo->prepare("INSERT INTO hero_slides (image_path) VALUES (?)");
                    $stmt->execute([$db_path]);
                    $msg = "Slide added successfully.";
                } else {
                    $error = "Failed to upload image.";
                }
            } elseif(!empty($_POST['image_url'])) {
                $stmt = $pdo->prepare("INSERT INTO hero_slides (image_path) VALUES (?)");
                $stmt->execute([$_POST['image_url']]);
                $msg = "Slide added successfully.";
            } else {
                $error = "Please provide an image.";
            }
        }
    } elseif(isset($_POST['delete_slide'])) {
        $id = $_POST['slide_id'];
        $stmt = $pdo->prepare("SELECT image_path FROM hero_slides WHERE id = ?");
        $stmt->execute([$id]);
        $slide = $stmt->fetch();
        
        if($slide) {
            if(strpos($slide['image_path'], 'assets/hero/') === 0 && file_exists('../' . $slide['image_path'])) {
                unlink('../' . $slide['image_path']);
            }
            $pdo->prepare("DELETE FROM hero_slides WHERE id = ?")->execute([$id]);
            $msg = "Slide removed.";
        }
    }
}

$slides = $pdo->query("SELECT * FROM hero_slides ORDER BY id DESC")->fetchAll();

// Seed data if empty
if(empty($slides)) {
    $defaults = [
        'https://images.unsplash.com/photo-1588219463991-630e2f5ff50b?q=80&w=1920', // Sigiriya
        'https://images.unsplash.com/photo-1565463776510-85f269389e17?q=80&w=1920', // Ella
        'https://images.unsplash.com/photo-1590429780187-b64936d52f6f?q=80&w=1920', // 9 Arch
        'https://images.unsplash.com/photo-1620619767323-b95a89182313?q=80&w=1920', // Galle
        'https://images.unsplash.com/photo-1544070078-a212eda27b49?q=80&w=1920'  // Beach
    ];
    foreach($defaults as $url) {
        $pdo->prepare("INSERT INTO hero_slides (image_path) VALUES (?)")->execute([$url]);
    }
    header("Location: hero_slider.php");
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Hero Slider Management</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSlideModal"><i class="fas fa-plus me-2"></i>Add New Slide</button>
</div>

<?php if($msg): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo $msg; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>
<?php if($error): ?>
    <div class="alert alert-danger alert-dismissible fade show"><?php echo $error; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="row g-4">
    <?php foreach($slides as $slide): ?>
    <div class="col-md-4 col-lg-3">
        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative group">
            <img src="../<?php echo htmlspecialchars($slide['image_path']); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" onerror="this.src='<?php echo htmlspecialchars($slide['image_path']); ?>'">
            <div class="card-body p-2 text-center">
                <form method="POST" onsubmit="return confirm('Remove this slide?');">
                    <input type="hidden" name="slide_id" value="<?php echo $slide['id']; ?>">
                    <button type="submit" name="delete_slide" class="btn btn-danger btn-sm w-100 rounded-pill"><i class="fas fa-trash me-2"></i>Remove</button>
                </form>
            </div>
            <div class="position-absolute top-0 end-0 p-2 opacity-0 group-hover-opacity-100 transition-all">
                 <span class="badge bg-dark rounded-pill">#<?php echo $slide['id']; ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
.group:hover .group-hover-opacity-100 { opacity: 1 !important; }
.transition-all { transition: all 0.3s ease; }
</style>

<!-- Add Modal -->
<div class="modal fade" id="addSlideModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Add Hero Slide</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Upload Local Image</label>
            <input type="file" name="slide_image" class="form-control" accept="image/*">
            <div class="form-text">Best size: 1920x1080px</div>
        </div>
        <div class="text-center my-2 text-muted">- OR -</div>
        <div class="mb-3">
            <label class="form-label">Image URL</label>
            <input type="text" name="image_url" class="form-control" placeholder="https://images.unsplash.com/...">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="add_slide" class="btn btn-primary">Save Slide</button>
      </div>
    </form>
  </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

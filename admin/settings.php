<?php include 'includes/admin_header.php'; 

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_settings'])) {
    $stmt = $pdo->prepare("UPDATE site_settings SET value=? WHERE key_name=?");
    $stmt->execute([$_POST['hero_title'], 'hero_title']);
    $stmt->execute([$_POST['hero_subtitle'], 'hero_subtitle']);
    $stmt->execute([$_POST['phone1'], 'phone1']);
    $stmt->execute([$_POST['phone2'], 'phone2']);
    $stmt->execute([$_POST['email'], 'email']);
    $stmt->execute([$_POST['whatsapp'], 'whatsapp']);
    $stmt->execute([$_POST['about_text'], 'about_text']);
    
    $msg = "Settings updated successfully.";
}

$stmt = $pdo->query("SELECT * FROM site_settings");
$raw = $stmt->fetchAll();
$s = [];
foreach($raw as $r) {
    $s[$r['key_name']] = $r['value'];
}
?>

<h2 class="fw-bold mb-4">Site Settings</h2>

<?php if($msg): ?>
    <div class="alert alert-success py-2 w-75"><?php echo $msg; ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 w-75">
    <div class="card-body p-4">
        <form method="POST">
            <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Hero Section</h5>
            <div class="mb-3">
                <label class="form-label">Hero Title</label>
                <input type="text" name="hero_title" class="form-control" value="<?php echo htmlspecialchars($s['hero_title']); ?>" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Hero Subtitle</label>
                <input type="text" name="hero_subtitle" class="form-control" value="<?php echo htmlspecialchars($s['hero_subtitle']); ?>" required>
            </div>
            
            <h5 class="fw-bold mb-3 mt-4 text-primary border-bottom pb-2">Contact Details</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Phone 1 (Call Link)</label>
                    <input type="text" name="phone1" class="form-control" value="<?php echo htmlspecialchars($s['phone1']); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone 2</label>
                    <input type="text" name="phone2" class="form-control" value="<?php echo htmlspecialchars($s['phone2']); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($s['email']); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">WhatsApp Number (For Link)</label>
                    <input type="text" name="whatsapp" class="form-control" value="<?php echo htmlspecialchars($s['whatsapp']); ?>">
                    <small class="text-muted">Include country code without +, e.g. 94711635975</small>
                </div>
            </div>
            
            <h5 class="fw-bold mb-3 mt-4 text-primary border-bottom pb-2">About Us Section</h5>
            <div class="mb-4">
                <label class="form-label">About Text</label>
                <textarea name="about_text" class="form-control" rows="4"><?php echo htmlspecialchars($s['about_text']); ?></textarea>
            </div>
            
            <button type="submit" name="update_settings" class="btn btn-success px-5 fw-bold"><i class="fas fa-save me-2"></i>Save Settings</button>
        </form>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

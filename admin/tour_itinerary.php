<?php include 'includes/admin_header.php'; 

if (!isset($_GET['tour_id'])) {
    header("Location: tours.php");
    exit;
}

$tour_id = $_GET['tour_id'];

// Fetch Tour Details
$stmt = $pdo->prepare("SELECT title FROM tours WHERE id = ?");
$stmt->execute([$tour_id]);
$tour = $stmt->fetch();

if (!$tour) {
    header("Location: tours.php");
    exit;
}

$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['add_day'])) {
        $day_number = $_POST['day_number'];
        $title = $_POST['title'];
        $desc = $_POST['description'];
        
        $stmt = $pdo->prepare("INSERT INTO tour_days (tour_id, day_number, title, description) VALUES (?, ?, ?, ?)");
        $stmt->execute([$tour_id, $day_number, $title, $desc]);
        $msg = "Day added successfully.";
    } elseif (isset($_POST['edit_day'])) {
        $id = $_POST['day_id'];
        $day_number = $_POST['day_number'];
        $title = $_POST['title'];
        $desc = $_POST['description'];
        
        $stmt = $pdo->prepare("UPDATE tour_days SET day_number=?, title=?, description=? WHERE id=?");
        $stmt->execute([$day_number, $title, $desc, $id]);
        $msg = "Day updated successfully.";
    } elseif (isset($_POST['delete_day'])) {
        $id = $_POST['day_id'];
        $pdo->prepare("DELETE FROM tour_days WHERE id=?")->execute([$id]);
        $msg = "Day deleted successfully.";
    }
}

$days = $pdo->prepare("SELECT * FROM tour_days WHERE tour_id = ? ORDER BY day_number ASC");
$days->execute([$tour_id]);
$itinerary = $days->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="tours.php">Tours</a></li>
                <li class="breadcrumb-item active">Itinerary</li>
            </ol>
        </nav>
        <h2 class="fw-bold mb-0">Itinerary: <?php echo htmlspecialchars($tour['title']); ?></h2>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDayModal"><i class="fas fa-plus me-2"></i>Add New Day</button>
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
                        <th class="ps-4" style="width: 100px;">Day</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th class="pe-4 text-end" style="min-width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($itinerary as $day): ?>
                    <tr>
                        <td class="ps-4 fw-bold">Day <?php echo htmlspecialchars($day['day_number']); ?></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($day['title']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars(substr($day['description'], 0, 100))); ?>...</td>
                        <td class="pe-4 text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editDayModal<?php echo $day['id']; ?>" title="Edit"><i class="fas fa-edit"></i></button>

                            <form method="POST" class="d-inline" onsubmit="return confirm('Delete this day?');">
                                <input type="hidden" name="day_id" value="<?php echo $day['id']; ?>">
                                <button type="submit" name="delete_day" class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($itinerary)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No itinerary days added yet.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php foreach($itinerary as $day): ?>
<!-- Edit Modal -->
<div class="modal fade" id="editDayModal<?php echo $day['id']; ?>" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content text-start" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Edit Day <?php echo $day['day_number']; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="day_id" value="<?php echo $day['id']; ?>">
        <div class="mb-3">
            <label>Day Number</label>
            <input type="number" name="day_number" class="form-control" value="<?php echo htmlspecialchars($day['day_number']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($day['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="6" required><?php echo htmlspecialchars($day['description']); ?></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="edit_day" class="btn btn-primary">Update Day</button>
      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>

<!-- Add Modal -->
<div class="modal fade" id="addDayModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST">
      <div class="modal-header">
        <h5 class="modal-title">Add New Day</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label>Day Number</label>
            <input type="number" name="day_number" class="form-control" value="<?php echo count($itinerary) + 1; ?>" required>
        </div>
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Arrival and City Tour" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="6" placeholder="Details of the day's activities..." required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="add_day" class="btn btn-primary">Save Day</button>
      </div>
    </form>
  </div>
</div>

<?php include 'includes/admin_footer.php'; ?>

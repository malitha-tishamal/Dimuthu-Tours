<?php
session_start();
require_once '../includes/db.php';

$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();
    
    if($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Dimu Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; height: 100vh; display: flex; align-items: center; }
        .login-card { max-width: 400px; width: 100%; margin: auto; border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="card login-card p-4">
        <h3 class="text-center mb-4 fw-bold">Dimu Admin Login</h3>
        <?php if($error): ?>
            <div class="alert alert-danger py-2"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required value="admin@dimutours.com">
            </div>
            <div class="mb-4">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required value="password123">
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="../index.php" class="text-secondary text-decoration-none">&larr; Back to Website</a>
        </div>
    </div>
</body>
</html>

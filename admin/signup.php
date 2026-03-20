<?php
session_start();
require_once '../includes/db.php';

// If already logged in, redirect to dashboard
if(isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Simple validation
    if(empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->fetchColumn() > 0) {
            $error = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admins (email, password) VALUES (?, ?)");
            if($stmt->execute([$email, $hashed_password])) {
                $success = "Account created successfully! <a href='login.php' class='fw-bold'>Login here</a>";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup - Dimu Tours</title>
    <link rel="icon" type="image/jpeg" href="../assets/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0d6efd;
            --glass-bg: rgba(255, 255, 255, 0.82);
            --glass-border: rgba(255, 255, 255, 0.5);
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1600');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }
        .signup-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo-box {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .logo-box img { width: 100%; height: 100%; object-fit: cover; }
        .form-control {
            border-radius: 12px;
            padding: 10px 16px;
            border: 1px solid #ddd;
            background: rgba(255,255,255,0.9);
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
            border-color: var(--primary);
        }
        .btn-signup {
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
        }
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }
    </style>
</head>
<body>

    <div class="signup-card">
        <div class="logo-box">
            <img src="../assets/logo.jpg" alt="Logo">
        </div>
        <h3 class="text-center mb-1 fw-bold text-dark">Create Admin</h3>
        <p class="text-center text-muted mb-4 small">Add a new administrator account</p>

        <?php if($error): ?>
            <div class="alert alert-danger border-0 rounded-3 small py-2 mb-4"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success border-0 rounded-3 small py-2 mb-4"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold text-dark">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@example.com" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label small fw-bold text-dark">Password</label>
                <div class="position-relative">
                    <input type="password" name="password" id="p1" class="form-control" placeholder="Create password" required>
                    <i class="fas fa-eye password-toggle" onclick="toggle('p1', this)"></i>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-dark">Confirm Password</label>
                <div class="position-relative">
                    <input type="password" name="confirm_password" id="p2" class="form-control" placeholder="Repeat password" required>
                    <i class="fas fa-eye password-toggle" onclick="toggle('p2', this)"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-signup">Register Admin</button>
        </form>

        <div class="text-center mt-4 pt-2">
            <p class="small text-muted mb-0">Already have an account? <a href="login.php" class="text-primary fw-bold text-decoration-none">Sign In</a></p>
        </div>
    </div>

    <script>
        function toggle(id, el) {
            const input = document.getElementById(id);
            if (input.type === 'password') {
                input.type = 'text';
                el.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                el.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>

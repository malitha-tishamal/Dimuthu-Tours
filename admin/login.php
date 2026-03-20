<?php
session_start();
require_once '../includes/db.php';

// If already logged in, redirect to dashboard
if(isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Dimu Tours</title>
    <link rel="icon" type="image/jpeg" href="../assets/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0d6efd;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.5);
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1506012733851-bc911ca0f47e?w=1600');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }
        .login-card {
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
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #ddd;
            background: rgba(255,255,255,0.9);
            transition: all 0.3s;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
            border-color: var(--primary);
        }
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            transition: color 0.3s;
        }
        .password-toggle:hover { color: var(--primary); }
        .btn-login {
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(13, 110, 253, 0.4);
        }
        .links a {
            color: #555;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        .links a:hover { color: var(--primary); }
        .divider {
            height: 1px;
            background: rgba(0,0,0,0.1);
            margin: 24px 0;
            position: relative;
        }
        .divider::after {
            content: 'OR';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--glass-bg);
            padding: 0 10px;
            color: #888;
            font-size: 0.75rem;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-box">
            <img src="../assets/logo.jpg" alt="Logo">
        </div>
        <h3 class="text-center mb-1 fw-bold text-dark">Welcome Back</h3>
        <p class="text-center text-muted mb-4">Dimu Tours Admin Portal</p>

        <?php if($error): ?>
            <div class="alert alert-danger border-0 rounded-3 small py-2 mb-4 animate__animated animate__shakeX">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold text-dark">Email Address</label>
                <div class="position-relative">
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required value="admin@dimutours.com">
                </div>
            </div>
            
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label small fw-bold text-dark">Password</label>
                    <a href="forgot-password.php" class="small text-primary text-decoration-none fw-semibold">Forgot?</a>
                </div>
                <div class="position-relative">
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Enter your password" required value="password123">
                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-login mt-2">Sign In</button>
        </form>

        <div class="divider"></div>

        <div class="text-center links">
            <p class="small text-muted mb-2">New here? <a href="signup.php" class="text-primary">Create an account</a></p>
            <a href="../index.php" class="small"><i class="fas fa-arrow-left me-1"></i> Back to Website</a>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#passwordInput');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>

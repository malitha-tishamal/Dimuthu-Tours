<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Dimu Tours</title>
    <link rel="icon" type="image/jpeg" href="../assets/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1600');
            background-size: cover; background-position: center;
            height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0;
        }
        .recover-card {
            background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(15px);
            border-radius: 24px; padding: 40px; width: 100%; max-width: 440px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); text-center;
        }
        .icon-circle {
            width: 80px; height: 80px; background: #e7f1ff; color: #0d6efd;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px; font-size: 2rem;
        }
        .btn-wa {
            background: #25D366; color: white; border: none; border-radius: 12px;
            padding: 14px; font-weight: 700; transition: all 0.3s;
        }
        .btn-wa:hover { background: #128C7E; color: white; transform: translateY(-2px); }
    </style>
</head>
<body>

    <div class="recover-card text-center">
        <div class="icon-circle">
            <i class="fas fa-key"></i>
        </div>
        <h3 class="fw-bold text-dark mb-2">Forgot Password?</h3>
        <p class="text-muted mb-4">Password recovery is handled manually for security. Please contact the system developer to reset your access.</p>

        <div class="bg-white p-4 rounded-4 border border-light shadow-sm mb-4 text-start">
            <div class="d-flex align-items-center mb-3">
                <img src="../assets/developer.jpg" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;" alt="Developer">
                <div>
                    <h6 class="fw-bold mb-0">Malitha Tishamal</h6>
                    <small class="text-primary">System Developer</small>
                </div>
            </div>
            <p class="small text-muted mb-0">Click the button below to send a reset request via WhatsApp. Please provide your registered email address.</p>
        </div>

        <a href="https://wa.me/94785530992?text=Hi Malitha, I forgot my admin password for Dimu Tours. My email is: " target="_blank" class="btn btn-wa w-100 mb-3 shadow">
            <i class="fab fa-whatsapp me-2"></i> Contact Developer
        </a>

        <a href="login.php" class="text-decoration-none small fw-bold text-muted"><i class="fas fa-arrow-left me-1"></i> Back to Login</a>
    </div>

</body>
</html>

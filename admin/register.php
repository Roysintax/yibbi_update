<?php
session_start();
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Semua field harus diisi!";
    } elseif ($password !== $confirm_password) {
        $error = "Password tidak cocok!";
    } else {
        try {
            // Check if email or username exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $stmt->execute([$email, $username]);
            
            if ($stmt->fetch()) {
                $error = "Username atau Email sudah terdaftar!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                
                if ($stmt->execute([$username, $email, $hashed_password])) {
                    $success = "Registrasi berhasil! Silakan login.";
                } else {
                    $error = "Gagal mendaftar!";
                }
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Admin Registration - YIBBI</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/x-icon/01.png">

    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/icofont.min.css">
    <link rel="stylesheet" href="../assets/css/lightcase.css">
    <link rel="stylesheet" href="../assets/css/swiper.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: #f9f9f9;
        }
        .account-wrapper {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>

    <!-- Registration section start Here -->
    <div class="login-section padding-tb">
        <div class="container">
            <div class="account-wrapper">
                <h3 class="title">Register Admin</h3>
                
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?> <a href="login.php">Login disini</a>
                    </div>
                <?php endif; ?>

                <form class="account-form" method="POST" action="">
                    <div class="form-group">
                        <input type="text" placeholder="User Name" name="username" required>
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Password" name="password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Confirm Password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <button class="d-block lab-btn"><span>Register Now</span></button>
                    </div>
                </form>
                <div class="account-bottom">
                    <span class="d-block cate pt-10">Already have an account? <a href="login.php">Login</a></span>
                </div>
            </div>
        </div>
    </div>
    <!-- Registration section end Here -->

    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/fontawesome.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
require_once '../config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page_title = 'Confirmation - ' . $site_title;

if ($mysqli->connect_error) {
    die("Failed to connect to the database: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['password']) || !isset($_POST['confirm_password'])) {
        echo "<script>alert('The password field is missing！');</script>";
        exit();
    }

    if ($_POST['password'] !== $_POST['confirm_password']) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit();
    }

    $username    = trim($_POST['username']);
    $first_name  = trim($_POST['first_name']);
    $last_name   = trim($_POST['last_name']);
    $email       = trim($_POST['email']);
    $phone       = trim($_POST['phone']);
    $password    = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO users (username, first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo "<script>alert('Preprocessing failure: " . $mysqli->error . "');</script>";
        exit();
    }

    $stmt->bind_param("ssssss", $username, $first_name, $last_name, $email, $phone, $password);

    if ($stmt->execute()) {
        // 获取插入后的用户 ID
        $user_id = $mysqli->insert_id;
    
        // 设置 session，使用户自动登录
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
    
        echo "<script>alert('Register Successful! Welcome $username！'); window.location.href = '../index.php';</script>";
        exit();
    } else {
        if (strpos($stmt->error, 'Duplicate') !== false) {
            echo "<script>alert('The email has been existed, please try another email address!');</script>";
        } else {
            echo "<script>alert('Register Failed: " . $stmt->error . "');</script>";
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Register - FreshMart</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="register.css">
</head>
<body>

<?php include __DIR__ . '/../shared/header.php'; ?>

<main class="register-page">
    <div class="register-container">
        <h1>Create Account</h1>

        <form class="register-form" method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first_name" required>
                </div>

                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last_name" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <small>Password must be at least 8 characters long with at least one number and one special character.</small>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" required>
            </div>

            <div class="form-checkbox">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>

            <div class="form-checkbox">
                <input type="checkbox" id="newsletter" name="newsletter">
                <label for="newsletter">Subscribe to our newsletter for promotions and updates</label>
            </div>

            <button type="submit" name="register" class="btn btn-primary btn-block">Create Account</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="<?php echo $base_url; ?>account/login.php">Sign In</a></p>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>

<script src="<?php echo $base_url; ?>scripts/common.js"></script>
<script src="<?php echo $base_url; ?>scripts/account.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.register-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('confirm-password').value;
            if (password !== confirm) {
                e.preventDefault();
                alert("Passwords do not match!");
            }
        });
    }
});
</script>
</body>
</html>

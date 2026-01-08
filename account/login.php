<?php
// 启用 session
session_start();

// 包含配置文件
include_once __DIR__ . '/../config.php';

// 如果用户已登录，重定向到首页
if (isset($_SESSION['user_id'])) {
    header("Location: " . $base_url . "index.php");
    exit;
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // 查询数据库中是否存在该邮箱
    $stmt = $mysqli->prepare("SELECT user_id, username, email, first_name, last_name, phone, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // 登录成功，设置 session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['phone'] = $user['phone'];

            // 跳转
            header("Location: " . $base_url . "index.php");
            exit;
        } else {
            $error_message = 'Incorrect password.';
        }
    } else {
        $error_message = 'User not found.';
    }

    $stmt->close();
}

// 页面标题
$page_title = 'Login - ' . $site_title;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/main.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/header.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/footer.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/account.css">
</head>
<body>

<!-- Header -->
<?php include __DIR__ . '/../shared/header.php'; ?>

<main class="account-page">
    <div class="login-container">
        <h1>Sign In</h1>

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form id="login-form" class="account-form" method="post" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember" <?php echo isset($_POST['remember']) ? 'checked' : ''; ?>>
                    <label for="remember">Remember me</label>
                </div>
                <a href="<?php echo $base_url; ?>account/forgot-password.php" class="forgot-password">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>

        <div class="account-separator">
            <span>OR</span>
        </div>

        <div class="social-login">
            <button type="button" class="btn-social btn-facebook">
                <img src="<?php echo $base_url; ?>assets/icons/facebook.svg" alt="Facebook">
                Continue with Facebook
            </button>
            <button type="button" class="btn-social btn-google">
                <img src="<?php echo $base_url; ?>assets/icons/google.svg" alt="Google">
                Continue with Google
            </button>
        </div>

        <div class="account-footer">
            <p>Don't have an account? <a href="<?php echo $base_url; ?>account/register.php">Sign Up</a></p>
        </div>
    </div>
</main>

<!-- Footer -->
<?php include __DIR__ . '/../shared/footer.php'; ?>
<script src="<?php echo $base_url; ?>scripts/common.js"></script>
</body>
</html>

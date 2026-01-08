<?php
// 包含配置文件
include_once __DIR__ . '/../config.php';

// 检查用户是否已登录，如果未登录则重定向到登录页面
if (!isset($_SESSION['user_id'])) {
    header("Location: " . $base_url . "account/login.php");
    exit;
}

// 获取用户信息
$user_id = $_SESSION['user_id'];
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';

// 设置页面标题
$page_title = "My Account | FreshMart";

// 模拟订单数据 - 实际应用中应从数据库获取
$has_orders = false; // 设置为 true 可以显示订单，false 显示空状态
$recent_orders = [];
/*
$recent_orders = [
    [
        'id' => 'ORD-12345',
        'date' => '2023-04-15',
        'status' => 'Delivered',
        'total' => 89.97,
        'items' => 3
    ],
    [
        'id' => 'ORD-12346',
        'date' => '2023-04-02',
        'status' => 'Processing',
        'total' => 45.50,
        'items' => 2
    ]
];
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/main.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/header.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/footer.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/account.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <?php include __DIR__ . '/../shared/header.php'; ?>

    <!-- Profile Banner -->
    <div class="profile-banner">
        <div class="container">
            <h1>My Account</h1>
            <p>Manage your account information and track your orders</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="account-page">
        <div class="container">
            <div class="profile-dashboard">
                <!-- Sidebar -->
                <div class="profile-sidebar">
                    <div class="profile-user">
                        <div class="profile-avatar">
                            <div class="avatar-circle">
                                <?php 
                                // Display initials if name is available, otherwise show username first letter
                                if (!empty($first_name) && !empty($last_name)) {
                                    echo strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1));
                                } else {
                                    echo strtoupper(substr($username, 0, 2));
                                }
                                ?>
                            </div>
                        </div>
                        <div class="profile-name">
                            <?php 
                            if (!empty($first_name) && !empty($last_name)) {
                                echo htmlspecialchars($first_name . ' ' . $last_name);
                            } else {
                                echo htmlspecialchars($username);
                            }
                            ?>
                        </div>
                        <div class="profile-email"><?php echo htmlspecialchars($email); ?></div>
                    </div>
                    
                    <nav class="profile-nav">
                        <ul>
                            <li class="active">
                                <a href="<?php echo $base_url; ?>account/profile.php">
                                    <i class="fas fa-user"></i> Account Overview
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url; ?>account/orders.php">
                                    <i class="fas fa-shopping-bag"></i> My Orders
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url; ?>account/addresses.php">
                                    <i class="fas fa-map-marker-alt"></i> Addresses
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url; ?>account/wishlist.php">
                                    <i class="fas fa-heart"></i> Wishlist
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url; ?>account/payment-methods.php">
                                    <i class="fas fa-credit-card"></i> Payment Methods
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $base_url; ?>account/settings.php">
                                    <i class="fas fa-cog"></i> Account Settings
                                </a>
                            </li>
                            <li class="nav-signout">
                                <a href="<?php echo $base_url; ?>account/logout.php">
                                    <i class="fas fa-sign-out-alt"></i> Sign Out
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                
                <!-- Main Content Area -->
                <div class="profile-content">
                    <!-- Welcome Card -->
                    <div class="profile-card welcome-card">
                        <div class="card-content">
                            <h2>Welcome back, <?php echo htmlspecialchars($first_name ?: $username); ?>!</h2>
                            <p>From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.</p>
                        </div>
                    </div>
                    
                    <!-- Account Information -->
                    <div class="profile-card">
                        <div class="card-header">
                            <h2><i class="fas fa-user-circle"></i> Personal Information</h2>
                            <a href="<?php echo $base_url; ?>account/update-profile.php" class="btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                        <div class="card-content">
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-label">Username</div>
                                    <div class="info-value"><?php echo htmlspecialchars($username); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Email</div>
                                    <div class="info-value"><?php echo htmlspecialchars($email); ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">First Name</div>
                                    <div class="info-value"><?php echo !empty($first_name) ? htmlspecialchars($first_name) : '—'; ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Last Name</div>
                                    <div class="info-value"><?php echo !empty($last_name) ? htmlspecialchars($last_name) : '—'; ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Phone</div>
                                    <div class="info-value"><?php echo !empty($phone) ? htmlspecialchars($phone) : '—'; ?></div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Password</div>
                                    <div class="info-value">••••••••
                                        <a href="<?php echo $base_url; ?>account/change-password.php" class="btn-change-password">Change</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Orders -->
                    <div class="profile-card">
                        <div class="card-header">
                            <h2><i class="fas fa-shopping-bag"></i> Recent Orders</h2>
                            <a href="<?php echo $base_url; ?>account/orders.php" class="btn-view-all">View All</a>
                        </div>
                        <div class="card-content">
                            <?php if ($has_orders && !empty($recent_orders)): ?>
                                <div class="orders-table">
                                    <div class="orders-header">
                                        <div class="order-col">Order</div>
                                        <div class="order-col">Date</div>
                                        <div class="order-col">Status</div>
                                        <div class="order-col">Total</div>
                                        <div class="order-col">Actions</div>
                                    </div>
                                    
                                    <?php foreach ($recent_orders as $order): ?>
                                        <div class="order-row">
                                            <div class="order-col"><?php echo htmlspecialchars($order['id']); ?></div>
                                            <div class="order-col"><?php echo htmlspecialchars($order['date']); ?></div>
                                            <div class="order-col">
                                                <span class="order-status <?php echo strtolower($order['status']); ?>">
                                                    <?php echo htmlspecialchars($order['status']); ?>
                                                </span>
                                            </div>
                                            <div class="order-col">$<?php echo number_format($order['total'], 2); ?></div>
                                            <div class="order-col">
                                                <a href="<?php echo $base_url; ?>account/order-details.php?id=<?php echo $order['id']; ?>" class="btn-view">View</a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <h3>No orders yet</h3>
                                    <p>You haven't placed any orders yet. When you do, they'll appear here.</p>
                                    <a href="<?php echo $base_url; ?>index.php" class="btn-shop-now">Start Shopping</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div class="quick-links">
                        <div class="quick-link-card">
                            <div class="quick-link-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h3>Wishlist</h3>
                            <p>View and manage your saved items</p>
                            <a href="<?php echo $base_url; ?>account/wishlist.php" class="btn-quick-link">View Wishlist</a>
                        </div>
                        
                        <div class="quick-link-card">
                            <div class="quick-link-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h3>Addresses</h3>
                            <p>Manage your shipping addresses</p>
                            <a href="<?php echo $base_url; ?>account/addresses.php" class="btn-quick-link">Manage Addresses</a>
                        </div>
                        
                        <div class="quick-link-card">
                            <div class="quick-link-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <h3>Payment Methods</h3>
                            <p>Manage your payment options</p>
                            <a href="<?php echo $base_url; ?>account/payment-methods.php" class="btn-quick-link">Manage Payments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../shared/footer.php'; ?>
</body>
</html>

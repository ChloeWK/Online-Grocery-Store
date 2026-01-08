<?php
// 包含配置文件
include_once __DIR__ . '/../config.php';
// 设置页面特定变量
$page_title = 'Confirmation - ' . $site_title;

// 获取当前用户 ID
$user_id = $_SESSION['user_id'] ?? null;

// 获取最新订单信息（最后插入的订单）
$order_id = null;
$created_at = null;
$payment_method_display = 'Unknown';

if ($user_id) {
    $stmt = $mysqli->prepare("SELECT o.order_id, o.created_at, p.card_type, p.card_number_last4 
                              FROM orders o 
                              LEFT JOIN payment p ON o.user_id = p.user_id
                              WHERE o.user_id = ?
                              ORDER BY o.created_at DESC
                              LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($order_id, $created_at_raw, $card_type, $last4);
    if ($stmt->fetch()) {
        $created_at = date("F d, Y", strtotime($created_at_raw)); // e.g., April 20, 2025
        $payment_method_display = $card_type && $last4 ? "$card_type ending in $last4" : 'Unknown';
    }
    $stmt->close();
}

$delivery_info = null;
$delivery_method = $_SESSION['delivery_method'] ?? 'standard';

if (isset($_SESSION['delivery_id'])) {
    $delivery_id = $_SESSION['delivery_id'];

    $stmt = $mysqli->prepare("SELECT * FROM deliverinfo WHERE delivery_id = ?");
    $stmt->bind_param("i", $delivery_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $delivery_info = $result->fetch_assoc();
    $stmt->close();
}

$order = null;
$order_items = [];
$shipping_fee = 5.99; // 可调

if (isset($_SESSION['latest_order_id'])) {
    $order_id = $_SESSION['latest_order_id'];

    // 获取订单
    $stmt = $mysqli->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    // 获取订单项 + 产品信息
    $stmt = $mysqli->prepare("
        SELECT oi.*, p.product_name, p.image, p.original_price
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        WHERE oi.order_id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order_items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - FreshMart</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="confirmation.css">
</head>
<body>
    <!-- Header -->
    <?php include __DIR__ . '/../shared/header.php'; ?>

    <main class="confirmation-page">
        <div class="container container-wide">
            <div class="checkout-main">
                <!-- 优化的步骤指示器 -->
                <div class="checkout-steps">
                    <div class="step completed">
                        <div class="step-number">✓</div>
                        <div class="step-label">Delivery</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step completed">
                        <div class="step-number">✓</div>
                        <div class="step-label">Payment</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step active">
                        <div class="step-number">3</div>
                        <div class="step-label">Confirmation</div>
                    </div>
                </div>
                
                <div class="confirmation-container">
                    <div class="confirmation-header">
                        <div class="success-icon">✓</div>
                        <h1>Order Confirmed!</h1>
                        <p>Thank you for your purchase. Your order has been received and is now being processed. You will receive an email confirmation shortly.</p>
                    </div>
                    
                    <div class="order-details">
                        <div class="order-info">
                            <h3>Order Information</h3>
                            <div class="info-item">
                                <span class="label">Order Number:</span>
                                <span class="value">#FMO-<?php echo htmlspecialchars($order_id); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="label">Order Date:</span>
                                <span class="value"><?php echo htmlspecialchars($created_at); ?></span>
                            </div>
                            <div class="info-item">
                                <span class="label">Payment Method:</span>
                                <span class="value">Credit Card</span>
                            </div>
                            <div class="info-item">
                                <span class="label">Payment Status:</span>
                                <span class="value">Paid</span>
                            </div>
                        </div>
                        
                        <div class="delivery-info">
                            <h3>Delivery Information</h3>
                            <?php if ($delivery_info): ?>
                                <p><strong><?php echo htmlspecialchars($delivery_info['full_name']); ?></strong></p>
                                <p>
                                    <?php echo htmlspecialchars($delivery_info['address_line1']); ?>
                                    <?php if (!empty($delivery_info['address_line2'])): ?>
                                        , <?php echo htmlspecialchars($delivery_info['address_line2']); ?>
                                    <?php endif; ?>
                                </p>
                                <p><?php echo htmlspecialchars($delivery_info['city']); ?>,
                                <?php echo htmlspecialchars($delivery_info['state']); ?>
                                <?php echo htmlspecialchars($delivery_info['postal_code']); ?></p>
                                <p><?php echo htmlspecialchars($delivery_info['country']); ?></p>
                                <p><?php echo htmlspecialchars($delivery_info['phone']); ?></p>
                                <p><strong>Delivery Method:</strong>
                                    <?php
                                        $method_labels = [
                                            'standard' => 'Standard Delivery',
                                            'express' => 'Express Delivery',
                                            'pickup' => 'Store Pickup'
                                        ];
                                        echo $method_labels[$delivery_method] ?? 'Standard Delivery';
                                    ?>
                                </p>
                                <p><strong>Estimated Delivery:</strong>
                                    <?php
                                        $method_times = [
                                            'standard' => '2-3 business days',
                                            'express' => 'Next day delivery',
                                            'pickup' => 'Ready in 2 hours'
                                        ];
                                        echo $method_times[$delivery_method] ?? '2-3 business days';
                                    ?>
                                </p>
                            <?php else: ?>
                                <p>No delivery information found.</p>
                            <?php endif; ?>
                        </div>   
                    </div>
                    
                    <?php
                        // 计算金额信息
                        $subtotal = 0;
                        $discount = 0;

                        foreach ($order_items as $item) {
                            $subtotal += $item['total_price'];
                            if (!empty($item['original_price']) && $item['original_price'] > $item['unit_price']) {
                                $discount += ($item['original_price'] - $item['unit_price']) * $item['quantity'];
                            }
                        }

                        $tax = $subtotal * 0.1;
                        $total = $subtotal + $shipping_fee + $tax - $discount;
                    ?>

                    <div class="order-items">
                        <?php foreach ($order_items as $item): ?>
                            <div class="order-item">
                                <div class="item-image">
                                    <img src="../assets/images/products/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                                </div>
                                <div class="item-details">
                                    <div class="item-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
                                    <div class="item-meta">Qty: <?php echo $item['quantity']; ?></div>
                                    <div class="item-price-details">
                                        <?php if (!empty($item['original_price']) && $item['original_price'] > $item['unit_price']): ?>
                                            <span class="original-price" style="text-decoration: line-through; color: #888; font-size: 0.9em;">
                                                $<?php echo number_format($item['original_price'], 2); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="unit-price">
                                            $<?php echo number_format($item['unit_price'], 2); ?>
                                        </span>
                                        × <?php echo $item['quantity']; ?>
                                        = <strong>$<?php echo number_format($item['total_price'], 2); ?></strong>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                        <div class="order-totals">
                            <div class="total-row"><span>Subtotal</span><span>$<?php echo number_format($subtotal, 2); ?></span></div>
                            <div class="total-row"><span>Shipping</span><span>$<?php echo number_format($shipping_fee, 2); ?></span></div>
                            <div class="total-row"><span>Tax</span><span>$<?php echo number_format($tax, 2); ?></span></div>
                            <div class="total-row discount"><span>Discount</span><span>-$<?php echo number_format($discount, 2); ?></span></div>
                            <div class="total-row grand-total"><span>Total</span><span>$<?php echo number_format($total, 2); ?></span></div>
                        </div>
                    </div>

                    <div class="delivery-tracking">
                        <h2>Track Your Order</h2>
                        
                        <div class="tracking-status">
                            <div class="status-step completed">
                                <div class="status-icon">✓</div>
                                <div class="status-info">
                                    <h4>Order Placed</h4>
                                    <p>June 15, 2023</p>
                                </div>
                            </div>
                            
                            <div class="status-step active">
                                <div class="status-icon">2</div>
                                <div class="status-info">
                                    <h4>Processing</h4>
                                    <p>In progress</p>
                                </div>
                            </div>
                            
                            <div class="status-step">
                                <div class="status-icon">3</div>
                                <div class="status-info">
                                    <h4>Shipped</h4>
                                    <p>Pending</p>
                                </div>
                            </div>
                            
                            <div class="status-step">
                                <div class="status-icon">4</div>
                                <div class="status-info">
                                    <h4>Delivered</h4>
                                    <p>Estimated: June 18-20</p>
                                </div>
                            </div>
                        </div>
                    </div> 

                        <p class="tracking-note">You will receive an email with tracking information once your order has been shipped.</p>
                    </div>
                    
                    <div class="confirmation-actions">
                        <a href="../index.php" class="btn btn-secondary">Continue Shopping</a>
                        <a href="../account/profile.php" class="btn btn-primary">View Order History</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../shared/footer.php'; ?>

    <script>
        // 添加简单的动画效果
        document.addEventListener('DOMContentLoaded', function() {
            // 可以在这里添加额外的JavaScript功能
            // 例如，点击"Continue Shopping"按钮时的平滑滚动等
        });
    </script>
</body>
</html>

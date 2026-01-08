<?php
// 包含配置文件
include_once __DIR__ . '/../config.php';

// 设置页面特定变量
$page_title = 'Payment - ' . $site_title;

$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
        $mysqli->begin_transaction();

        try {
            // (1) 保存 payment（仅在勾选 save-card）
            if (isset($_POST['save-card'])) {
                $card_holder_name = $_POST['card-name'];
                $card_number = str_replace(' ', '', $_POST['card-number']);
                $card_number_last4 = substr($card_number, -4);
                $card_type = 'Unknown';
                if (preg_match('/^4/', $card_number)) $card_type = 'Visa';
                elseif (preg_match('/^5[1-5]/', $card_number)) $card_type = 'MasterCard';
                elseif (preg_match('/^3[47]/', $card_number)) $card_type = 'AMEX';
                elseif (preg_match('/^6/', $card_number)) $card_type = 'Discover';

                $expiry = explode('/', $_POST['expiry-date']);
                $expiry_month = intval($expiry[0]);
                $expiry_year = 2000 + intval($expiry[1]);

                $stmt = $mysqli->prepare("INSERT INTO payment (user_id, card_holder_name, card_number_last4, card_type, expiry_month, expiry_year, is_default) VALUES (?, ?, ?, ?, ?, ?, 0)");
                $stmt->bind_param("isssii", $user_id, $card_holder_name, $card_number_last4, $card_type, $expiry_month, $expiry_year);
                $stmt->execute();
            }

            // (2) 写入 orders 表
            $delivery_id = $_SESSION['delivery_id'] ?? null;
            if (!$delivery_id) throw new Exception("No delivery info");

            $total_amount = floatval($_POST['order_total'] ?? 0.0);  // 你将从 JS 提交过来
            $stmt = $mysqli->prepare("INSERT INTO orders (user_id, delivery_id, total_amount, order_status) VALUES (?, ?, ?, 'pending')");
            $stmt->bind_param("iid", $user_id, $delivery_id, $total_amount);
            $stmt->execute();
            $order_id = $stmt->insert_id;

            // (3) 写入 order_items 表
            $cartItems = json_decode($_POST['cart_data'], true);
            if (!$cartItems || !is_array($cartItems)) throw new Exception("Cart is empty");

            foreach ($cartItems as $item) {
                $product_id = $item['product_id'];
                $quantity = intval($item['quantity']);
                $unit_price = floatval($item['price']);
                $total_price = $unit_price * $quantity;

                $stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("isidd", $order_id, $product_id, $quantity, $unit_price, $total_price);
                $stmt->execute();
            }

            $mysqli->commit();
            $_SESSION['latest_order_id'] = $order_id;
            header("Location: confirmation.php");
            exit();
        } catch (Exception $e) {
            $mysqli->rollback();
            echo "<script>alert('Error placing order: " . $e->getMessage() . "');</script>";
        }
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
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment - FreshMart</title>
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/footer.css">
  <link rel="stylesheet" href="payment.css">
</head>
<body>
  <?php include __DIR__ . '/../shared/header.php'; ?>

  <main class="payment-page">
    <div class="container container-wide">
      <div class="checkout-main">
        <!-- steps -->
        <div class="checkout-steps">
          <div class="step completed"><div class="step-number">✓</div><div class="step-label">Delivery</div></div>
          <div class="step-connector"></div>
          <div class="step active"><div class="step-number">2</div><div class="step-label">Payment</div></div>
          <div class="step-connector"></div>
          <div class="step"><div class="step-number">3</div><div class="step-label">Confirmation</div></div>
        </div>

        <div class="section-title"><h1>Payment Method</h1></div>

        <div class="checkout-layout">
          <div class="checkout-main-content">
            <div class="payment-options">
              <div class="payment-tabs">
                <button class="payment-tab active" data-tab="credit-card"><img src="../assets/icons/credit-card.svg">Credit Card</button>
                <button class="payment-tab" data-tab="paypal"><img src="../assets/icons/paypal.svg">PayPal</button>
                <button class="payment-tab" data-tab="apple-pay"><img src="../assets/icons/apple-pay.svg">Apple Pay</button>
                <button class="payment-tab" data-tab="google-pay"><img src="../assets/icons/google-pay.svg">Google Pay</button>
              </div>

              <div class="payment-content active" id="credit-card-content">
                <form class="credit-card-form" method="POST" action="payment.php" id="payment-form" style="margin-bottom: 2rem;">
                  <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <div class="card-input-wrapper">
                      <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group">
                      <label for="expiry-date">Expiry Date</label>
                      <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="form-group">
                      <label for="cvv">CVV</label>
                      <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="card-name">Name on Card</label>
                    <input type="text" id="card-name" name="card-name" placeholder="John Doe" required>
                  </div>
                  <div class="save-card-option">
                    <input type="checkbox" id="save-card" name="save-card" value="1">
                    <label for="save-card">Save card for future purchases</label>
                  </div>
                <input type="hidden" id="cart-data" name="cart_data">
                <input type="hidden" id="order-total" name="order_total">
                </form>



                <div class="order-review">
                    <h2>Review Your Order</h2> 
                        <div class="review-section">
                            <h3>Delivery Address</h3>
                                <div class="review-content">
                                    <?php if ($delivery_info): ?>
                                        <p><strong><?= htmlspecialchars($delivery_info['full_name']) ?></strong></p>
                                        <p><?= htmlspecialchars($delivery_info['address_line1']) ?>
                                        <?= htmlspecialchars($delivery_info['address_line2']) ?></p>
                                        <p><?= htmlspecialchars($delivery_info['city']) ?>,
                                        <?= htmlspecialchars($delivery_info['state']) ?>
                                        <?= htmlspecialchars($delivery_info['postal_code']) ?></p>
                                        <p><?= htmlspecialchars($delivery_info['country']) ?></p>
                                        <p><?= htmlspecialchars($delivery_info['phone']) ?></p>
                                    <?php else: ?>
                                        <p>No delivery address found.</p>
                                    <?php endif; ?>
                                    </div>
                                <a href="delivery.php" class="btn-change">Change</a>
                                </div>

                                <div class="review-section">
                                    <h3>Delivery Method</h3>
                                <div class="review-content">
                                    <?php
                                        $method_labels = [
                                        'standard' => 'Standard Delivery',
                                        'express' => 'Express Delivery',
                                        'pickup' => 'Store Pickup'
                                        ];
                                        $method_times = [
                                        'standard' => '2-3 business days',
                                        'express' => 'Next day delivery',
                                        'pickup' => 'Ready in 2 hours'
                                        ];
                                    ?>
                                    <p><?= $method_labels[$delivery_method] ?? 'Standard Delivery' ?></p>
                                    <p>Estimated delivery: <?= $method_times[$delivery_method] ?? '2-3 business days' ?></p>
                                </div>
                                <a href="delivery.php" class="btn-change">Change</a>
                            </div>
                        </div>

                        <div class="checkout-actions">
                            <a href="delivery.php" class="btn btn-secondary">Back to Delivery</a>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" id="place-order-btn">Place Order</button>
                        </div>
                    </div>   
                </div>

              <div class="payment-content" id="paypal-content">
                <div class="payment-method-info"><p>You will be redirected to PayPal to complete your payment securely.</p><div class="paypal-button">Continue with PayPal</div></div>
              </div>

              <div class="payment-content" id="apple-pay-content">
                <div class="payment-method-info"><p>Click the button below to pay with Apple Pay.</p><div class="apple-pay-button"><span>Apple Pay</span></div></div>
              </div>

              <div class="payment-content" id="google-pay-content">
                <div class="payment-method-info"><p>Click the button below to pay with Google Pay.</p><div class="google-pay-button"><span>Google Pay</span></div></div>
              </div>
            </div>
          </div>

          <div class="checkout-sidebar">
            <div class="order-summary">
              <h2>Order Summary</h2>
              <div class="order-items" id="order-items"></div>
              <div class="summary-divider"></div>
              <div class="summary-row"><span>Subtotal</span><span id="summary-subtotal">$0.00</span></div>
              <div class="summary-row"><span>Shipping</span><span id="summary-shipping">$0.00</span></div>
              <div class="summary-row"><span>Tax</span><span id="summary-tax">$0.00</span></div>
              <div class="summary-row discount"><span>Discount</span><span id="summary-discount">-$0.00</span></div>
              <div class="summary-row total"><span>Total</span><span id="summary-total">$0.00</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/../shared/footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
      const container = document.getElementById('order-items');
      const shipping = 5.99;

      let subtotal = 0;
      let discount = 0;

      cartItems.forEach(item => {
        const quantity = item.quantity;
        const price = parseFloat(item.price);
        const original = parseFloat(item.original_price || price);
        const total = quantity * price;
        const image = item.image || 'default.jpg';

        subtotal += total;
        discount += (original - price) * quantity;

        container.insertAdjacentHTML('beforeend', `
          <div class="order-item">
            <div class="item-image"><img src="../assets/images/products/${image}" alt="${item.name}"></div>
            <div class="item-details"><div class="item-name">${item.name}</div><div class="item-meta">Qty: ${quantity}</div></div>
            <div class="item-price">$${total.toFixed(2)}</div>
          </div>
        `);
      });

      const tax = subtotal * 0.1;
      const total = subtotal + shipping + tax - discount;

      document.getElementById('summary-subtotal').textContent = `$${subtotal.toFixed(2)}`;
      document.getElementById('summary-shipping').textContent = `$${shipping.toFixed(2)}`;
      document.getElementById('summary-tax').textContent = `$${tax.toFixed(2)}`;
      document.getElementById('summary-discount').textContent = `-$${discount.toFixed(2)}`;
      document.getElementById('summary-total').textContent = `$${total.toFixed(2)}`;
    });

    // 将 cartItems 和 total 写入隐藏字段，确保 PHP 可以接收到
    document.querySelector('.credit-card-form').addEventListener('submit', function () {
        const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
        const total = document.getElementById('summary-total').textContent.replace('$', '');
        document.getElementById('cart-data').value = JSON.stringify(cartItems);
        document.getElementById('order-total').value = parseFloat(total).toFixed(2);
    });

    document.getElementById('place-order-btn').addEventListener('click', function () {
        const form = document.getElementById('payment-form');

        // 验证表单字段
        const requiredFields = ['card-number', 'expiry-date', 'cvv', 'card-name'];
        let valid = true;

        requiredFields.forEach(id => {
            const input = document.getElementById(id);
            if (!input.value.trim()) {
                input.style.border = '1px solid red';
                valid = false;
            } else {
                input.style.border = '';
            }
        });

        if (!valid) {
            alert('Please fill out all required payment fields.');
            return;
        }

        // 写入 cart 和 total
        const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
        const total = document.getElementById('summary-total').textContent.replace('$', '');
        document.getElementById('cart-data').value = JSON.stringify(cartItems);
        document.getElementById('order-total').value = parseFloat(total).toFixed(2);

        // ✅ 清空购物车
        localStorage.removeItem('cartItems');

        // 提交表单
        form.submit();
    });
  </script>
</body>
</html>
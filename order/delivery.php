<?php
include_once __DIR__ . '/../config.php';

$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

$saved_addresses = [];

if ($is_logged_in) {
    $stmt = $mysqli->prepare("SELECT * FROM deliverinfo WHERE user_id = ? ORDER BY is_default DESC, created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $saved_addresses = $result->fetch_all(MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'submit_delivery') {
    $delivery_method = $_POST['delivery-method'] ?? 'standard';
    $selected_delivery_id = $_POST['delivery_id'] ?? null;

    if ($selected_delivery_id) {
        $_SESSION['delivery_id'] = $selected_delivery_id;
        $_SESSION['delivery_method'] = $delivery_method;
        header("Location: payment.php");
        exit();
    }

    $full_name = $_POST['first-name'] . ' ' . $_POST['last-name'];
    $phone = $_POST['phone'];
    $address1 = $_POST['address-line1'];
    $address2 = $_POST['address-line2'] ?? '';
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postal = $_POST['postal_code'];
    $country = $_POST['country'] ?? 'Australia';

    $stmt = $mysqli->prepare("INSERT INTO deliverinfo (user_id, full_name, phone, address_line1, address_line2, city, state, postal_code, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $user_id, $full_name, $phone, $address1, $address2, $city, $state, $postal, $country);
    $stmt->execute();
    $new_delivery_id = $stmt->insert_id;

    $_SESSION['delivery_id'] = $new_delivery_id;
    $_SESSION['delivery_method'] = $delivery_method;
    header("Location: payment.php");
    exit();
}
?>

<?php
// 设置页面特定变量
$page_title = 'Delivery - ' . $site_title;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Information - FreshMart</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="delivery.css">
</head>
<body>
    <!-- Header -->
    <?php include __DIR__ . '/../shared/header.php'; ?>

    <main class="delivery-page">
        <div class="container container-wide">
            <div class="checkout-main">
                <!-- Moved checkout steps above the section title -->
                <div class="checkout-steps">
                    <div class="step active">
                        <div class="step-number">1</div>
                        <div class="step-label">Delivery</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-label">Payment</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-label">Confirmation</div>
                    </div>
                </div>
                
                <div class="section-title">
                    <h1> </h1>
                </div>
                

            <form method="POST" action="delivery.php">
                <input type="hidden" name="action" value="submit_delivery">
                <div class="checkout-layout">
                    <div class="checkout-main-content">
                        <div class="delivery-options">
                            <h2>Delivery Method</h2>
                            
                            <div class="delivery-option-cards">
                                <label class="delivery-option-card">
                                    <input type="radio" name="delivery-method" value="standard" checked>
                                    <div class="card-content">
                                        <div class="delivery-details">
                                            <h3>Standard Delivery</h3>
                                            <p>2-3 business days</p>
                                            <p class="delivery-price">$5.99</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="delivery-option-card">
                                    <input type="radio" name="delivery-method" value="express">
                                    <div class="card-content">
                                        <div class="delivery-details">
                                            <h3>Express Delivery</h3>
                                            <p>Next day delivery</p>
                                            <p class="delivery-price">$9.99</p>
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="delivery-option-card">
                                    <input type="radio" name="delivery-method" value="pickup">
                                    <div class="card-content">
                                        <div class="delivery-details">
                                            <h3>Store Pickup</h3>
                                            <p>Ready in 2 hours</p>
                                            <p class="delivery-price free">Free</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="address-section">
                            <h2>Delivery Address</h2>
                            
                            <div class="saved-addresses">
                                <?php if ($is_logged_in && count($saved_addresses) > 0): ?>
                                    <?php foreach ($saved_addresses as $address): ?>
                                        <label class="saved-address-card">
                                            <input type="radio" name="delivery_id" value="<?= $address['delivery_id'] ?>">
                                            <div class="card-content">
                                                <div class="address-icon">
                                                    <img src="../assets/icons/home.svg" alt="Address">
                                                </div>
                                                <div class="address-details">
                                                    <h3><?= htmlspecialchars($address['full_name']) ?></h3>
                                                    <p><?= htmlspecialchars($address['address_line1']) ?> <?= htmlspecialchars($address['address_line2']) ?></p>
                                                    <p><?= htmlspecialchars($address['city']) ?>, <?= htmlspecialchars($address['state']) ?> <?= $address['postal_code'] ?></p>
                                                    <p><?= htmlspecialchars($address['country']) ?></p>
                                                    <p class="address-phone"><?= $address['phone'] ?></p>
                                                </div>
                                                <div class="address-actions">
                                                    <button class="btn-edit">Edit</button>
                                                    <button class="btn-delete">Delete</button>
                                                </div>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No saved addresses found. Please add a new one below.</p>
                                <?php endif; ?>
                            </div>

                            <div class="new-address-form">
                                <h3>Add New Address</h3>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="first-name">First Name</label>
                                            <input type="text" id="first-name" name="first-name" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="last-name">Last Name</label>
                                            <input type="text" id="last-name" name="last-name" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" id="phone" name="phone" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="address-line1">Address Line 1</label>
                                        <input type="text" id="address-line1" name="address-line1" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="address-line2">Address Line 2 (Optional)</label>
                                        <input type="text" id="address-line2" name="address-line2">
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" id="city" name="city" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="state">State/Province</label>
                                            <input type="text" id="state" name="state" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="zip">ZIP/Postal Code</label>
                                            <input type="text" id="zip" name="zip" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <select id="country" name="country" required>
                                                <option value="US">United States</option>
                                                <option value="CA">Canada</option>
                                                <option value="UK">United Kingdom</option>
                                                <option value="AU">Australia</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-checkbox">
                                        <input type="checkbox" id="default-address" name="default-address">
                                        <label for="default-address">Set as default address</label>
                                    </div>
                                    
                                    <div class="form-actions">
                                        <button type="button" class="btn btn-secondary">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Address</button>
                                    </div>
                                </div>

                                <div class="checkout-actions">
                                    <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
                                
                                <div class="form-actions">
                                    <button type="button" class="btn btn-primary" id="proceed-checkout">Proceed to Checkout</button>
                                </div>
                            </div>
                        </div>    
                    </div>
                    
                    <div class="checkout-sidebar">
                        <div class="order-summary">
                            <h2>Order Summary</h2>
                            
                            <div class="order-items" id="order-items">
                                <!-- 通过 JS 动态插入 -->
                            </div>
                            
                            <div class="summary-divider"></div>
                            
                            <div class="summary-row subtotal">
                                <span>Subtotal</span>
                                <span>$0.00</span>
                            </div>
                            <div class="summary-row shipping">
                                <span>Shipping</span>
                                <span id="shipping-cost">$5.99</span>
                            </div>
                            <div class="summary-row tax">
                                <span>Tax</span>
                                <span>$$0.00</span>
                            </div>
                            <div class="summary-row discount">
                                <span>Discount</span>
                                <span>-$$0.00</span>
                            </div>
                            <div class="summary-row total">
                                <span>Total</span>
                                <span>$$0.00</span>
                            </div>
                            
                            <div class="promo-code">
                                <div class="collapsible-header">
                                    <button class="btn-collapse">
                                        Have a promo code? <span class="collapse-icon">+</span>
                                    </button>
                                </div>
                                <div class="collapse-content">
                                    <div class="promo-input">
                                        <input type="text" placeholder="Enter code">
                                        <button class="btn-apply">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="need-help">
                            <h3>Need Help?</h3>
                            <p><a href="#">Shipping & Delivery</a></p>
                            <p><a href="#">Returns & Refunds</a></p>
                            <p><a href="#">Contact Customer Service</a></p>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../shared/footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const cartItems = JSON.parse(localStorage.getItem('cartItems') || '[]');
        const container = document.getElementById('order-items');
        const shippingMap = { standard: 5.99, express: 9.99, pickup: 0 };

        let subtotal = 0;
        let discount = 0;

        if (cartItems.length === 0) {
            container.innerHTML = '<p>Your cart is empty.</p>';
            return;
        }

        // 渲染商品
        cartItems.forEach(item => {
            const name = item.name;
            const quantity = item.quantity;
            const price = parseFloat(item.price);
            const originalPrice = parseFloat(item.original_price || price);
            const totalPrice = price * quantity;
            const itemDiscount = (originalPrice - price) * quantity;
            const image = item.image || 'default.jpg';

            subtotal += totalPrice;
            discount += itemDiscount;

            const itemHTML = `
            <div class="order-item">
                <div class="item-image">
                    <img src="../assets/images/products/${image}" alt="${name}">
                </div>
                <div class="item-details">
                    <div class="item-name">${name}</div>
                    <div class="item-meta">Qty: ${quantity}</div>
                </div>
                <div class="item-price">$${totalPrice.toFixed(2)}</div>
            </div>`;
            container.insertAdjacentHTML('beforeend', itemHTML);
        });

        const tax = subtotal * 0.10;
        let shippingMethod = document.querySelector('input[name="delivery-method"]:checked')?.value || 'standard';
        let shipping = shippingMap[shippingMethod];

        // 更新汇总字段
        document.querySelector('.summary-row.subtotal span:last-child').textContent = `$${subtotal.toFixed(2)}`;
        document.querySelector('.summary-row.tax span:last-child').textContent = `$${tax.toFixed(2)}`;
        document.querySelector('.summary-row.discount span:last-child').textContent = `-$${discount.toFixed(2)}`;
        document.getElementById('shipping-cost').textContent = `$${shipping.toFixed(2)}`;

        const total = subtotal + tax + shipping - discount;
        document.querySelector('.summary-row.total span:last-child').textContent = `$${total.toFixed(2)}`;

        // 更新 shipping 和 total 动态响应切换
        document.querySelectorAll('input[name="delivery-method"]').forEach(option => {
            option.addEventListener('change', () => {
                shippingMethod = option.value;
                shipping = shippingMap[shippingMethod];
                document.getElementById('shipping-cost').textContent = `$${shipping.toFixed(2)}`;

                const updatedTotal = subtotal + tax + shipping - discount;
                document.querySelector('.summary-row.total span:last-child').textContent = `$${updatedTotal.toFixed(2)}`;
            });
        });
    });

        // 计算 tax & shipping
        const tax = subtotal * 0.10;
        const shippingOption = document.querySelector('input[name="delivery-method"]:checked')?.value || 'standard';
        const shippingMap = { standard: 5.99, express: 9.99, pickup: 0 };
        let shipping = shippingMap[shippingOption];

        // 更新小计、税、折扣、总计
        document.querySelector('.summary-row.subtotal span:last-child').textContent = `$${subtotal.toFixed(2)}`;
        document.querySelector('.summary-row.tax span:last-child').textContent = `$${tax.toFixed(2)}`;
        document.querySelector('.summary-row.discount span:last-child').textContent = `-$${discount.toFixed(2)}`;

        const total = subtotal + tax + shipping - discount;
        document.querySelector('.summary-row.total span:last-child').textContent = `$${total.toFixed(2)}`;

        // 更新 shipping 费用同步（动态切换配送方式时也能同步 total）
        const deliveryOptions = document.querySelectorAll('input[name="delivery-method"]');
        deliveryOptions.forEach(option => {
            option.addEventListener('change', () => {
                shipping = shippingMap[option.value];
                document.getElementById('shipping-cost').textContent = `$${shipping.toFixed(2)}`;
                const updatedTotal = subtotal + tax + shipping - discount;
                document.querySelector('.summary-row.total span:last-child').textContent = `$${updatedTotal.toFixed(2)}`;
            });
        });

    document.addEventListener('DOMContentLoaded', function () {
        const shippingDisplay = document.getElementById('shipping-cost');
        const deliveryOptions = document.querySelectorAll('input[name="delivery-method"]');

        const prices = {
            'standard': '$5.99',
            'express': '$9.99',
            'pickup': '$0.00'
        };

        function updateShippingPrice() {
            const selected = document.querySelector('input[name="delivery-method"]:checked').value;
            shippingDisplay.textContent = prices[selected];
        }

        deliveryOptions.forEach(option => {
            option.addEventListener('change', updateShippingPrice);
        });

        updateShippingPrice(); // 初始化一次
    });

    document.addEventListener('DOMContentLoaded', function () {
        const proceedBtn = document.getElementById('proceed-checkout');

        proceedBtn.addEventListener('click', function () {
            const form = document.querySelector('form[action="delivery.php"]');
            if (!form) {
                alert('Form not found.');
                return;
            }

            const selectedMethod = document.querySelector('input[name="delivery-method"]:checked');
            const selectedAddress = document.querySelector('input[name="delivery_id"]:checked');
            if (!selectedMethod) {
                alert('Please select a delivery method.');
                return;
            }
            const firstName = document.getElementById('first-name').value.trim();
            const lastName = document.getElementById('last-name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const addressLine1 = document.getElementById('address-line1').value.trim();
            const city = document.getElementById('city').value.trim();
            const state = document.getElementById('state').value.trim();
            const zip = document.getElementById('zip').value.trim();

            // ✅ 如果选择了已保存地址
            if (selectedAddress) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'delivery_id';
                hiddenInput.value = selectedAddress.value;
                form.appendChild(hiddenInput);
                form.submit();
                return;
            }

            // ✅ 如果填写了完整的新地址
            if (firstName && lastName && phone && addressLine1 && city && state && zip) {
                form.submit();
                return;
            }

            // ❌ 两者都没填
            alert('Please select a saved address or complete the new address form.');
        });
    });

    </script>
</body>
</html>
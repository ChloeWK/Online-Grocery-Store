<?php
// 包含配置文件
include_once __DIR__ . '/../config.php';

// 设置页面特定变量
$page_title = 'Shopping Cart';

// 确保会话已启动
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - FreshMart</title>
    <!-- 引入样式文件 -->
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <!-- 包含header -->
    <?php include_once __DIR__ . '/../shared/header.php'; ?>

    <main class="cart-page">
        <div class="container">
            <!-- 空购物车状态 -->
            <div id="empty-cart">
                <div class="empty-cart-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added any products to your cart yet.</p>
                <a href="../index.php" class="continue-shopping-btn">Continue Shopping</a>
            </div>
            
            <!-- 购物车内容 -->
            <div id="cart-content" style="display: none;">
                <div class="cart-layout">
                    <div class="cart-main">
                        <!-- 购物车表格 -->
                        <div class="cart-table-wrapper">
                            <table class="cart-table">
                                <thead class="cart-header">
                                    <tr>
                                        <th class="product-col">PRODUCT</th>
                                        <th class="price-col">PRICE</th>
                                        <th class="quantity-col">QUANTITY</th>
                                        <th class="total-col">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                    <!-- 购物车项目将通过JavaScript动态添加 -->
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- 购物车操作 -->
                        <div class="cart-actions">
                            <a href="../index.php" class="continue-shopping">Continue Shopping</a>
                            <button id="clear-cart" class="clear-cart">Clear Cart</button>
                        </div>
                    </div>
                    
                    <div class="cart-sidebar">
                        <!-- 订单摘要 -->
                        <div class="order-summary">
                            <h2>Order Summary</h2>
                            
                            <div class="summary-row">
                                <span class="summary-label">Subtotal</span>
                                <span class="summary-value" id="cart-subtotal">$0.00</span>
                            </div>
                            
                            <div class="summary-row">
                                <span class="summary-label">Shipping</span>
                                <span class="summary-value" id="cart-shipping">$5.00</span>
                            </div>
                            
                            <div class="summary-row total-row">
                                <span class="summary-label">Total</span>
                                <span class="summary-value" id="cart-total">$5.00</span>
                            </div>
                            
                            <a href="delivery.php" class="proceed-checkout">Proceed to Checkout</a>
                            
                            <div class="coupon-section">
                                <h3>Have a Coupon?</h3>
                                <div class="coupon-form">
                                    <input type="text" placeholder="Enter coupon code" class="coupon-input">
                                    <button class="apply-button">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- 包含footer -->
    <?php include_once __DIR__ . '/../shared/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 获取购物车数据
            let cartItems = localStorage.getItem('cartItems') ? 
                JSON.parse(localStorage.getItem('cartItems')) : [];
            
            // 根据购物车状态显示相应内容
            if (!cartItems || cartItems.length === 0) {
                document.getElementById('empty-cart').style.display = 'block';
                document.getElementById('cart-content').style.display = 'none';
            } else {
                document.getElementById('empty-cart').style.display = 'none';
                document.getElementById('cart-content').style.display = 'block';
                
                // 渲染购物车项目
                renderCartItems();
            }
            
            // 渲染购物车项目
            function renderCartItems() {
                const cartItemsContainer = document.getElementById('cart-items');
                cartItemsContainer.innerHTML = '';
                
                cartItems.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = 'cart-item';
                    row.setAttribute('data-id', item.id);
                    
                    row.innerHTML = `
                        <td class="product-col">
                            <div class="product-info">
                                <img src="${item.image}" alt="${item.name}" class="product-image">
                                <div class="product-details">
                                    <div class="product-name">${item.name}</div>
                                    <a href="#" class="remove-link" data-index="${index}">Remove</a>
                                </div>
                            </div>
                        </td>
                        <td class="price-col">$${item.price.toFixed(2)}</td>
                        <td class="quantity-col">
                            <div class="quantity-control">
                                <button class="quantity-btn decrease-btn" data-index="${index}">-</button>
                                <input type="text" value="${item.quantity}" class="quantity-input" data-index="${index}">
                                <button class="quantity-btn increase-btn" data-index="${index}">+</button>
                            </div>
                        </td>
                        <td class="total-col">$${(item.price * item.quantity).toFixed(2)}</td>
                    `;
                    
                    cartItemsContainer.appendChild(row);
                });
                
                // 添加事件监听器
                addEventListeners();
                
                // 更新订单摘要
                updateOrderSummary();
                
                // 触发自定义事件，通知header更新购物车
                document.dispatchEvent(new CustomEvent('cartUpdated'));
            }
            
            // 添加事件监听器
            function addEventListeners() {
                // 删除按钮事件
                document.querySelectorAll('.remove-link').forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const index = parseInt(this.getAttribute('data-index'));
                        removeCartItem(index);
                    });
                });
                
                // 减少数量按钮事件
                document.querySelectorAll('.decrease-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        updateItemQuantity(index, -1);
                    });
                });
                
                // 增加数量按钮事件
                document.querySelectorAll('.increase-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        updateItemQuantity(index, 1);
                    });
                });
                
                // 数量输入框事件
                document.querySelectorAll('.quantity-input').forEach(function(input) {
                    input.addEventListener('change', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        let value = parseInt(this.value);
                        
                        if (isNaN(value) || value < 1) {
                            value = 1;
                            this.value = 1;
                        }
                        
                        setItemQuantity(index, value);
                    });
                });
                
                // 清空购物车按钮事件
                document.getElementById('clear-cart').addEventListener('click', function() {
                    if (confirm('Are you sure you want to clear your cart?')) {
                        clearCart();
                    }
                });
                
                // 应用优惠券按钮事件
                document.querySelector('.apply-button').addEventListener('click', function() {
                    const couponCode = document.querySelector('.coupon-input').value.trim();
                    if (couponCode) {
                        alert('Coupon code applied: ' + couponCode);
                    } else {
                        alert('Please enter a coupon code');
                    }
                });
            }
            
            // 更新商品数量
            function updateItemQuantity(index, change) {
                if (cartItems[index]) {
                    cartItems[index].quantity += change;
                    
                    // 确保数量不小于1
                    if (cartItems[index].quantity < 1) {
                        cartItems[index].quantity = 1;
                    }
                    
                    // 保存更新后的购物车
                    saveCartItems();
                    
                    // 更新UI
                    renderCartItems();
                }
            }
            
            // 设置商品数量
            function setItemQuantity(index, quantity) {
                if (cartItems[index]) {
                    cartItems[index].quantity = quantity;
                    
                    // 保存更新后的购物车
                    saveCartItems();
                    
                    // 更新UI
                    renderCartItems();
                }
            }
            
            // 从购物车中删除商品
            function removeCartItem(index) {
                if (confirm('Are you sure you want to remove this item?')) {
                    if (cartItems[index]) {
                        cartItems.splice(index, 1);
                        
                        // 保存更新后的购物车
                        saveCartItems();
                        
                        // 如果购物车为空，显示空购物车状态
                        if (cartItems.length === 0) {
                            document.getElementById('empty-cart').style.display = 'block';
                            document.getElementById('cart-content').style.display = 'none';
                        } else {
                            // 更新UI
                            renderCartItems();
                        }
                    }
                }
            }
            
            // 清空购物车
            function clearCart() {
                cartItems = [];
                
                // 保存更新后的购物车
                saveCartItems();
                
                // 显示空购物车状态
                document.getElementById('empty-cart').style.display = 'block';
                document.getElementById('cart-content').style.display = 'none';
                
                // 触发自定义事件，通知header更新购物车
                document.dispatchEvent(new CustomEvent('cartUpdated'));
            }
            
            // 保存购物车数据到localStorage
            function saveCartItems() {
                localStorage.setItem('cartItems', JSON.stringify(cartItems));
                
                // 触发自定义事件，通知header更新购物车
                document.dispatchEvent(new CustomEvent('cartUpdated'));
            }
            
            // 更新订单摘要
            function updateOrderSummary() {
                let subtotal = 0;
                
                cartItems.forEach(item => {
                    subtotal += item.price * item.quantity;
                });
                
                const shipping = 5.00; // 固定运费
                const total = subtotal + shipping;
                
                // 更新订单摘要
                document.getElementById('cart-subtotal').textContent = '$' + subtotal.toFixed(2);
                document.getElementById('cart-shipping').textContent = '$' + shipping.toFixed(2);
                document.getElementById('cart-total').textContent = '$' + total.toFixed(2);
            }
        });
    </script>
</body>
</html>

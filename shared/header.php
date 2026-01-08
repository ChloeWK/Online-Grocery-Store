<?php
// Make sure the conversation has started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../config.php'; // database connection

// Check whether the user has logged in
$is_logged_in = isset($_SESSION['user_id']);
$current_user_id = $is_logged_in ? $_SESSION['user_id'] : null;
$username = $is_logged_in ? $_SESSION['username'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?php echo $base_url; ?>">
</head>
<body>

<header class="site-header">
    <div class="header-top">
        <div class="container">
            <div class="logo">
                <a href="<?php echo $base_url; ?>index.php">
                    <img src="<?php echo $base_url; ?>assets/images/logo.png" alt="FreshMart Logo">
                </a>
            </div>
            
            <div class="search-bar">
                <form action="<?php echo $base_url; ?>search/search-result.php" method="get">
                    <input type="text" name="query" placeholder="Search for products...">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <div class="header-actions">
                <!-- sign in/profile -->
                <?php if ($is_logged_in): ?>
                    <!-- The user has logged in, and the username and link to the profile page are displayed -->
                    <a href="<?php echo $base_url; ?>account/profile.php" class="header-action log-in">
                        <i class="fas fa-user"></i>
                        <span><?php echo htmlspecialchars($username); ?></span>
                    </a>
                <?php else: ?>
                    <!-- The user is not logged in. Display the login link -->
                    <a href="<?php echo $base_url; ?>account/login.php" class="header-action log-in">
                        <i class="fas fa-user"></i>
                        <span>Sign In</span>
                    </a>
                <?php endif; ?>

                <!-- Shopping cart icon + floating window sidebar -->
                <div class="header-action-wrapper">

                    <!-- Shopping cart icon -->
                    <a href="javascript:void(0);" class="header-action cart" id="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count" id="header-cart-count">0</span>
                        <span>Cart</span>
                    </a>

                    <!-- mask layer -->
                    <div id="cart-overlay" class="cart-overlay"></div>

                    <!--  Floating window on the side shopping cart -->
                    <div id="cart-popup" class="cart-popup">
                        <div class="cart-popup-header">
                            <h3>Cart <span id="cart-popup-count">0</span> item(s)</h3>
                            <button id="close-cart-popup" class="close-cart-popup">&times;</button>
                        </div>

                        <div class="cart-popup-items" id="cart-popup-items">
                            <div class="empty-cart-message" id="empty-cart-message">
                                Your cart is empty.
                            </div>
                        </div>

                        <div class="cart-popup-footer">
                            <div class="cart-actions">
                                <button class="save-list-btn">Save as a list</button>
                                <button class="remove-all-btn">Remove all</button>
                            </div>

                            <div class="cart-subtotal">
                                <div class="subtotal-label">
                                    <span>Subtotal</span>
                                    <span class="service-fees">Excluding service fees</span>
                                </div>
                                <div class="subtotal-amount">
                                    <span id="cart-popup-subtotal">$0.00</span>
                                    <span class="savings" id="cart-savings"></span>
                                </div>
                            </div>

                            <a href="<?php echo $base_url; ?>order/cart.php" class="checkout-button">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="main-nav">
        <div class="nav-container">
            <ul class="nav-list">
                <li class="has-dropdown">
                    <a href="#">Categories</a>
                    <div class="dropdown-menu">
                        <div class="dropdown-column">
                            <h3>Shop by Category</h3>
                            <ul>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=fresh">Fresh</a></li>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=frozen">Frozen</a></li>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=beverages">Beverages</a></li>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=home">Home</a></li>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=pet-food">Pet Food</a></li>
                            </ul>
                        </div>
                        <div class="dropdown-column">
                            <h3>Popular Categories</h3>
                            <ul>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=fruits-vegetables#fruits">Fruits</a></li>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=fruits-vegetables#vegetables">Vegetables</a></li>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=dairy-eggs">Dairy & Eggs</a></li>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=bakery">Bakery</a></li>
                                <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=meat-seafood">Meat & Seafood</a></li>
                            </ul>
                        </div>
                        <div class="dropdown-column">
                            <div class="promo-banner">
                                <img src="<?php echo $base_url; ?>assets/images/special-offers.jpg" alt="Special Offers">
                                <div class="promo-content">
                                    <h3>Weekly Specials</h3>
                                    <p>Save up to 50% on selected items</p>
                                    <a href="<?php echo $base_url; ?>discount/promotions.php" class="btn-small">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="<?php echo $base_url; ?>discount/promotions.php">Special Offers</a></li>
                <li><a href="<?php echo $base_url; ?>about.php">About Us</a></li>
                <li><a href="<?php echo $base_url; ?>contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>
    
    <!-- Mobile menu toggle and mobile menu -->
    <div class="mobile-header">
        <button class="menu-toggle" id="mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="logo">
            <a href="<?php echo $base_url; ?>index.php">
                <img src="<?php echo $base_url; ?>assets/images/logo.png" alt="FreshMart Logo">
            </a>
        </div>
        <div class="mobile-actions">
            <a href="javascript:void(0);" class="mobile-cart" id="mobile-cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count" id="mobile-cart-count">0</span>
            </a>
        </div>
    </div>
    
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-search">
            <form action="<?php echo $base_url; ?>search/search-result.php" method="get">
                <input type="text" name="query" placeholder="Search for products...">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <ul class="mobile-nav-list">
            <li><a href="<?php echo $base_url; ?>index.php">Home</a></li>
            <li class="mobile-dropdown">
                <a href="#" class="mobile-dropdown-toggle">Categories <i class="fas fa-chevron-down"></i></a>
                <ul class="mobile-submenu">
                    <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=fresh">Fresh</a></li>
                    <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=frozen">Frozen</a></li>
                    <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=beverages">Beverages</a></li>
                    <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=home">Home</a></li>
                    <li><a href="<?php echo $base_url; ?>categories/category-template.php?category=pet-food">Pet Food</a></li>
                </ul>
            </li>
            <li><a href="<?php echo $base_url; ?>discount/promotions.php">Special Offers</a></li>
            <li><a href="<?php echo $base_url; ?>about.php">About Us</a></li>
            <li><a href="<?php echo $base_url; ?>contact.php">Contact</a></li>
            <li class="mobile-account">
                <?php if ($is_logged_in): ?>
                    <a href="<?php echo $base_url; ?>account/profile.php">My Account (<?php echo htmlspecialchars($username); ?>)</a>
                <?php else: ?>
                    <a href="<?php echo $base_url; ?>account/login.php">Sign In</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</header>

<!-- Add a script to clear localStorage -->
<script>
// Ensure that the login status in localStorage is consistent with the PHP session
(function() {
    // Check the PHP session status
    var isLoggedInPHP = <?php echo $is_logged_in ? 'true' : 'false'; ?>;
    
    // Check the status of localStorage
    var isLoggedInLS = localStorage.getItem('userLoggedIn') === 'true';
    
    // If the PHP session shows that it is not logged in, but localStorage shows that it is logged in, clear localStorage
    if (!isLoggedInPHP && isLoggedInLS) {
        localStorage.removeItem('userLoggedIn');
        localStorage.removeItem('username');
        localStorage.removeItem('userId');
        localStorage.removeItem('userEmail');
        console.log('已清除localStorage中的登录状态');
    }
})();

// Initialize the shopping cart
document.addEventListener('DOMContentLoaded', function() {
    updateHeaderCart();
    
    // Listen for the cartUpdated event
    document.addEventListener('cartUpdated', function() {
        updateHeaderCart();
    });
    
    // Listen for the storage event and update it synchronously when other pages update the shopping cart
    window.addEventListener('storage', function(e) {
        if (e.key === 'cartItems') {
            updateHeaderCart();
        }
    });
    
    // Shopping cart icon click event
    const cartIcon = document.getElementById('cart-icon');
    const mobileCartIcon = document.getElementById('mobile-cart-icon');
    const cartPopup = document.getElementById('cart-popup');
    const closeCartPopup = document.getElementById('close-cart-popup');
    const cartOverlay = document.getElementById('cart-overlay');

    // Open the shopping cart
    function openCartPopup() {
        if (cartPopup) cartPopup.classList.add('active');
        if (cartOverlay) cartOverlay.style.display = 'block';
    }

    // Close the shopping cart
    function closeCartPopupFn() {
        if (cartPopup) cartPopup.classList.remove('active');
        if (cartOverlay) cartOverlay.style.display = 'none';
    }

    // Click the icon to open.
    if (cartIcon) {
        cartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            openCartPopup();
        });
    }

    if (mobileCartIcon) {
        mobileCartIcon.addEventListener('click', function(e) {
            e.preventDefault();
            openCartPopup();
        });
    }

    // Click the close button to close
    if (closeCartPopup) {
        closeCartPopup.addEventListener('click', function(e) {
            e.preventDefault();
            closeCartPopupFn();
        });
    }

    // Click the mask layer to close
    if (cartOverlay) {
        cartOverlay.addEventListener('click', function() {
            closeCart();
        });
    }

    // Click the external close shopping cart pop-up window
    if (cartPopup && cartPopup.classList.contains('active')) {
        // Check whether the clicked element is inside the shopping cart pop-up window or the shopping cart icon
        const isClickInsidePopup = cartPopup.contains(e.target);
        const isClickOnCartIcon = cartIcon && (cartIcon === e.target || cartIcon.contains(e.target));
        const isClickOnMobileCartIcon = mobileCartIcon && (mobileCartIcon === e.target || mobileCartIcon.contains(e.target));
        
        if (!isClickInsidePopup && !isClickOnCartIcon && !isClickOnMobileCartIcon) {
            cartPopup.classList.remove('active');
            console.log('Clicked outside, popup closed');
        }
    }
    
    // Mobile menu switch
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            this.classList.toggle('active');
        });
    }
    
    // Mobile pull-down menu
    const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
    
    mobileDropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle('active');
            
            // Switch icon
            const icon = this.querySelector('i');
            if (parent.classList.contains('active')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
    });
    
    // Save the list and clear the shopping cart buttons
    const saveListBtn = document.querySelector('.save-list-btn');
    const removeAllBtn = document.querySelector('.remove-all-btn');
    
    if (saveListBtn) {
        saveListBtn.addEventListener('click', function() {
            alert('Your shopping list has been saved!');
        });
    }
    
    if (removeAllBtn) {
        removeAllBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove all items from your cart?')) {
                localStorage.setItem('cartItems', JSON.stringify([]));
                updateHeaderCart();
                showNotification('All items have been removed from your cart');
            }
        });
    }
});

// Update the header shopping cart
function updateHeaderCart() {
    // Obtain the shopping cart data
    const cartItems = localStorage.getItem('cartItems') ? 
        JSON.parse(localStorage.getItem('cartItems')) : [];
    
    // Update the shopping cart count
    const itemCount = cartItems.reduce((total, item) => total + item.quantity, 0);
    const headerCartCount = document.getElementById('header-cart-count');
    const mobileCartCount = document.getElementById('mobile-cart-count');
    const cartPopupCount = document.getElementById('cart-popup-count');
    
    if (headerCartCount) {
        headerCartCount.textContent = itemCount;
        headerCartCount.style.display = itemCount > 0 ? 'flex' : 'none';
    }
    
    if (mobileCartCount) {
        mobileCartCount.textContent = itemCount;
        mobileCartCount.style.display = itemCount > 0 ? 'flex' : 'none';
    }
    
    if (cartPopupCount) {
        cartPopupCount.textContent = itemCount;
    }
    
    // Update the content of the shopping cart pop-up window
    const cartPopupItems = document.getElementById('cart-popup-items');
    
    if (cartPopupItems) {
        // Clear the current content
        cartPopupItems.innerHTML = '';
        
        if (cartItems.length === 0) {
            // Display an empty shopping cart message
            const emptyMessage = document.createElement('div');
            emptyMessage.className = 'empty-cart-message';
            emptyMessage.id = 'empty-cart-message';
            emptyMessage.textContent = 'Your cart is empty.';
            cartPopupItems.appendChild(emptyMessage);
            
            // Hide the save list and delete all buttons
            const saveListBtn = document.querySelector('.save-list-btn');
            const removeAllBtn = document.querySelector('.remove-all-btn');
            if (saveListBtn) saveListBtn.style.display = 'none';
            if (removeAllBtn) removeAllBtn.style.display = 'none';
        } else {
            // Show the save list and delete all buttons
            const saveListBtn = document.querySelector('.save-list-btn');
            const removeAllBtn = document.querySelector('.remove-all-btn');
            if (saveListBtn) saveListBtn.style.display = 'block';
            if (removeAllBtn) removeAllBtn.style.display = 'block';
            
            // Add shopping cart items
            cartItems.forEach((item, index) => {
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                
                // Calculate the savings amount (if there is an original price)
                let saveHtml = '';
                let originalPriceHtml = '';
                
                if (item.originalPrice && item.originalPrice > item.price) {
                    const savings = (item.originalPrice - item.price).toFixed(2);
                    saveHtml = `<span class="cart-item-save">SAVE $${savings}</span>`;
                    originalPriceHtml = `<span class="cart-item-original-price">Was $${Number(item.originalPrice).toFixed(2)}</span>`;
                }
                
                cartItem.innerHTML = `
                    <div class="cart-item-image">
                        <img src="${item.image || '../assets/images/products/placeholder.jpg'}" alt="${item.name}">
                    </div>
                    <div class="cart-item-details">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-price">
                            ${originalPriceHtml}
                            <span class="current-price">$${Number(item.price).toFixed(2)}</span>
                            ${saveHtml}
                        </div>
                        <div class="cart-item-quantity">
                            <button class="quantity-btn quantity-decrease" data-index="${index}">-</button>
                            <span class="quantity-value">${item.quantity}</span>
                            <button class="quantity-btn quantity-increase" data-index="${index}">+</button>
                        </div>
                    </div>
                    <button class="cart-item-remove" data-index="${index}">&times;</button>
                `;
                
                cartPopupItems.appendChild(cartItem);
            });
            
            // Add and delete button events
            document.querySelectorAll('.cart-item-remove').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const index = parseInt(this.getAttribute('data-index'));
                    removeCartItem(index);
                });
            });
            
            // Add quantity increase and decrease button events
            document.querySelectorAll('.quantity-decrease').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const index = parseInt(this.getAttribute('data-index'));
                    updateCartItemQuantity(index, -1);
                });
            });
            
            document.querySelectorAll('.quantity-increase').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const index = parseInt(this.getAttribute('data-index'));
                    updateCartItemQuantity(index, 1);
                });
            });
        }
        
        // Update the widget
        updateCartSubtotal();
    }
}

// Update the shopping cart subcount
function updateCartSubtotal() {
    const cartItems = localStorage.getItem('cartItems') ? 
        JSON.parse(localStorage.getItem('cartItems')) : [];
    
    let subtotal = 0;
    let originalTotal = 0;
    
    cartItems.forEach(item => {
        subtotal += item.price * item.quantity;
        if (item.originalPrice && item.originalPrice > item.price) {
            originalTotal += item.originalPrice * item.quantity;
        } else {
            originalTotal += item.price * item.quantity;
        }
    });
    
    const cartPopupSubtotal = document.getElementById('cart-popup-subtotal');
    const cartSavings = document.getElementById('cart-savings');
    
    if (cartPopupSubtotal) {
        cartPopupSubtotal.textContent = '$' + subtotal.toFixed(2);
    }
    
    if (cartSavings && originalTotal > subtotal) {
        const savings = originalTotal - subtotal;
        cartSavings.textContent = `You save $${savings.toFixed(2)}`;
        cartSavings.style.display = 'inline-block';
    } else if (cartSavings) {
        cartSavings.style.display = 'none';
    }
}

// Update the shopping cart subcount
function updateCartItemQuantity(index, change) {
    const cartItems = localStorage.getItem('cartItems') ? 
        JSON.parse(localStorage.getItem('cartItems')) : [];
    
    if (cartItems[index]) {
        cartItems[index].quantity += change;
        
        // Ensure that the quantity is not less than 1
        if (cartItems[index].quantity < 1) {
            cartItems[index].quantity = 1;
        }
        
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateHeaderCart();
        
        // Display notifications
        if (change > 0) {
            showNotification(`Added one more ${cartItems[index].name} to your cart`);
        } else if (change < 0 && cartItems[index].quantity > 0) {
            showNotification(`Removed one ${cartItems[index].name} from your cart`);
        }
    }
}

// Delete items from the shopping cart
function removeCartItem(index) {
    const cartItems = localStorage.getItem('cartItems') ? 
        JSON.parse(localStorage.getItem('cartItems')) : [];
    
    if (cartItems[index]) {
        const removedItem = cartItems[index];
        cartItems.splice(index, 1);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        
        // Update the shopping cart UI
        updateHeaderCart();
        
        // Display notification
        showNotification(`${removedItem.name} has been removed from your cart`);
        
        // If it is on the shopping cart page, refresh the page
        if (window.location.href.includes('cart.php')) {
            location.reload();
        }
    }
}

// Display notification
function showNotification(message) {
    // Check whether the notification element already exists
    let notification = document.querySelector('.notification');
    
    // If it doesn't exist, create one
    if (!notification) {
        notification = document.createElement('div');
        notification.className = 'notification';
        document.body.appendChild(notification);
    }
    
    // Hide the notification in 3 seconds
    notification.textContent = message;
    notification.classList.add('show');
    
    // Hide the notification in 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}
    
    document.addEventListener("cartUpdated", function () {
        // Obtain the latest quantity of goods in localStorage
        const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
        const count = cartItems.reduce((total, item) => total + item.quantity, 0);
        document.getElementById("header-cart-count").textContent = count;
        document.getElementById("cart-popup-count").textContent = count;

        const itemsContainer = document.getElementById("cart-popup-items");
        itemsContainer.innerHTML = "";
        if (cartItems.length === 0) {
            itemsContainer.innerHTML = '<div class="empty-cart-message">Your cart is empty.</div>';
        } else {
            cartItems.forEach(item => {
                const div = document.createElement("div");
                div.className = "cart-item";
                div.innerHTML = `<p>${item.name} × ${item.quantity}</p>`;
                itemsContainer.appendChild(div);
            });
        }

        document.getElementById("cart-popup").classList.add("active");
    });
</script>

<!-- Ensure that Font Awesome is loaded -->
<script>
    // Check whether Font Awesome has been loaded
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.querySelector('link[href*="font-awesome"]')) {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
            document.head.appendChild(link);
            console.log('Font Awesome dynamically loaded');
        }
    });
</script>
</body>
</html>
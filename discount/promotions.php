<?php
// 包含配置文件
include_once __DIR__ . '/../config.php';

// 设置页面特定变量
$page_title = 'Promotion - ' . $site_title;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Offers & Promotions - FreshMart</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="promotions.css">
</head>
<body>
    <!-- Header (Same as index.html) -->
    <?php include __DIR__ . '/../shared/header.php'; ?>

<?php
$query = "SELECT p.* FROM products p
          JOIN product_tags pt ON p.product_id = pt.product_id
          WHERE pt.tag_id = 14
          ORDER BY RAND() LIMIT 8";

$result = $mysqli->query($query);
?>



    <main class="promotions-page">
        <!-- Hero Banner -->
        <div class="promo-hero">
            <div class="hero-content">
                <h1>Special Offers & Promotions</h1>
                <p>Save big on your favorite products with our limited-time offers!</p>
            </div>
        </div>
        
        <div class="container">
            <!-- Featured Deals -->
            <section class="featured-deals">
                <h2>Featured Deals</h2>
                
                <div class="deals-grid">
                    <div class="deal-card large">
                        <div class="deal-image">
                            <img src="../assets/images/promotions/fresh-produce.jpg" alt="Fresh Produce Sale">
                            <div class="deal-badge">20% OFF</div>
                        </div>
                        <div class="deal-content">
                            <h3>Fresh Produce Sale</h3>
                            <p>Save 20% on all fresh fruits and vegetables</p>
                            <p class="deal-dates">Valid until April 20, 2023</p>
                            <a href="../categories/category-template.php?category=fresh" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                    
                    <div class="deal-card">
                        <div class="deal-image">
                            <img src="../assets/images/promotions/dairy-products.jpg" alt="Dairy Products">
                            <div class="deal-badge">Buy 2 Get 1</div>
                        </div>
                        <div class="deal-content">
                            <h3>Dairy Products</h3>
                            <p>Buy 2 get 1 free on selected dairy products</p>
                            <p class="deal-dates">Valid until April 25, 2023</p>
                            <a href="../categories/category-template.php?category=dairy&eggs" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                    
                    <div class="deal-card">
                        <div class="deal-image">
                            <img src="../assets/images/promotions/organic-products.jpg" alt="Organic Products">
                            <div class="deal-badge">15% OFF</div>
                        </div>
                        <div class="deal-content">
                            <h3>Organic Products</h3>
                            <p>15% off on all organic products</p>
                            <p class="deal-dates">Valid until April 30, 2023</p>
                            <a href="../search/search-result.php?query=organic" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Weekly Specials -->
            <?php if ($result && $result->num_rows > 0): ?>
            <section class="weekly-specials">
                <div class="section-header">
                    <h2>Weekly Promotions</h2>
                    <p>Handpicked deals just for you</p>
                </div>

                <div class="product-grid">
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product-card clickable-card"
                        data-url="<?php echo $base_url; ?>products/product-detail.php?product_id=<?php echo urlencode($row['product_id']); ?>">
                        <div class="product-image">
                            <img src="<?php echo $base_url . 'assets/images/products/' . $row['image']; ?>" 
                                alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                            <?php if (!empty($row['original_price']) && $row['original_price'] > $row['price']): 
                                $discount = round(100 * (1 - $row['price'] / $row['original_price']));
                            ?>
                            <div class="product-tag"><?php echo $discount; ?>% OFF</div>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                            <p class="price">
                                <?php if (!empty($row['original_price']) && $row['original_price'] > $row['price']): ?>
                                    <span class="original-price">$<?php echo number_format($row['original_price'], 2); ?></span>
                                <?php endif; ?>
                                $<?php echo number_format($row['price'], 2); ?>
                            </p>
                            <div class="rating">
                                <?php 
                                    $rating = (int)round($row['rating']); // 取整
                                    echo str_repeat('★', $rating);
                                    echo str_repeat('☆', 5 - $rating);
                                ?>
                            </div>
                        </div>
                        <button class="add-to-cart"
                        data-product-id="P001"
                        data-name="Fresh Milk"
                        data-price="3.99"
                        data-image="milk.jpg">Add to Cart</button>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>
        
<?php else: ?>
    <p style="text-align:center; margin-top: 2rem;">No promotions found for this tag.</p>
<?php endif; ?>

            <!-- Bundle Deals -->
            <section class="bundle-deals">
                <h2>Bundle Deals</h2>
                
                <div class="bundle-grid">
                    <div class="bundle-card">
                        <div class="bundle-image">
                            <img src="../assets/images/promotions/breakfast-bundle.jpg" alt="Breakfast Bundle">
                        </div>
                        <div class="bundle-content">
                            <h3>Breakfast Bundle</h3>
                            <p>Get everything you need for a perfect breakfast</p>
                            <ul class="bundle-items">
                                <li>Organic Eggs (1 dozen)</li>
                                <li>Whole Wheat Bread (1 loaf)</li>
                                <li>Fresh Orange Juice (1 gallon)</li>
                                <li>Organic Coffee (12 oz)</li>
                            </ul>
                            <div class="bundle-price">
                                <span class="original-price">$24.96</span>
                                <span class="current-price">$19.99</span>
                                <span class="savings">Save $4.97</span>
                            </div>
                            <button class="btn btn-primary">Add Bundle to Cart</button>
                        </div>
                    </div>
                    
                    <div class="bundle-card">
                        <div class="bundle-image">
                            <img src="../assets/images/promotions/pasta-night-bundle.jpg" alt="Pasta Night Bundle">
                        </div>
                        <div class="bundle-content">
                            <h3>Pasta Night Bundle</h3>
                            <p>Everything you need for a delicious Italian dinner</p>
                            <ul class="bundle-items">
                                <li>Premium Italian Pasta (2 packs)</li>
                                <li>Organic Tomato Sauce (16 oz)</li>
                                <li>Parmesan Cheese (8 oz)</li>
                                <li>Italian Herb Mix (2 oz)</li>
                            </ul>
                            <div class="bundle-price">
                                <span class="original-price">$18.96</span>
                                <span class="current-price">$14.99</span>
                                <span class="savings">Save $3.97</span>
                            </div>
                            <button class="btn btn-primary">Add Bundle to Cart</button>
                        </div>
                    </div>
                    
                    <div class="bundle-card">
                        <div class="bundle-image">
                            <img src="../assets/images/promotions/smoothie-bundle.jpg" alt="Smoothie Bundle">
                        </div>
                        <div class="bundle-content">
                            <h3>Smoothie Bundle</h3>
                            <p>Start your day with a healthy smoothie</p>
                            <ul class="bundle-items">
                                <li>Organic Bananas (1 bunch)</li>
                                <li>Fresh Strawberries (16 oz)</li>
                                <li>Organic Spinach (8 oz)</li>
                                <li>Greek Yogurt (32 oz)</li>
                            </ul>
                            <div class="bundle-price">
                                <span class="original-price">$16.96</span>
                                <span class="current-price">$12.99</span>
                                <span class="savings">Save $3.97</span>
                            </div>
                            <button class="btn btn-primary">Add Bundle to Cart</button>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Coupon Codes -->
            <section class="coupon-codes">
                <h2>Exclusive Coupon Codes</h2>
                
                <div class="coupons-grid">
                    <div class="coupon-card">
                        <div class="coupon-header">
                            <h3>$10 OFF</h3>
                            <p>On orders over $50</p>
                        </div>
                        <div class="coupon-code">
                            <span>FRESH10</span>
                            <button class="btn-copy">Copy</button>
                        </div>
                        <p class="coupon-expiry">Valid until April 30, 2023</p>
                    </div>
                    
                    <div class="coupon-card">
                        <div class="coupon-header">
                            <h3>15% OFF</h3>
                            <p>On your first order</p>
                        </div>
                        <div class="coupon-code">
                            <span>WELCOME15</span>
                            <button class="btn-copy">Copy</button>
                        </div>
                        <p class="coupon-expiry">Valid for new customers only</p>
                    </div>
                    
                    <div class="coupon-card">
                        <div class="coupon-header">
                            <h3>Free Delivery</h3>
                            <p>On orders over $35</p>
                        </div>
                        <div class="coupon-code">
                            <span>FREESHIP</span>
                            <button class="btn-copy">Copy</button>
                        </div>
                        <p class="coupon-expiry">Valid until April 25, 2023</p>
                    </div>
                </div>
            </section>
            
            <!-- Newsletter Signup -->
            <section class="newsletter-signup">
                <div class="newsletter-content">
                    <h2>Get Exclusive Deals</h2>
                    <p>Sign up for our newsletter to receive exclusive deals and promotions directly to your inbox.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer (Same as index.html) -->
    <?php include __DIR__ . '/../shared/footer.php'; ?>

    <script>
    function addToCart(productId, productName, price, quantity, originalPrice, image) {
        const cartItems = localStorage.getItem("cartItems") ? JSON.parse(localStorage.getItem("cartItems")) : [];

        const existingIndex = cartItems.findIndex(item => item.product_id === productId);
        if (existingIndex > -1) {
            cartItems[existingIndex].quantity += quantity;
        } else {
            cartItems.push({
                product_id: productId,
                name: productName,
                price: parseFloat(price),
                original_price: originalPrice ? parseFloat(originalPrice) : null,
                quantity: quantity,
                image: image
            });
        }

        localStorage.setItem("cartItems", JSON.stringify(cartItems));
        document.dispatchEvent(new CustomEvent("cartUpdated"));
        alert(`${productName} added to your cart!`);
    }
    
    document.addEventListener('DOMContentLoaded', function () {
        // Copy coupon code functionality
        const copyButtons = document.querySelectorAll('.btn-copy');
        copyButtons.forEach(button => {
            button.addEventListener('click', function () {
                const couponCode = this.previousElementSibling.textContent;
                navigator.clipboard.writeText(couponCode).then(() => {
                    const originalText = this.textContent;
                    this.textContent = 'Copied!';
                    setTimeout(() => {
                        this.textContent = originalText;
                    }, 2000);
                });
            });
        });

        // Card click jump to product detail
        document.querySelectorAll('.clickable-card').forEach(card => {
            card.addEventListener('click', function (e) {
                if (!e.target.closest('button')) {
                    const url = this.getAttribute('data-url');
                    window.location.href = url;
                }
            });
        });

        // Add bundle to cart
        const bundleButtons = document.querySelectorAll('.bundle-card .btn-primary');
        bundleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const bundleName = this.closest('.bundle-card').querySelector('h3').textContent;
                alert(`${bundleName} added to your cart!`);
            });
        });

        // Add individual product to cart
        /*const addToCartButtons = document.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productName = this.closest('.product-card').querySelector('h3').textContent;
                alert(`${productName} added to your cart!`);
            });
        });
    });*/
    </script>

</body>
</html>
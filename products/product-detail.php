<?php
// 包含配置文件
include_once __DIR__ . '/../config.php';

// 获取产品ID和slug
$product_id = isset($_GET['id']) ? $_GET['id'] : '';
$product_slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// 如果没有提供产品ID，重定向到首页
if (empty($product_id)) {
    header("Location: " . $base_url . "index.php");
    exit;
}

$slug = $_GET['slug'] ?? '';

if (!$slug) {
    die("No slug provided.");
}

$stmt = $mysqli->prepare("SELECT * FROM products WHERE slug = ?");
if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

// 设置页面标题
$page_title = $product['product_name'] . ' - ' . $site_title;

$stmt_related = $mysqli->prepare("SELECT * FROM products WHERE category = ? AND product_id != ? LIMIT 4");

if (!$stmt_related) {
    die("Prepare for related products failed: " . $mysqli->error);
}

$stmt_related->bind_param("ss", $product['category'], $product_id);
$stmt_related->execute();
$related_products = $stmt_related->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_related->close();
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
    <link rel="stylesheet" href="<?php echo $base_url; ?>products/product-detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php include __DIR__ . '/../shared/header.php'; ?>

<main class="product-page">
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo $base_url; ?>index.php">Home</a>
        <span class="separator">/</span>
        <a href="<?php echo $base_url; ?>categories/category-template.php?category=<?php echo strtolower(str_replace(' ', '-', $product['category'])); ?>"><?php echo $product['category']; ?></a>
        <span class="separator">/</span>
        <span><?php echo $product['product_name']; ?></span>
    </div>

    <div class="product-detail">
        <div class="product-images">
            <div class="main-image">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" id="main-product-image">
            </div>
            <!-- 如果有缩略图，可以添加以下代码 -->
            <!-- <div class="thumbnail-images">
                <div class="thumbnail active" onclick="changeImage('<?php echo $product['image']; ?>', this)">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?> thumbnail">
                </div>
                <!-- 更多缩略图 -->
            <!-- </div> -->
        </div>

        <div class="product-info">
            <div class="product-info-section">
                <div class="product-category"><?php echo $product['category']; ?></div>
                <h1 class="product-title"><?php echo $product['product_name']; ?></h1>
                <div class="product-rating">
                    <div class="stars">
                        <?php
                            $full_stars = floor($product['rating']);
                            $half_star = $product['rating'] - $full_stars > 0;
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($i <= $full_stars || ($half_star && $i === $full_stars + 1)) ? '★' : '☆';
                            }
                        ?>
                    </div>
                    <div class="review-count">(<?php echo $product['reviews_count']; ?> Comments)</div>
                </div>
            </div>

            <div class="price-section">
                <div class="product-price">
                    <span class="current-price">$<?php echo $product['price']; ?></span>
                    <?php if ($product['original_price'] > $product['price']): ?>
                        <span class="original-price">$<?php echo $product['original_price']; ?></span>
                    <?php endif; ?>
                    <span class="unit-price"><?php echo $product['unit_price']; ?></span>
                </div>
                <div class="stock-status">In Stock</div>
            </div>

            <div class="description-section">
                <h3 class="section-title">Product Description</h3>
                <div class="product-description">
                    <?php echo $product['product_description']; ?>
                </div>
            </div>

            <div class="details-section">
                <h3 class="section-title">Product Details</h3>
                <div class="product-details">
                    <div class="detail-row">
                        <div class="detail-label">Product Number:</div>
                        <div class="detail-value">FV-<?php echo $product['product_id']; ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Weight:</div>
                        <div class="detail-value"><?php echo $product['details']; ?></div>
                    </div>
                </div>
            </div>

            <div class="actions-section">
                <div class="quantity-selector">
                    <button class="quantity-btn minus" onclick="updateQuantity(-1)">−</button>
                    <input type="number" value="1" min="1" class="quantity-input" id="quantity">
                    <button class="quantity-btn plus" onclick="updateQuantity(1)">+</button>
                </div>
                <div class="product-actions">
                    <button class="add-to-cart-btn" onclick="addToCart(
                    '<?php echo $product['product_id']; ?>', 
                    '<?php htmlspecialchars($product['product_name'], ENT_QUOTES); ?>', 
                    <?php echo $product['price']; ?>,
                    null,
                    <?php echo $product['original_price'] ? $product['original_price'] : 'null'; ?>,
                    '<?php echo $product['image']; ?>'
                    )"><i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                    <button class="save-btn">
                        <i class="far fa-heart"></i> List
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="product-tabs">
        <div class="tabs-header">
            <button class="tab-btn active" data-tab="description">Description</button>
            <button class="tab-btn" data-tab="reviews">Reviews (<?php echo $product['reviews_count']; ?>)</button>
            <button class="tab-btn" data-tab="shipping">Shipping & Returns</button>
        </div>

        <div class="tab-content active" id="description-tab">
            <h3>Product Description</h3>
            <p><?php echo $product['product_description']; ?></p>
            <!-- Additional description can be added -->
            <h4>Product Features</h4>
            <ul>
                <li>High-quality ingredients</li>
                <li>Fresh delivery</li>
                <li>100% satisfaction guarantee</li>
            </ul>
        </div>

        <div class="tab-content" id="reviews-tab">
            <h3>Customer Reviews</h3>
            <p>This product has an average rating of <?php echo $product['rating']; ?> stars, based on <?php echo $product['reviews_count']; ?> reviews.</p>
            <!-- Review list can be added here -->
        </div>

        <div class="tab-content" id="shipping-tab">
            <h3>Shipping Information</h3>
            <ul>
                <li>Standard Delivery (2–3 business days): $5.99</li>
                <li>Express Delivery (1–2 business days): $9.99</li>
                <li>Free shipping on orders over $50</li>
            </ul>
            <p>We are confident in the quality of our products. If you're not satisfied with your purchase, please contact our customer service team within 30 days of receipt and we will resolve the issue for you.</p>
        </div>
    </div>

    <section class="related-products">
        <h2>You May Also Like</h2>
        <div class="product-grid">
            <?php foreach ($related_products as $related): ?>
                <div class="product-card" onclick="navigateToProduct('<?php echo $related['product_id']; ?>', '<?php echo $related['slug']; ?>')">
                    <div class="product-card-image">
                        <img src="<?php echo $related['image']; ?>" alt="<?php echo $related['product_name']; ?>">
                    </div>
                    <div class="product-card-info">
                        <div class="product-card-category"><?php echo $related['category']; ?></div>
                        <h3 class="product-card-title"><?php echo $related['product_name']; ?></h3>
                        <div class="product-card-price">$<?php echo $related['price']; ?></div>
                        <div class="product-card-unit"><?php echo $related['unit_price']; ?></div>
                        <button class="product-card-btn" onclick="event.stopPropagation(); addToCart('<?php echo $related['product_id']; ?>', '<?php echo $related['product_name']; ?>', <?php echo $related['price']; ?>)">Add to Cart</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</div>
</main>

<?php include __DIR__ . '/../shared/footer.php'; ?>
<script>
    function updateQuantity(change) {
        const quantityInput = document.getElementById('quantity');
        let value = parseInt(quantityInput.value);
        quantityInput.value = Math.max(1, value + change);
    }

    function addToCart(productId, productName, price, quantity = null, originalPrice = null, image = '') {
        const qty = quantity !== null ? quantity : parseInt(document.getElementById('quantity')?.value || 1);
        const cartItems = localStorage.getItem("cartItems") ? JSON.parse(localStorage.getItem("cartItems")) : [];
        const existingItemIndex = cartItems.findIndex(item => item.id === productId);

        if (existingItemIndex > -1) {
            cartItems[existingItemIndex].quantity += qty;
        } else {
            cartItems.push({
                product_id: productId,
                product_name: productName,
                price: parseFloat(price),
                original_price: originalPrice ? parseFloat(originalPrice) : null,
                quantity: qty,
                image: image
            });
        }

        localStorage.setItem("cartItems", JSON.stringify(cartItems));
        document.dispatchEvent(new CustomEvent("cartUpdated"));
        if (typeof showNotification === "function") {
            showNotification(`${qty} × ${productName} added to your cart!`);
        } else {
            alert(`${qty} × ${productName} added to cart.`);
}
    }

    function navigateToProduct(id, slug) {
        window.location.href = "<?php echo $base_url; ?>products/product-detail.php?slug=" + encodeURIComponent(slug);
    }
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(this.dataset.tab + '-tab').classList.add('active');
        });
    });
</script>
</body>
</html>

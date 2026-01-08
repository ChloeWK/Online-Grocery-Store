<?php
// Include configuration
include_once __DIR__ . '/../config.php';

// Get search query
$search_query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Set page title
$page_title = 'Search Results: ' . $search_query . ' - ' . $site_title;

// Redirect to homepage if search is empty
if (empty($search_query)) {
    header("Location: " . $base_url . "index.php");
    exit;
}

// Prepare SQL query - search product_name using LIKE
$stmt = $mysqli->prepare("SELECT * FROM products WHERE product_name LIKE ? ORDER BY rating DESC");
if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}

// Add wildcard
$search_param = "%" . $search_query . "%";
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();

// Count results
$products_count = $result->num_rows;
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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
    <link rel="stylesheet" href="<?php echo $base_url; ?>search/search-result.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php include __DIR__ . '/../shared/header.php'; ?>

    <main class="search-page">
        <div class="container">
            <div class="search-banner">
                <div class="banner-content">
                    <h1>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h1>
                    <p><?php echo $products_count; ?> matching products found</p>
                </div>
            </div>

            <div class="search-layout">
                <aside class="search-sidebar">
                    <div class="breadcrumbs">
                        <a href="<?php echo $base_url; ?>index.php">Home</a>
                        <span class="separator">/</span>
                        <span>Search Results</span>
                    </div>

                    <div class="filter-section">
                        <h3>Filters</h3>

                        <div class="filter-group">
                            <h4>Price Range</h4>
                            <div class="filter-options">
                                <label><input type="checkbox" name="price" value="under-5"> Under $5</label>
                                <label><input type="checkbox" name="price" value="5-10"> $5 - $10</label>
                                <label><input type="checkbox" name="price" value="10-20"> $10 - $20</label>
                                <label><input type="checkbox" name="price" value="over-20"> Over $20</label>
                            </div>
                        </div>

                        <div class="filter-group">
                            <h4>Category</h4>
                            <div class="filter-options">
                                <?php
                                $cat_stmt = $mysqli->prepare("SELECT DISTINCT category FROM products ORDER BY category");
                                $cat_stmt->execute();
                                $categories_result = $cat_stmt->get_result();
                                while ($category = $categories_result->fetch_assoc()) {
                                    if (!empty($category['category'])) {
                                        echo '<label><input type="checkbox" name="category" value="' . htmlspecialchars($category['category']) . '"> ' . htmlspecialchars($category['category']) . '</label>';
                                    }
                                }
                                $cat_stmt->close();
                                ?>
                            </div>
                        </div>

                        <div class="filter-group">
                            <h4>Rating</h4>
                            <div class="filter-options">
                                <label><input type="checkbox" name="rating" value="4-up"> 4 stars & up</label>
                                <label><input type="checkbox" name="rating" value="3-up"> 3 stars & up</label>
                                <label><input type="checkbox" name="rating" value="2-up"> 2 stars & up</label>
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button class="btn btn-primary" id="apply-filters">Apply</button>
                            <button class="btn btn-secondary" id="reset-filters">Reset</button>
                        </div>
                    </div>
                </aside>

                <div class="search-content">
                    <div class="search-header">
                        <div class="results-count">
                            <p>Showing <b><?php echo min($products_count, count($products)); ?></b> of <b><?php echo $products_count; ?></b> products</p>
                        </div>
                        <div class="sort-options">
                            <label for="sort-by">Sort by:</label>
                            <select id="sort-by">
                                <option value="relevance">Relevance</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="rating">Rating: High to Low</option>
                            </select>
                        </div>
                    </div>

                    <?php if ($products_count > 0): ?>
                    <div class="product-grid">
                        <?php foreach ($products as $product): ?>
                        <div class="product-card" onclick="navigateToProduct('<?php echo $product['product_id']; ?>', '<?php echo $product['slug']; ?>')">
                            <div class="product-image">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                <?php if ($product['original_price'] > $product['price']): ?>
                                <div class="product-tag sale">Sale</div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                                <p class="price">
                                    <?php if ($product['original_price'] > $product['price']): ?>
                                    <span class="original-price">$<?php echo number_format($product['original_price'], 2); ?></span>
                                    <?php endif; ?>
                                    $<?php echo number_format($product['price'], 2); ?>
                                </p>
                                <div class="rating">
                                    <?php
                                    $rating = $product['rating'];
                                    $full_stars = floor($rating);
                                    $half_star = $rating - $full_stars >= 0.5;
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $full_stars) echo '★';
                                        elseif ($half_star && $i == $full_stars + 1) { echo '★'; $half_star = false; }
                                        else echo '☆';
                                    }
                                    echo ' <span class="review-count">(' . $product['reviews_count'] . ')</span>';
                                    ?>
                                </div>
                            </div>
                            <button class="add-to-cart" onclick="event.stopPropagation();addToCart(
                                '<?php echo $product['product_id']; ?>',
                                '<?php echo htmlspecialchars($product['product_name']); ?>',
                                <?php echo $product['price']; ?>,
                                1,
                                <?php echo $product['original_price'] ? $product['original_price'] : 'null'; ?>,
                                '<?php echo $product['image']; ?>'
                            )">Add to Cart</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php else: ?>
                    <div class="no-results">
                        <div class="no-results-icon"><i class="fas fa-search"></i></div>
                        <h2>No matching products found</h2>
                        <p>Sorry, we couldn't find any products for "<?php echo htmlspecialchars($search_query); ?>".</p>
                        <p>Please try different keywords or browse all categories.</p>
                        <div class="no-results-actions">
                            <a href="<?php echo $base_url; ?>index.php" class="btn btn-primary">Back to Home</a>
                            <a href="<?php echo $base_url; ?>categories/category-template.php?category=all" class="btn btn-secondary">Browse All Products</a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($products_count > 20): ?>
                    <div class="pagination">
                        <a href="#" class="active">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#" class="next">Next &raquo;</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../shared/footer.php'; ?>

    <script>
        function addToCart(productId, productName, price, quantity, originalPrice, image) {
            const cartItems = localStorage.getItem("cartItems") ? JSON.parse(localStorage.getItem("cartItems")) : [];
            const existingItemIndex = cartItems.findIndex(item => item.id === productId);
            if (existingItemIndex > -1) {
                cartItems[existingItemIndex].quantity += quantity;
            } else {
                cartItems.push({ product_id: productId, product_name: productName, price: parseFloat(price), original_price: originalPrice ? parseFloat(originalPrice) : null, quantity, image });
            }
            localStorage.setItem("cartItems", JSON.stringify(cartItems));
            document.dispatchEvent(new CustomEvent("cartUpdated"));
            showNotification(`${productName} was added to your cart!`);
        }

        function showNotification(message) {
            let notification = document.querySelector(".cart-notification");
            if (!notification) {
                notification = document.createElement("div");
                notification.className = "cart-notification";
                document.body.appendChild(notification);
            }
            notification.textContent = message;
            setTimeout(() => { notification.style.opacity = "1"; notification.style.transform = "translateY(0)"; }, 10);
            setTimeout(() => {
                notification.style.opacity = "0"; notification.style.transform = "translateY(20px)";
                setTimeout(() => { notification.remove(); }, 300);
            }, 3000);
        }

        function navigateToProduct(productId, slug) {
            window.location.href = "<?php echo $base_url; ?>products/product-detail.php?id=" + productId + "&slug=" + slug;
        }

        document.addEventListener('DOMContentLoaded', function () {
            const sortSelect = document.getElementById('sort-by');
            if (sortSelect) {
                sortSelect.addEventListener('change', function () {
                    const value = this.value;
                    const grid = document.querySelector('.product-grid');
                    const cards = Array.from(document.querySelectorAll('.product-card'));
                    if (!grid || cards.length === 0) return;

                    switch (value) {
                        case 'price-low':
                            cards.sort((a, b) => parseFloat(a.querySelector('.price').innerText.replace('$', '')) - parseFloat(b.querySelector('.price').innerText.replace('$', '')));
                            break;
                        case 'price-high':
                            cards.sort((a, b) => parseFloat(b.querySelector('.price').innerText.replace('$', '')) - parseFloat(a.querySelector('.price').innerText.replace('$', '')));
                            break;
                        case 'rating':
                            cards.sort((a, b) => b.querySelector('.rating').innerText.split('(')[0].trim().length - a.querySelector('.rating').innerText.split('(')[0].trim().length);
                            break;
                    }

                    grid.innerHTML = '';
                    cards.forEach(card => grid.appendChild(card));
                });
            }

            const applyFilterBtn = document.getElementById('apply-filters');
            const resetFilterBtn = document.getElementById('reset-filters');

            if (applyFilterBtn) {
                applyFilterBtn.addEventListener('click', function () {
                    const selectedPrices = Array.from(document.querySelectorAll('input[name="price"]:checked')).map(el => el.value);
                    const selectedRatings = Array.from(document.querySelectorAll('input[name="rating"]:checked')).map(el => el.value);
                    const cards = document.querySelectorAll('.product-card');

                    cards.forEach(card => {
                        let show = true;
                        const price = parseFloat(card.querySelector('.price').innerText.replace('$', ''));
                        const rating = card.querySelector('.rating').innerText.split('(')[0].trim().length;

                        if (selectedPrices.length) {
                            show = selectedPrices.some(range => {
                                if (range === 'under-5') return price < 5;
                                if (range === '5-10') return price >= 5 && price <= 10;
                                if (range === '10-20') return price > 10 && price <= 20;
                                if (range === 'over-20') return price > 20;
                            });
                        }

                        if (selectedRatings.length && show) {
                            show = selectedRatings.some(range => {
                                if (range === '4-up') return rating >= 4;
                                if (range === '3-up') return rating >= 3;
                                if (range === '2-up') return rating >= 2;
                            });
                        }

                        card.style.display = show ? 'flex' : 'none';
                    });

                    const count = document.querySelectorAll('.product-card[style="display: flex;"]').length;
                    const resultEl = document.querySelector('.results-count p b:first-child');
                    if (resultEl) resultEl.textContent = count;
                });
            }

            if (resetFilterBtn) {
                resetFilterBtn.addEventListener('click', () => {
                    document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                    document.querySelectorAll('.product-card').forEach(card => card.style.display = 'flex');
                    const count = document.querySelectorAll('.product-card').length;
                    const resultEl = document.querySelector('.results-count p b:first-child');
                    if (resultEl) resultEl.textContent = count;
                });
            }
        });
    </script>
</body>
</html>

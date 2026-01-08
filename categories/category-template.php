<?php
// 包含配置文件
include_once __DIR__ . '/../config.php';

// 获取类别参数
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// 根据类别设置页面标题和描述
$category_info = [
    'fresh' => [
        'title' => 'Fresh Food',
        'description' => 'Browse our selection of fresh, high-quality food products',
        'banner_image' => '../assets/images/categories/fresh-banner.jpg',
    ],
    'frozen' => [
        'title' => 'Frozen Food',
        'description' => 'Discover our range of frozen foods for your convenience',
        'banner_image' => '../assets/images/categories/frozen-banner.jpg',
    ],
    'beverages' => [
        'title' => 'Beverages',
        'description' => 'Quench your thirst with our selection of beverages',
        'banner_image' => '../assets/images/categories/beverages-banner.jpg',
    ],
    'home' => [
        'title' => 'Home Products',
        'description' => 'Everything you need for your home',
        'banner_image' => '../assets/images/categories/home-banner.jpg',
    ],
    'pet-food' => [
        'title' => 'Pet Food',
        'description' => 'Quality food for your beloved pets',
        'banner_image' => '../assets/images/categories/pet-food-banner.jpg',
    ],
    'meat-seafood' => [
        'title' => 'Meat & Seafood',
        'description' => 'Premium quality meat and seafood products',
        'banner_image' => '../assets/images/categories/meat-banner.jpg',
    ],
    'fruits-vegetables' => [
        'title' => 'Fruits & Vegetables',
        'description' => 'Fresh fruits and vegetables for a healthy lifestyle',
        'banner_image' => '../assets/images/categories/fruits-banner.jpg',
    ],
    'dairy-eggs' => [
        'title' => 'Dairy & Eggs',
        'description' => 'Fresh dairy products and eggs',
        'banner_image' => '../assets/images/categories/dairy-banner.jpg',
    ],
    'bakery' => [
        'title' => 'Bakery',
        'description' => 'Freshly baked goods and pastries',
        'banner_image' => '../assets/images/categories/bakery-banner.jpg',
    ],
    'all' => [
        'title' => 'All Products',
        'description' => 'Browse our complete selection of products',
        'banner_image' => '../assets/images/categories/all-banner.jpg',
    ]
];

// 如果类别不存在，使用默认值
if (!isset($category_info[$category])) {
    $category = 'all';
}

// 获取当前类别信息
$current_category = $category_info[$category];

// 设置页面特定变量
$page_title = $current_category['title'] . ' - ' . $site_title;

// 获取产品数据
$products = [];
$products_count = 0;

// 准备SQL查询
if ($category === 'all') {
    // 如果是"all"类别，获取所有产品
    $stmt = $mysqli->prepare("SELECT p.* FROM products p ORDER BY p.rating DESC");
} else {
    // 否则，根据标签名称筛选产品
    // 首先，将类别名称转换为可能的标签名称（例如，将"fruits-vegetables"转换为"fruits"或"vegetables"）
    $possible_tags = [];
    
    // 处理复合类别名称（如"fruits-vegetables"）
    if (strpos($category, '-') !== false) {
        $parts = explode('-', $category);
        foreach ($parts as $part) {
            $possible_tags[] = $part;
        }
    } else {
        $possible_tags[] = $category;
    }
    
    // 构建查询条件
    $placeholders = str_repeat('?,', count($possible_tags) - 1) . '?';
    
    // 查询与标签匹配的产品
    $query = "SELECT DISTINCT p.* FROM products p 
              JOIN product_tags pt ON p.product_id = pt.product_id 
              JOIN tags t ON pt.tag_id = t.tag_id 
              WHERE t.tag_name IN ($placeholders) 
              ORDER BY p.rating DESC";
    
    $stmt = $mysqli->prepare($query);
    
    if ($stmt) {
        // 绑定参数
        $types = str_repeat('s', count($possible_tags));
        $stmt->bind_param($types, ...$possible_tags);
    } else {
        die("Prepare failed: " . $mysqli->error);
    }
}

// 执行查询
$stmt->execute();
$result = $stmt->get_result();
$products_count = $result->num_rows;
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// 如果没有找到产品，尝试使用category字段查询
if ($products_count === 0 && $category !== 'all') {
    $stmt = $mysqli->prepare("SELECT * FROM products WHERE category = ? ORDER BY rating DESC");
    if ($stmt) {
        $stmt->bind_param("s", $current_category['title']);
        $stmt->execute();
        $result = $stmt->get_result();
        $products_count = $result->num_rows;
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}

// 获取所有可用的标签，用于筛选
$tags_stmt = $mysqli->prepare("SELECT * FROM tags ORDER BY tag_name");
$tags_stmt->execute();
$tags_result = $tags_stmt->get_result();
$all_tags = $tags_result->fetch_all(MYSQLI_ASSOC);
$tags_stmt->close();
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
  <link rel="stylesheet" href="<?php echo $base_url; ?>categories/category-template.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
  <!-- Header -->
  <?php include __DIR__ . '/../shared/header.php'; ?>

  <main class="category-page">
      <!-- Category Banner -->
      <div class="category-banner" style="background-image: url('<?php echo $current_category['banner_image']; ?>')">
          <div class="banner-content">
              <h1><?php echo $current_category['title']; ?></h1>
              <p><?php echo $current_category['description']; ?></p>
          </div>
      </div>
      
      <div class="container">
          <div class="category-layout">
              <!-- Sidebar Filters -->
              <aside class="category-sidebar">
                  <!-- Breadcrumbs -->
                  <div class="breadcrumbs">
                      <a href="<?php echo $base_url; ?>index.php">Home</a> &gt; <span><?php echo $current_category['title']; ?></span>
                  </div>
                  
                  <div class="filter-section">
                      <h3>Filter By</h3>
                      
                      <div class="filter-group">
                          <h4>Price Range</h4>
                          <div class="filter-options">
                              <label class="filter-option">
                                  <input type="checkbox" name="price" value="under-5">
                                  <span>Under $5</span>
                              </label>
                              <label class="filter-option">
                                  <input type="checkbox" name="price" value="5-10">
                                  <span>$5 - $10</span>
                              </label>
                              <label class="filter-option">
                                  <input type="checkbox" name="price" value="10-20">
                                  <span>$10 - $20</span>
                              </label>
                              <label class="filter-option">
                                  <input type="checkbox" name="price" value="over-20">
                                  <span>Over $20</span>
                              </label>
                          </div>
                      </div>
                      
                      <div class="filter-group">
                          <h4>Tags</h4>
                          <div class="filter-options">
                              <?php foreach ($all_tags as $tag): ?>
                              <label class="filter-option">
                                  <input type="checkbox" name="tag" value="<?php echo htmlspecialchars($tag['tag_name']); ?>">
                                  <span><?php echo htmlspecialchars(ucfirst($tag['tag_name'])); ?></span>
                              </label>
                              <?php endforeach; ?>
                          </div>
                      </div>
                      
                      <div class="filter-group">
                          <h4>Rating</h4>
                          <div class="filter-options">
                              <label class="filter-option">
                                  <input type="checkbox" name="rating" value="4-up">
                                  <span>4★ & Up</span>
                              </label>
                              <label class="filter-option">
                                  <input type="checkbox" name="rating" value="3-up">
                                  <span>3★ & Up</span>
                              </label>
                              <label class="filter-option">
                                  <input type="checkbox" name="rating" value="2-up">
                                  <span>2★ & Up</span>
                              </label>
                          </div>
                      </div>
                      
                      <div class="filter-actions">
                          <button class="btn btn-primary" id="apply-filters">Apply Filters</button>
                          <button class="btn btn-secondary" id="reset-filters">Reset</button>
                      </div>
                  </div>
              </aside>
              
              <!-- Product Grid -->
              <div class="category-content">
                  <div class="category-header">
                      <div class="results-count">
                          <p>Showing <b id="visible-count"><?php echo min($products_count, count($products)); ?></b> of <b><?php echo $products_count; ?></b> products</p>
                      </div>
                      
                      <div class="sort-options">
                          <label for="sort-by">Sort by:</label>
                          <select id="sort-by" name="sort-by">
                              <option value="relevance">Relevance</option>
                              <option value="price-low">Price: Low to High</option>
                              <option value="price-high">Price: High to Low</option>
                              <option value="rating">Rating: High to Low</option>
                          </select>
                      </div>
                  </div>
                  
                  <?php if ($products_count > 0): ?>
                  <div class="product-grid" id="product-grid">
                      <?php foreach ($products as $product): ?>
                      <!-- Product Card -->
                      <div class="product-card" data-price="<?php echo $product['price']; ?>" data-rating="<?php echo $product['rating']; ?>" onclick="navigateToProduct('<?php echo $product['product_id']; ?>', '<?php echo $product['slug']; ?>')">
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
                                      if ($i <= $full_stars) {
                                          echo '★';
                                      } elseif ($half_star && $i == $full_stars + 1) {
                                          echo '★';
                                          $half_star = false;
                                      } else {
                                          echo '☆';
                                      }
                                  }
                                  echo ' <span class="review-count">(' . $product['reviews_count'] . ')</span>';
                                  ?>
                              </div>
                          </div>
                          <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(
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
                      <div class="no-results-icon">
                          <i class="fas fa-search"></i>
                      </div>
                      <h2>No products found</h2>
                      <p>Sorry, we couldn't find any products in this category.</p>
                      <p>Please try another category or browse our other products.</p>
                      <div class="no-results-actions">
                          <a href="<?php echo $base_url; ?>index.php" class="btn btn-primary">Return to Home</a>
                          <a href="<?php echo $base_url; ?>categories/category-template.php?category=all" class="btn btn-secondary">Browse All Products</a>
                      </div>
                  </div>
                  <?php endif; ?>
                  
                  <?php if ($products_count > 24): ?>
                  <!-- Pagination -->
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

  <!-- Footer -->
  <?php include __DIR__ . '/../shared/footer.php'; ?>

  <script>
      // 添加到购物车功能
      function addToCart(productId, productName, price, quantity, originalPrice, image) {
          // 获取现有购物车数据
          const cartItems = localStorage.getItem("cartItems") ? JSON.parse(localStorage.getItem("cartItems")) : [];

          // 检查产品是否已在购物车中
          const existingItemIndex = cartItems.findIndex((item) => item.id === productId);

          if (existingItemIndex > -1) {
              // 更新数量
              cartItems[existingItemIndex].quantity += quantity;
          } else {
              // 添加新商品
              cartItems.push({
                  product_id: productId,
                  product_name: productName,
                  price: Number.parseFloat(price),
                  original_price: originalPrice ? Number.parseFloat(originalPrice) : null,
                  quantity: quantity,
                  image: image,
              });
          }

          // 保存到localStorage
          localStorage.setItem("cartItems", JSON.stringify(cartItems));

          // 触发自定义事件，通知header更新购物车
          document.dispatchEvent(new CustomEvent("cartUpdated"));

          // 显示添加成功消息
          showNotification(`${productName} added to cart!`);
      }

      // 显示通知
      function showNotification(message) {
          // 检查是否已存在通知元素
          let notification = document.querySelector(".cart-notification");

          // 如果不存在，创建一个
          if (!notification) {
              notification = document.createElement("div");
              notification.className = "cart-notification";
              document.body.appendChild(notification);
          }

          // 设置消息内容
          notification.textContent = message;

          // 显示通知
          setTimeout(() => {
              notification.style.opacity = "1";
              notification.style.transform = "translateY(0)";
          }, 10);

          // 3秒后隐藏通知
          setTimeout(() => {
              notification.style.opacity = "0";
              notification.style.transform = "translateY(20px)";

              // 动画完成后移除元素
              setTimeout(() => {
                  if (notification.parentNode) {
                      notification.parentNode.removeChild(notification);
                  }
              }, 300);
          }, 3000);
      }

      // 导航到产品详情页
      function navigateToProduct(productId, slug) {
          window.location.href = "<?php echo $base_url; ?>products/product-detail.php?id=" + productId + "&slug=" + slug;
      }

      // 排序和筛选功能
      document.addEventListener('DOMContentLoaded', function() {
          // 排序功能
          const sortSelect = document.getElementById('sort-by');
          if (sortSelect) {
              sortSelect.addEventListener('change', function() {
                  const sortValue = this.value;
                  const productCards = document.querySelectorAll('.product-card');
                  const productGrid = document.getElementById('product-grid');
                  
                  if (!productGrid || productCards.length === 0) return;
                  
                  // 转换为数组以便排序
                  const productsArray = Array.from(productCards);
                  
                  // 根据选择的排序方式进行排序
                  switch(sortValue) {
                      case 'price-low':
                          productsArray.sort((a, b) => {
                              const priceA = parseFloat(a.getAttribute('data-price'));
                              const priceB = parseFloat(b.getAttribute('data-price'));
                              return priceA - priceB;
                          });
                          break;
                      case 'price-high':
                          productsArray.sort((a, b) => {
                              const priceA = parseFloat(a.getAttribute('data-price'));
                              const priceB = parseFloat(b.getAttribute('data-price'));
                              return priceB - priceA;
                          });
                          break;
                      case 'rating':
                          productsArray.sort((a, b) => {
                              const ratingA = parseFloat(a.getAttribute('data-rating'));
                              const ratingB = parseFloat(b.getAttribute('data-rating'));
                              return ratingB - ratingA;
                          });
                          break;
                      default:
                          // 默认按相关性排序，不做任何改变
                          break;
                  }
                  
                  // 清空产品网格
                  productGrid.innerHTML = '';
                  
                  // 重新添加排序后的产品卡片
                  productsArray.forEach(product => {
                      productGrid.appendChild(product);
                  });
                  
                  // 更新显示的产品数量
                  updateVisibleCount();
              });
          }
          
          // 筛选功能
          const applyFilterBtn = document.getElementById('apply-filters');
          const resetFilterBtn = document.getElementById('reset-filters');
          
          if (applyFilterBtn) {
              applyFilterBtn.addEventListener('click', function() {
                  // 获取所有选中的筛选条件
                  const selectedPrices = Array.from(document.querySelectorAll('input[name="price"]:checked')).map(el => el.value);
                  const selectedTags = Array.from(document.querySelectorAll('input[name="tag"]:checked')).map(el => el.value);
                  const selectedRatings = Array.from(document.querySelectorAll('input[name="rating"]:checked')).map(el => el.value);
                  
                  // 获取所有产品卡片
                  const productCards = document.querySelectorAll('.product-card');
                  
                  productCards.forEach(card => {
                      let showCard = true;
                      
                      // 价格筛选
                      if (selectedPrices.length > 0) {
                          const price = parseFloat(card.getAttribute('data-price'));
                          const matchesPrice = selectedPrices.some(range => {
                              if (range === 'under-5') return price < 5;
                              if (range === '5-10') return price >= 5 && price <= 10;
                              if (range === '10-20') return price > 10 && price <= 20;
                              if (range === 'over-20') return price > 20;
                              return false;
                          });
                          
                          if (!matchesPrice) showCard = false;
                      }
                      
                      // 标签筛选 - 这里需要在卡片中添加标签信息
                      // 由于卡片中可能没有直接显示标签，这部分可能需要调整
                      
                      // 评分筛选
                      if (selectedRatings.length > 0 && showCard) {
                          const rating = parseFloat(card.getAttribute('data-rating'));
                          const matchesRating = selectedRatings.some(range => {
                              if (range === '4-up') return rating >= 4;
                              if (range === '3-up') return rating >= 3;
                              if (range === '2-up') return rating >= 2;
                              return false;
                          });
                          
                          if (!matchesRating) showCard = false;
                      }
                      
                      // 显示或隐藏卡片
                      card.style.display = showCard ? 'flex' : 'none';
                  });
                  
                  // 更新显示的产品数量
                  updateVisibleCount();
              });
          }
          
          if (resetFilterBtn) {
              resetFilterBtn.addEventListener('click', function() {
                  // 重置所有复选框
                  document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                      checkbox.checked = false;
                  });
                  
                  // 显示所有产品卡片
                  document.querySelectorAll('.product-card').forEach(card => {
                      card.style.display = 'flex';
                  });
                  
                  // 更新显示的产品数量
                  updateVisibleCount();
              });
          }
          
          // 更新显示的产品数量
          function updateVisibleCount() {
              const visibleCount = document.querySelectorAll('.product-card[style="display: flex;"]').length;
              const visibleCountEl = document.getElementById('visible-count');
              if (visibleCountEl) {
                  visibleCountEl.textContent = visibleCount;
              }
          }
      });
  </script>
</body>
</html>

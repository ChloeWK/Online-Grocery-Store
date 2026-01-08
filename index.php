<?php
include_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = 'Home - ' . $site_title;
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
    <link rel="stylesheet" href="<?php echo $base_url; ?>styles/home.css">
    <!-- Add Font Awesome Icon Library -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">-->
</head>
<body>
    <!-- Header -->
    <?php include __DIR__ . '/shared/header.php'; ?>

    <!-- Main Content -->
    <main class="home-page">
        
        <!-- Hero Banner -->
        <section class="hero-banner">
            <!-- Slide 1 -->
            <div class="hero-slide active" style="background-image: url('<?php echo $base_url; ?>assets/images/hero/slide1.jpg');">
                <div class="banner-content">
                    <h1>Fresh Groceries Delivered to Your Door</h1>
                    <p>Quality products at affordable prices</p>
                    <a href="<?php echo $base_url; ?>categories/category-template.php?category=fresh" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="hero-slide" style="background-image: url('<?php echo $base_url; ?>assets/images/hero/slide2.png');">
                <div class="banner-content">
                    <h1>Organic Produce Selection</h1>
                    <p>Healthy choices for you and your family</p>
                    <a href="<?php echo $base_url; ?>categories/category-template.php?category=fresh" class="btn btn-primary">Explore Organic</a>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="hero-slide" style="background-image: url('<?php echo $base_url; ?>assets/images/hero/slide3.jpg');">
                <div class="banner-content">
                    <h1>Weekly Special Offers</h1>
                    <p>Save up to 50% on selected items</p>
                    <a href="<?php echo $base_url; ?>discount/promotions.php" class="btn btn-primary">View Deals</a>
                </div>
            </div>
            
            <!-- Slider Controls -->
            <div class="slider-controls">
                <button class="slider-prev">
                    <img src="<?php echo $base_url; ?>assets/icons/chevron-left.svg" alt="Previous">
                </button>
                <div class="slider-dot active" data-slide="0"></div>
                <div class="slider-dot" data-slide="1"></div>
                <div class="slider-dot" data-slide="2"></div>
                <button class="slider-next">
                    <img src="<?php echo $base_url; ?>assets/icons/chevron-right.svg" alt="Next">
                </button>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="categories-section">
            <div class="categories-container">
                
                <div class="scroll-controls">
                    <div class="categories-scroll">
                        <!-- Category 1 -->
                        <a href="<?php echo $base_url; ?>categories/category-template.php?category=fresh" class="category-item">
                            <div class="category-icon">
                                <img src="<?php echo $base_url; ?>assets/images/categories/fresh-icon.png" alt="Fresh">
                            </div>
                            <span class="category-name">Fresh</span>
                        </a>
                        
                        <!-- Category 2 -->
                        <a href="<?php echo $base_url; ?>categories/category-template.php?category=frozen" class="category-item">
                            <div class="category-icon">
                                <img src="<?php echo $base_url; ?>assets/images/categories/frozen-icon.png" alt="Frozen">
                            </div>
                            <span class="category-name">Frozen</span>
                        </a>
                        
                        <!-- Category 3 -->
                        <a href="<?php echo $base_url; ?>categories/category-template.php?category=beverages" class="category-item">
                            <div class="category-icon">
                                <img src="<?php echo $base_url; ?>assets/images/categories/beverages-icon.png" alt="Beverages">
                            </div>
                            <span class="category-name">Beverages</span>
                        </a>
                        
                        <!-- Category 4 -->
                        <a href="<?php echo $base_url; ?>categories/category-template.php?category=home" class="category-item">
                            <div class="category-icon">
                                <img src="<?php echo $base_url; ?>assets/images/categories/home-icon.png" alt="Home">
                            </div>
                            <span class="category-name">Home</span>
                        </a>
                        
                        <!-- Category 5 -->
                        <a href="<?php echo $base_url; ?>categories/category-template.php?category=pet-food" class="category-item">
                            <div class="category-icon">
                                <img src="<?php echo $base_url; ?>assets/images/categories/pet-food-icon.png" alt="Pet Food">
                            </div>
                            <span class="category-name">Pet Food</span>
                        </a>
                        
                        <!-- Category 6 -->
                        <a href="<?php echo $base_url; ?>categories/category-template.php?category=meat-seafood" class="category-item">
                            <div class="category-icon">
                                <img src="<?php echo $base_url; ?>assets/images/categories/meat-icon.png" alt="Meat & Seafood">
                            </div>
                            <span class="category-name">Meat & Seafood</span>
                        </a>
                        
                        <!-- Category 7 -->
                        <a href="<?php echo $base_url; ?>categories/category-template.php?category=fruits-vegetables" class="category-item">
                            <div class="category-icon">
                                <img src="<?php echo $base_url; ?>assets/images/categories/fruits-icon.png" alt="Fruits & Vegetables">
                            </div>
                            <span class="category-name">Fruits & Vegetables</span>
                        </a>
                        
                        <!-- Category 8 -->
                        <a href="<?php echo $base_url; ?>categories/category-template.php?category=dairy-eggs" class="category-item">
                            <div class="category-icon">
                                <img src="<?php echo $base_url; ?>assets/images/categories/dairy-icon.png" alt="Dairy, Eggs & Fridge">
                            </div>
                            <span class="category-name">Dairy & Eggs</span>
                        </a>
                        
                        <!-- Category 9 -->
                        <a href="<?php echo $base_url; ?>categories/category-template.php?category=bakery" class="category-item">
                            <div class="category-icon">
                                <img src="<?php echo $base_url; ?>assets/images/categories/bakery-icon.png" alt="Bakery">
                            </div>
                            <span class="category-name">Bakery</span>
                        </a>
                    </div>
                    
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="featured-products">
            <div class="featured-container">
                <div class="featured-header">
                    <h2 class="featured-title">Featured Products Recommendation</h2>
                    <a href="<?php echo $base_url; ?>categories/category-template.php" class="view-all">
                        View all
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                </div>
                
                <div class="product-slider">
                    <div class="product-row" id="featured-products-row">
                        <!-- Recommendation Card -->
                        <div class="recom-card">
                            <div class="recom-content">
                                <span class="premium-tag">Premium</span>
                                <h3 class="recom-title">You deserve a better life</h3>
                                <p class="recom-subtitle">Making high quality life for you.</p>
                            </div>
                            <a href="<?php echo $base_url; ?>categories/category-template.php" class="shop-all-btn">Shop all</a>
                        </div>
                        
                        <!-- Product Card 1 -->
                        <div class="product-card" onclick="navigateToProduct('151', 'bondi-sands-sunscreen')">
                            <div class="premium-banner">Premium Quality</div>
                            <div class="quality-badge">Organic</div>
                            <div class="product-image">
                                <img src="<?php echo $base_url; ?>assets/images/products/sunscreen.jpg" alt="Bondi Sands Wet Skin Sport Sunscreen">
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">Bondi Sands Wet Skin Sport Sunscreen SPF50</h3>
                                <p class="product-details">125mL</p>
                                
                                <div class="price-container">
                                    <div>
                                        <span class="current-price">$9.00</span>
                                        <span class="premium-tag">Premium</span>
                                    </div>
                                    <div class="unit-price">$7.20 per 100ml</div>
                                    
                                    <div class="rating">
                                        ★★★★★ <span class="rating-score">4.8 (126)</span>
                                    </div>
                                    
                                    <div class="product-actions">
                                        <button class="wishlist-btn" onclick="event.stopPropagation()">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                                </svg>
                                        <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(
                                            '151',
                                            'Bondi Sands Wet Skin Sport Sunscreen SPF50',
                                            9.00,
                                            1,
                                            null,
                                            '<?php echo $base_url; ?>assets/images/products/sunscreen.jpg')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                            </svg>
                                            Add
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Card 2 -->
                        <div class="product-card" onclick="navigateToProduct('152','tim-tam-chocolate-biscuits')">
                            <div class="premium-banner">Premium Quality</div>
                            <div class="quality-badge">Artisan</div>
                            <div class="product-image">
                                <img src="<?php echo $base_url; ?>assets/images/products/tim-tam.jpg" alt="Arnotts Tim Tam Chocolate Biscuits">
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">Arnotts Tim Tam Chocolate Biscuits Original</h3>
                                <p class="product-details">200g</p>
                                
                                <div class="price-container">
                                    <div>
                                        <span class="current-price">$3.00</span>
                                        <span class="premium-tag">Premium</span>
                                    </div>
                                    <div class="unit-price">$1.50 per 100g</div>
                                    
                                    <div class="rating">
                                        ★★★★★ <span class="rating-score">4.9 (352)</span>
                                    </div>
                                    
                                    <div class="product-actions">
                                        <button class="wishlist-btn" onclick="event.stopPropagation()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                            </svg>
                                        <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(
                                            '152', 
                                            'Tim Tam Chocolate Biscuits', 
                                            3.00, 
                                            1,
                                            null,
                                            '<?php echo $base_url; ?>assets/images/products/tim-tam.jpg')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                            </svg>
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Card 3 -->
                        <div class="product-card" onclick="navigateToProduct('153','nescafe-cappuccino-coffee')">
                            <div class="premium-banner">Premium Quality</div>
                            <div class="quality-badge">Imported</div>
                            <div class="product-image">
                                <img src="<?php echo $base_url; ?>assets/images/products/nescafe.jpg" alt="Nescafe Cappuccino Coffee Sachets">
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">Nescafe Cappuccino Coffee Sachets</h3>
                                <p class="product-details">10 pack</p>
                                
                                <div class="price-container">
                                    <div>
                                        <span class="current-price">$4.00</span>
                                        <span class="premium-tag">Premium</span>
                                    </div>
                                    <div class="unit-price">$0.40 per sachet</div>
                                    
                                    <div class="rating">
                                        ★★★★☆ <span class="rating-score">4.5 (414)</span>
                                    </div>
                                    
                                    <div class="product-actions">
                                        <button class="wishlist-btn" onclick="event.stopPropagation()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                            </svg>
                                        <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(
                                            '153', 
                                            'Nescafe Cappuccino Coffee Sachets', 
                                            4.00, 
                                            1,
                                            null,
                                            '<?php echo $base_url; ?>assets/images/products/nescafe.jpg')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                            </svg>
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Card 4 -->
                        <div class="product-card" onclick="navigateToProduct('154','kelloggs-nutri-grain-cereal')">
                            <div class="premium-banner">Premium Quality</div>
                            <div class="quality-badge">High Protein</div>
                            <div class="product-image">
                                <img src="<?php echo $base_url; ?>assets/images/products/nutri-grain.png" alt="Kellogg's Nutri-Grain Protein Breakfast Cereal">
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">Kellogg's Nutri-Grain Protein Breakfast Cereal</h3>
                                <p class="product-details">470g</p>
                                
                                <div class="price-container">
                                    <div>
                                        <span class="current-price">$4.50</span>
                                        <span class="premium-tag">Premium</span>
                                    </div>
                                    <div class="unit-price">$0.96 per 100g</div>
                                    
                                    <div class="rating">
                                        ★★★★★ <span class="rating-score">4.7 (289)</span>
                                    </div>
                                    
                                    <div class="product-actions">
                                        <button class="wishlist-btn" onclick="event.stopPropagation()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                            </svg>
                                        <button class="add-to-cart" onclick="event.stopPropagation(); addToCart(
                                            '154', 
                                            'Kelloggs Nutri-Grain Cereal', 
                                            4.50, 
                                            1,
                                            null,
                                            '<?php echo $base_url; ?>assets/images/products/nutri-grain.png')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                            </svg>
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Add more product cards to ensure the scrolling effect -->
                        <div class="product-card" onclick="navigateToProduct('gluten-free-cereal')">
                            <div class="premium-banner">Premium Quality</div>
                            <div class="quality-badge">Gluten Free</div>
                            <div class="product-image">
                                <img src="<?php echo $base_url; ?>assets/images/products/cereal.jpg" alt="Premium Gluten Free Cereal">
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">Premium Gluten Free Breakfast Cereal</h3>
                                <p class="product-details">400g</p>
                                
                                <div class="price-container">
                                    <div>
                                        <span class="current-price">$5.50</span>
                                        <span class="premium-tag">Premium</span>
                                    </div>
                                    <div class="unit-price">$1.38 per 100g</div>
                                    
                                    <div class="rating">
                                        ★★★★★ <span class="rating-score">4.6 (178)</span>
                                    </div>
                                    
                                    <div class="product-actions">
                                        <button class="wishlist-btn" onclick="event.stopPropagation()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                            </svg>
                                        </button>
                                        <button class="add-to-cart" onclick="event.stopPropagation(); addToCart('p005', 'Gluten Free Cereal', 5.50, 1)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 2 1.61h9.72a2 2 0 0 2-1.61L23 6H6"></path>
                                            </svg>
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Scroll control - Add left and right arrows -->
                    <button class="slider-arrow slider-prev" id="featured-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <button class="slider-arrow slider-next" id="featured-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <!-- Special Offers Banner -->
        <section class="offers-banner">
            <div class="offers-slider">
                <!-- Slide 1 -->
                <div class="offers-slide active" style="background-image: url('assets/images/banner1.jpg'); background-size: cover; background-position: center;">
                    <div class="offers-content">
                        <h2>Special Offers</h2>
                        <p>Save up to 50% on selected items this week</p>
                        <a href="<?php echo $base_url; ?>discount/promotions.php" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="offers-slide active" style="background-image: url('assets/images/banner2.jpg'); background-size: cover; background-position: center;">
                    <div class="offers-content">
                        <h2>Summer Deals</h2>
                        <p>Refresh your summer with cool discounts</p>
                        <a href="<?php echo $base_url; ?>discount/promotions.php" class="btn btn-primary">Explore</a>
                    </div>
                </div>
                
                <!-- Slide 3 -->
                <div class="offers-slide active" style="background-image: url('assets/images/banner3.jpg'); background-size: cover; background-position: center;">
                    <div class="offers-content">
                        <h2>New Customer Offer</h2>
                        <p>Get 10% off your first order with code: WELCOME10</p>
                        <a href="<?php echo $base_url; ?>account/register.php" class="btn btn-primary">Sign Up Now</a>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Dots -->
            <div class="offers-dots">
                <span class="offer-dot active" data-slide="0"></span>
                <span class="offer-dot" data-slide="1"></span>
                <span class="offer-dot" data-slide="2"></span>
            </div>
        </section>

        <!-- New Arrivals Section -->
        <section class="new-arrivals-section">
            <div class="new-arrivals-header">
                <h2 class="new-arrivals-title">New Arrivals</h2>
                <a href="<?php echo $base_url; ?>search/search-result.php?query=organic" class="view-all-new">
                    View All New Arrivals
                </a>
            </div>
            
            <div class="new-products-container">
                <div class="new-products-grid">
                    <!-- Product 1 -->
                    <div class="new-product-card" onclick="navigateToProduct('155','organic-milk')">
                        <span class="new-tag">New</span>
                        <div class="new-product-image">
                            <img src="<?php echo $base_url; ?>assets/images/products/organic-milk.png" alt="Organic Milk">
                        </div>
                        <div class="new-product-info">
                            <h3 class="new-product-name">Organic Milk</h3>
                            <div class="new-product-price">$4.49</div>
                            <div class="new-product-rating">★★★★★</div>
                            <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(
                                '155', 'Organic Milk', 4.49, 1, null, '<?php echo $base_url; ?>assets/images/products/organic-milk.png')">Add to Cart</button>
                        </div>
                    </div>
                    
                    <!-- Product 2 -->
                    <div class="new-product-card" onclick="navigateToProduct('156','organic-eggs')">
                        <span class="new-tag">New</span>
                        <div class="new-product-image">
                            <img src="<?php echo $base_url; ?>assets/images/products/organic-eggs.jpg" alt="Organic Eggs">
                        </div>
                        <div class="new-product-info">
                            <h3 class="new-product-name">Organic Eggs</h3>
                            <div class="new-product-price">$5.99</div>
                            <div class="new-product-rating">★★★★☆</div>
                            <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(
                                '156', 'Organic Eggs', 5.99, 1, null, '<?php echo $base_url; ?>assets/images/products/organic-eggs.jpg')">Add to Cart</button>
                        </div>
                    </div>
                    
                    <!-- Product 3 -->
                    <div class="new-product-card" onclick="navigateToProduct('157','organic-spinach')">
                        <span class="new-tag">New</span>
                        <div class="new-product-image">
                            <img src="<?php echo $base_url; ?>assets/images/products/organic-spinach.jpg" alt="Organic Spinach">
                        </div>
                        <div class="new-product-info">
                            <h3 class="new-product-name">Organic Spinach</h3>
                            <div class="new-product-price">$3.29</div>
                            <div class="new-product-rating">★★★★☆</div>
                            <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(
                            '157', 'Organic Spinach', 3.29, 1, null, '<?php echo $base_url; ?>assets/images/products/organic-spinach.jpg')">Add to Cart</button>
                        </div>
                    </div>
                    
                    <!-- Product 4 -->
                    <div class="new-product-card" onclick="navigateToProduct('158','organic-bread')">
                        <span class="new-tag">New</span>
                        <div class="new-product-image">
                            <img src="<?php echo $base_url; ?>assets/images/products/organic-bread.jpg" alt="Organic Bread">
                        </div>
                        <div class="new-product-info">
                            <h3 class="new-product-name">Organic Bread</h3>
                            <div class="new-product-price">$4.29</div>
                            <div class="new-product-rating">★★★★☆</div>
                            <button class="add-to-cart-btn" onclick="event.stopPropagation(); addToCart(
                                '158', 'Organic Bread', 4.29, 1, null, '<?php echo $base_url; ?>assets/images/products/organic-bread.jpg')">Add to Cart</button>
                        </div>
                    </div>
                </div>
                
                <!-- The sliding arrow on the mobile device -->
                <div class="new-arrow new-prev" id="new-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </div>
                <div class="new-arrow new-next" id="new-next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/shared/footer.php'; ?>

    <!-- JavaScript -->
    <script src="<?php echo $base_url; ?>scripts/common.js"></script>
    <script src="<?php echo $base_url; ?>scripts/home.js"></script>
    <script>
    // Check and clear the login status in localStorage
    (function() {
        // Check the PHP session status
        var isLoggedInPHP = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
        
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
    </script>

<script>
// Add debugging code to help troubleshoot the problem of the shopping cart floating window
document.addEventListener('DOMContentLoaded', function() {
    // Check whether the element exists
    const cartIcon = document.getElementById('cart-icon');
    const cartPopup = document.getElementById('cart-popup');
    const closeCartPopup = document.getElementById('close-cart-popup');
    
    if (cartIcon) {
        console.log('Cart icon found:', cartIcon);
    } else {
        console.error('Cart icon not found!');
    }
    
    if (cartPopup) {
        console.log('Cart popup found:', cartPopup);
    } else {
        console.error('Cart popup not found!');
    }
    
    if (closeCartPopup) {
        console.log('Close button found:', closeCartPopup);
    } else {
        console.error('Close button not found!');
    }
    
    // Make sure the close button has the correct event listener
    if (closeCartPopup && cartPopup) {
        closeCartPopup.addEventListener('click', function(e) {
            console.log('Close button clicked');
            e.preventDefault();
            e.stopPropagation();
            cartPopup.classList.remove('active');
        });
    }
    
    // Make sure that clicking on the external area can close the shopping cart pop-up window
    document.addEventListener('click', function(e) {
        if (cartPopup && cartPopup.classList.contains('active')) {
            // Check whether the clicked element is inside the shopping cart pop-up window or the shopping cart icon
            const isClickInsidePopup = cartPopup.contains(e.target);
            const isClickOnCartIcon = cartIcon && (cartIcon === e.target || cartIcon.contains(e.target));
            
            if (!isClickInsidePopup && !isClickOnCartIcon) {
                cartPopup.classList.remove('active');
                console.log('Clicked outside, popup closed');
            }
        }
    });
});

// Add the product navigation function
function navigateToProduct(productId, productSlug) {
    // Jump to the product detail page
    window.location.href = `<?php echo $base_url; ?>products/product-detail.php?id=${productId}&slug=${productSlug}`;
}
</script>
</body>
</html>

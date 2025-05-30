<?php
// Database connection (PDO)
// $dsn = "mysql:host=127.0.0.1;dbname=ecommerce";
// $username = "root";
// $password = "";

// try {
//     $pdo = new PDO($dsn, $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
//     exit;
// }
include "../config.php";
// Get the product ID from the URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the product data from the database using prepared statements
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the product exists
if (!$product) {
    echo "Product not found.";
    exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View - <?= htmlspecialchars($product['name']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    
    <!-- Font Icons -->
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="../images/logo1.png" type="image/x-icon">
    
    <link rel="stylesheet" href="style.css">
</head>

<body>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Store</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../cart/cart.php">
                            <i class="fas fa-shopping-cart"></i> Cart
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Product Section -->
    <section class="product-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                <img src="../images/<?=htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid product-image">
                </div>
                <div class="col-md-6">
                    <h1 class="product-title"><?=htmlspecialchars($product['name']) ?></h1>
                    <p class="product-description"><?=nl2br(htmlspecialchars($product['description'])) ?></p>
                    <p class="product-price">$<?=number_format($product['price'], 2) ?></p>

                    <div class="quantity-selector">
                        <button class="quantity-btn js-btn-minus" type="button">-</button>
                        <input type="text" class="quantity-input" value="1" id="product-quantity">
                        <button class="quantity-btn js-btn-plus" type="button">+</button>
                    </div>

                    <form method="post" action="../cart/cart.php">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                        <input type="hidden" name="product_price" value="<?= htmlspecialchars($product['price']) ?>">
                        <input type="hidden" name="product_image" value="<?= htmlspecialchars($product['image']) ?>">
                        <input type="hidden" name="product_quantity" id="hidden-quantity" value="1">
                        <button type="submit" name="add_to_cart" class="btn add-to-cart-btn">
                            <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h3 class="footer-heading">ShopMax</h3>
                    <p>Your one-stop destination for quality products at competitive prices. We strive to provide an exceptional shopping experience.</p>
                </div>
                <div class="col-md-2 col-sm-4 col-6 mb-4">
                    <h3 class="footer-heading">Company</h3>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Our Services</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-4 col-6 mb-4">
                    <h3 class="footer-heading">Shop</h3>
                    <ul class="footer-links">
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Discounts</a></li>
                        <li><a href="#">Best Sellers</a></li>
                        <li><a href="#">Categories</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-4 col-6 mb-4">
                    <h3 class="footer-heading">Support</h3>
                    <ul class="footer-links">
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Returns Policy</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>

            <ul class="social-icons">
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
            </ul>

            <div class="copyright">
                <p>&copy; 2025 ShopMax. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Go to Top Button -->
    <div class="go-to-top js-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- JavaScript Libraries -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    
    <script src="java.js" ></script>
</body>
</html>
<style>
    .product-image {
    width: 100%;
    max-width: 500px; /* Adjust this value as needed */
    height: auto;
    object-fit: cover; /* Ensures the aspect ratio is maintained while covering the area */
}

</style>
<?php
include ("config.php");
include ("db.php");

// Get category slug from URL
$category_slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Check if the category exists in the database
$category = dbSelect("categories", "*", "slug = '$category_slug'", "");

if (empty($category)) {
    // If category doesn't exist, redirect to home page or show an error message
    echo "Category not found!";
    exit;
}

// Get products for the selected category
$products = dbSelect("products", "*", "category_slug = '$category_slug'", "");

?>

<!DOCTYPE HTML>
<html>
    <?php include ("input/head.php"); ?>
    <body>
        
    <div class="fh5co-loader"></div>
    
    <div id="page">
        <!--header-->    
        <?php include ("input/header.php"); ?>
        <!--end header-->
        
        <!--aside-->
        <?php include ("input/aside.php"); ?>

        <!-- Category Header -->
        <div class="category-header">
            <h1><?php echo $category[0]['name']; ?></h1>
            <p><?php echo $category[0]['description']; ?></p>
        </div>

        <!-- Product List -->
        <div class="product-list">
            <?php if (!empty($products)): ?>
                <ul>
                    <?php foreach ($products as $product): ?>
                        <li>
                            <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                                <img src="images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                                <h3><?php echo $product['name']; ?></h3>
                                <p><?php echo $product['description']; ?></p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No products found for this category.</p>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <?php include ("input/footer.php"); ?>
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
    </div>
    
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- jQuery Easing -->
    <script src="js/jquery.easing.1.3.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Waypoints -->
    <script src="js/jquery.waypoints.min.js"></script>
    <!-- Carousel -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- countTo -->
    <script src="js/jquery.countTo.js"></script>
    <!-- Flexslider -->
    <script src="js/jquery.flexslider-min.js"></script>
    <!-- Main -->
    <script src="js/main.js"></script>

    </body>
</html>

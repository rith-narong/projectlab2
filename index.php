<?php

include ("config.php");
include ("db.php");


$hide = true;
$hide1 = true;

// Check if the 'p' parameter exists in the URL
$p = isset($_GET['p']) ? $_GET['p'] : 'index';

switch ($p) {
    case "about":
        $about1 = "About/aboutheader.php";
        $about2 = "About/histrory.php";
        $hide = false;
        break;
    case "services":
        $service1 = "Service/header.php";
        $service2 = "Service/service.php";
        $hide = false;
        break;
    case "contact":
        $contact1 = "contact/header.php";
        $contact2 = "contact/contact.php";
        $contact3 = "contact/map.php";
        $hide = false;
        break;
    case "product":
        $product1 = "product/header.php";
        $product2 = "product/product.php";
        $hide = false;
        break;
               
        
    default:
        // Check if it's a category (Dynamically check from DB)
        $categories = dbSelect("categories", "*", "", "");
        foreach ($categories as $category) {
            if ($p == $category['name']) {
                $category_file = "category/" . $category['name'] . ".php";
                if (file_exists($category_file)) {
                    $category_page = $category_file;
                    $hide = false;
                    $hide1 = false;
                }
            }
        }
        break;
}
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
        <?php if ($hide) include ("input/aside.php"); ?>

        <?php 
            if ($p == "about") {
                include ("$about1");
            } elseif ($p == "services") {
                include ("$service1");
            } elseif ($p == "contact") {
                include ("$contact1");
            } elseif ($p == "product") {
                include ("$product1");
            } 
        ?>

        <!-- Service Section -->
        <?php if ($hide) include ("input/service.php"); ?>

        <?php 
            if ($p == "about") {
                include ("$about2");
            } elseif ($p == "services") {
                include ("$service2");
            } elseif ($p == "contact") {
                include ("$contact2");
            } elseif ($p == "product") {
                include ("$product2");
					
            }elseif (isset($category_page)) {
                include ($category_page);
            }
             
        ?>

        <!-- Product Section -->
        <?php if ($hide) include ("input/product.php"); ?>
        <?php if (!empty($contact3)) include ("$contact3"); ?>
        
        <!-- Testimony -->
        <?php if ($hide) include ("input/testimony.php"); ?>
        
        <!-- Counter -->
        <?php if ($hide) include ("input/counter.php"); ?>
        
        <!-- Started Section -->
        <?php if ($hide1) include ("input/started.php"); ?>
        
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

<?php

if (!isset($_SESSION)) {
    session_start(); 
}
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; // Get total cart count

// Database connection
$pdo = new PDO("mysql:host=127.0.0.1;dbname=your_db_name;charset=utf8", "your_user", "your_password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch categories from the database
$categories = [];
$logo = []; // Declare the logo variable
try {
    $stmt = $pdo->query("SELECT name FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch the logo from the logo table
    $logoStmt = $pdo->query("SELECT image FROM logo LIMIT 1"); // Assuming there's only one logo
    $logo = $logoStmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
}

$p = isset($_GET['p']) ? $_GET['p'] : 'home';
?>

<nav class="fh5co-nav" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-2">
                <div id="fh5co-logo">
                    <?php if (!empty($logo)) { ?>
                        <a href="index.php"><img src="images/<?= htmlspecialchars($logo['image']) ?>" alt="" width="40px"></a>
                    <?php } else { ?>
                        <a href="index.php"><img src="images/default-logo.png" alt="" width="40px"></a> <!-- Default logo if no logo found -->
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-6 col-xs-6 text-center menu-1">
                <ul>
                    <li class="has-dropdown <?= ($p == 'product' ? 'active' : '') ?>">
                        <a href="index.php?p=product">Shop</a>
                        <ul class="dropdown">
                            <?php if (!empty($categories)) { ?>
                                <?php foreach ($categories as $category) { ?>
                                    <li class="<?= ($p == strtolower(htmlspecialchars($category['name'])) ? 'active' : '') ?>">
                                        <a href="index.php?p=<?= urlencode($category['name']) ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } else { ?>
                                <li><a href="#">No Categories Found</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="<?= ($p == 'about' ? 'active' : '') ?>"><a href="index.php?p=about">About</a></li>
                    <li class="<?= ($p == 'services' ? 'active' : '') ?>"><a href="index.php?p=services">Services</a></li>
                    <li class="<?= ($p == 'contact' ? 'active' : '') ?>"><a href="index.php?p=contact">Contact</a></li>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li>
                            <form method="post" action="login/logoutcustomer.php">
                                <button type="submit" name="logout" class="btn btn-danger" style="background: none; border: none; color: red; cursor: pointer;">Logout</button>
                            </form>
                        </li>
                    <?php } else { ?>
                        <li class="<?= ($p == 'login' ? 'active' : '') ?>"><a href="login/login.php">Login</a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-3 col-xs-4 text-right hidden-xs menu-2">
                <ul>
                    <li class="shopping-cart">
                        <a href="<?= isset($_SESSION['user_id']) ? 'cart/cart.php' : 'login/login.php' ?>" class="cart">
                            <span><i class="icon-shopping-cart"><?= $cart_count ?></i></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
    .active {
        background-color: gray;
        border-radius: 25px;
    }
</style>

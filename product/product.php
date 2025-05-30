<?php
// Get selected category from the URL
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Modify query to filter by category if selected
$condition = !empty($category) ? "category = ?" : "";
$params = !empty($category) ? [$category] : [];

$result = dbSelect("products", "*", $condition, $params);
$num = count($result);
?>

<div id="fh5co-product">
    <div class="container">
        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                <span>Cool Stuff</span>
                <h2>Products.</h2>
                <p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
            </div>
        </div>
        <?php
        foreach ($result as $row) {
        ?>
            <div class="col-md-4 text-center animate-box">
                <div class="product">
                    <div class="product-grid" style="background-image:url('images/<?= htmlspecialchars($row['image']) ?>');">
                        <div class="inner">
                            <p>
                                <a href="/projectlab2/product/single.php?id=<?= htmlspecialchars($row['id']) ?>" class="icon">
                                    <i class="icon-eye"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="desc">
                        <h3><a href="#"><?= htmlspecialchars($row['name']) ?></a></h3>
                        <span class="price">$<?= htmlspecialchars($row['price']) ?></span>
                        <form method="post" action="/projectlab2/cart/cart.php">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['id']) ?>">
                            <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['name']) ?>">
                            <input type="hidden" name="product_price" value="<?= htmlspecialchars($row['price']) ?>">
                            <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['image']) ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

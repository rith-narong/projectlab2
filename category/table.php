<?php
    // Fetch the products using PDO
    $result = dbSelect("products", "*", "", "");

    // Check if the result is not empty
    if (!empty($result)) {
?>

<div id="fh5co-product">
    <div class="container">
        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
                <span>Cool</span>
                <h2>TABLE PRODUCT</h2>
                <p>A table is a piece of furniture with a flat surface supported by legs, designed for various purposes such as working, eating, or holding objects.</p>
            </div>
        </div>
        <div class="row">
            <?php
                // Loop through the result set
                foreach ($result as $row) {
                    // Check if the product belongs to category 1
                    if ($row['category_id'] == 3) {
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
                }
            ?>
        </div>
    </div>
</div>

<?php
    } else {
        echo "<p class='text-center'>No products found.</p>";
    }
?>

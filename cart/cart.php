<?php

include "configcart.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="shortcut icon" href="../images/logo1.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <main class="container mt-5">
        <h2><a href="../index.php?p=product" class="text-decoration-none text-primary">Shop</a> / Cart</h2>
        <div class="row">
            <div class="col-lg-8">
                <?php
                $total_price = 0;
                if (!empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $total_price += $item['product_price'] * $item['quantity'];
                        ?>
                        <div class="product d-flex mb-3">
                            <img src="../images/<?= $item['product_image'] ?>" class="img-fluid me-3" width="100" alt="">
                            <div>
                                <h5><?= $item['product_name'] ?></h5>
                                <p class="price">$<?= number_format($item['product_price'], 2) ?></p>
                                <form method="post">
                                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control mb-2" style="width: 80px;">
                                    <button type="submit" name="update_quantity" class="btn btn-sm btn-custom">Update</button>
                                    <a href="cart.php?remove=<?= $item['product_id'] ?>" class="btn btn-sm btn-danger">Remove</a>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>Your cart is empty.</p>";
                }
                ?>
            </div>
            <div class="col-lg-4">
                <div class="summary">
                    <h3>Summary</h3>
                    <p><strong>Total:</strong> $<?= number_format($total_price, 2) ?></p>
                    <form action="cart.php" method="post">
                        <input type="text" name="address" class="form-control mb-2" placeholder="Address" required>
                        <input type="number" name="number" class="form-control mb-2" placeholder="Phone Number" required>
                        <input type="number" name="mobnumber" class="form-control mb-2" placeholder="Rocket Number">
                        <input type="text" name="txid" class="form-control mb-2" placeholder="Txid">
                        <button type="submit" name="order_btn" class="btn-custom w-100">Order Now</button>
                    </form>
                    <?php if (isset($order_success)) { ?>
                        <div class="alert alert-success alert-custom"><?= $order_success ?></div>
                    <?php } ?>
                    <?php if (isset($order_error)) { ?>
                        <div class="alert alert-danger alert-custom"><?= $order_error ?></div>
                    <?php } ?><!-- PayPal Sandbox Button -->
                    <div class="mt-3">
                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="business" value="sb-iwgca34175755@business.example.com"> <!-- Replace with your sandbox business email -->
                            <input type="hidden" name="lc" value="US">
                            <input type="hidden" name="item_name" value="Cart Purchase">
                            <input type="hidden" name="amount" value="<?= number_format($total_price, 2) ?>">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="button_subtype" value="services">
                            <input type="hidden" name="no_note" value="0">
                            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
                            <button type="submit" class="btn btn-warning w-100">Pay with PayPal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
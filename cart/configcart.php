<?php
// Start session and define constants
session_start();
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.log');

include "../config.php";

// Helper functions for input sanitization and validation
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function validateNumeric($data, $min = 0, $max = PHP_INT_MAX) {
    $data = (int) $data;
    return ($data >= $min && $data <= $max) ? $data : false;
}

// Initialize cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $product_id = validateNumeric($_GET['remove']);
    if ($product_id) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header('Location: cart.php');
    exit();
}

// Add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = validateNumeric($_POST['product_id']);
    $product_name = cleanInput($_POST['product_name']);
    $product_price = (float) cleanInput($_POST['product_price']);
    $product_image = cleanInput($_POST['product_image']);

    if ($product_id && $product_price > 0) {
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_price' => $product_price,
                'product_image' => $product_image,
                'quantity' => 1
            ];
        }
    }
    header('Location: cart.php?success=1');
    exit();
}

// Update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $product_id = validateNumeric($_POST['product_id']);
    $quantity = max(1, validateNumeric($_POST['quantity']));

    if ($product_id && $quantity) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
    }
    header('Location: cart.php');
    exit();
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_btn'])) {
    $address = cleanInput($_POST['address']);
    $number = cleanInput($_POST['number']);
    $mobnumber = cleanInput($_POST['mobnumber']);
    $txid = cleanInput($_POST['txid']);

    if (empty($address) || empty($number)) {
        $order_error = 'Address and phone number are required!';
    } else {
        // Generate a unique order ID using random_bytes
        $order_id = bin2hex(random_bytes(8)); // Generates a 16-character hexadecimal string

        if (!empty($_SESSION['cart'])) {
            try {
                $pdo->beginTransaction();

                $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                                       VALUES (:order_id, :product_id, :quantity, :price)");

                foreach ($_SESSION['cart'] as $item) {
                    $stmt->execute([
                        ':order_id' => $order_id,
                        ':product_id' => $item['product_id'],
                        ':quantity' => $item['quantity'],
                        ':price' => $item['product_price']
                    ]);
                }

                $pdo->commit();
                unset($_SESSION['cart']);
                $order_success = 'Order placed successfully!';
            } catch (PDOException $e) {
                $pdo->rollBack();
                error_log("Order placement failed: " . $e->getMessage());
                $order_error = 'An error occurred while placing the order. Please try again.';
            }
        }
    }
}
?>
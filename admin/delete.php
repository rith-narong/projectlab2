<?php
include('../config.php');

try {
    // Check if the connection is already initialized
    if (!isset($conn)) {
        // Create a new PDO connection if it's not initialized
        $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PWD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Ensure id parameter is passed in the URL and is numeric
    if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "<script>alert('Invalid product ID'); window.location = 'index.php?p=view';</script>";
        exit;
    }

    // Get the id parameter from the URL
    $id = (int)$_GET['id']; // Cast to integer for safety

    // Fetch the product image filename before deletion
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && !empty($product['image'])) {
        $imagePath = "../images/" . $product['image']; // Adjust the path as needed
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }
    }

    // Prepare and execute the DELETE query using PDO
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute and check if the statement was successful 
    if ($stmt->execute()) {
        // Optionally reset the auto_increment value after deletion (if required)
        try {
            $conn->exec("SET @num := 0;");
            $conn->exec("UPDATE products SET id = @num := (@num+1);");
            $conn->exec("ALTER TABLE products AUTO_INCREMENT = 1;");
        } catch (PDOException $e) {
            die("Error resetting auto-increment: " . $e->getMessage());
        }

        echo "
        <script>
            
            window.location = 'index.php?p=view';   
        </script>";
    } else {
        echo "<script>alert('Error deleting product. Please try again later.'); window.location = 'index.php?p=view';</script>";
    }

} catch (PDOException $e) {
    // Catch any exceptions and show an error message
    die("Database error: " . $e->getMessage());
} finally {
    // Close connection (optional, as PDO will close on script end)
    $conn = null;
}
?>

<?php
define("HOST", "127.0.0.1");
define("USER", "your_user");
define("PWD", "your_password");
define("DB", "your_db_name");

try {
    
    // Set DSN (Data Source Name) for PDO
    $dsn = "mysql:host=" . HOST . ";dbname=" . DB . ";charset=utf8";

    // Create a PDO instance
    $pdo = new PDO($dsn, USER, PWD);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
        SET @num := 0;
        UPDATE aside SET id = @num := (@num + 1);
        ALTER TABLE aside AUTO_INCREMENT = 1;
    ";
    

    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
try {
    // Establish a new PDO connection
    $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PWD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate 'id' parameter
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "<script>alert('Invalid aside ID'); window.location = '/projectlab2/admin/index.php?p=viewaside';</script>";
        exit;
    }

    // Get the ID safely
    $id = (int)$_GET['id']; 

    // Fetch the aside image filename before deletion
    $stmt = $conn->prepare("SELECT image FROM aside WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $aside = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($aside && !empty($aside['image'])) {
        $imagePath = "../images/" . $aside['image']; 
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }
    }

    // Delete the aside record
    $stmt = $conn->prepare("DELETE FROM aside WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "<script>window.location = '/projectlab2/admin/index.php?p=viewaside';</script>";
    } else {
        echo "<script>alert('Error deleting aside. Please try again later.'); window.location = '/projectlab2/admin/index.php?p=viewaside';</script>";
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
} finally {
    // Close the connection
    $conn = null;
}
?>

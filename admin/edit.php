<?php
include('../config.php');

try {
    $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PWD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$row = []; // Initialize row to avoid errors
$categories = []; // Initialize category list

// Fetch categories
try {
    $cat_stmt = $conn->prepare("SELECT * FROM categories");
    $cat_stmt->execute();
    $categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching categories: " . $e->getMessage());
}

// Check if ID is set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$row) {
        die("Product not found.");
    }
} else {
    die("Invalid product ID.");
}

// Update product details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $pname = trim($_POST['pname']);
    $pprice = trim($_POST['pprice']);
    $pquantity = intval($_POST['pquantity']);
    $pdesc = trim($_POST['pdesc']);
    $pcategory = intval($_POST['category_id']); // Fixing category assignment
    $pimg = $row['image']; // Default to existing image

    // Validate price
    if (!is_numeric($pprice) || $pprice <= 0) {
        die("Invalid price.");
    }

    // Validate file upload
    if (isset($_FILES['pimg']['name']) && $_FILES['pimg']['name'] != "") {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($_FILES['pimg']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_types)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }

        $pimg = uniqid() . "." . $file_ext; // Rename file to avoid conflicts
        $target = "../images/" . $pimg;
        if (!move_uploaded_file($_FILES['pimg']['tmp_name'], $target)) {
            die("Failed to upload image.");
        }
    }

    // Update query
    $stmt = $conn->prepare("UPDATE products SET name=:pname, price=:pprice, stock=:pquantity, description=:pdesc, category_id=:category_id, image=:pimg WHERE id=:id");
    $stmt->execute([
        'pname' => $pname,
        'pprice' => $pprice,
        'pquantity' => $pquantity,
        'pdesc' => $pdesc,
        'category_id' => $pcategory,
        'pimg' => $pimg,
        'id' => $id
    ]);
    header("Location: index.php?p=view");    
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="shortcut icon" href="../images/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" name="pname" class="form-control" value="<?php echo isset($row['name']) ? htmlspecialchars($row['name']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Product Price:</label>
                <input type="text" name="pprice" class="form-control" value="<?php echo isset($row['price']) ? htmlspecialchars($row['price']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Product Quantity:</label>
                <input type="number" name="pquantity" class="form-control" value="<?php echo isset($row['stock']) ? htmlspecialchars($row['stock']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Product Description:</label>
                <textarea name="pdesc" class="form-control" required><?php echo isset($row['description']) ? htmlspecialchars($row['description']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="pcategory">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="" disabled>Select Category</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>" <?= ($category['id'] == $row['category_id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Product Image:</label>
                <input type="file" name="pimg" class="form-control-file">
                <?php if (!empty($row['image'])): ?>
                <?php endif; ?>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="index.php?p=view" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>


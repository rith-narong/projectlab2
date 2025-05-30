<?php
define("HOST", "127.0.0.1");
define("USER", "root");
define("PWD", "");
define("DB", "ecommerce");

try {
    // Set up PDO connection
    $pdo = new PDO("mysql:host=" . HOST . ";dbname=" . DB . ";charset=utf8", USER, PWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$row = [];

// Fetch categories
try {
    $cat_stmt = $pdo->prepare("SELECT * FROM aside");
    $cat_stmt->execute();
    $categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching categories: " . $e->getMessage());
}

// Check if ID is set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM aside WHERE id = :id");
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
    $pdesc = trim($_POST['pdesc']);
    $pimg = $row['image']; // Default to existing image

    // Validate file upload
    if (isset($_FILES['pimg']['name']) && $_FILES['pimg']['name'] != "") {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($_FILES['pimg']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_types)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }

        $pimg = uniqid() . "." . $file_ext;
        $target = "../images/" . $pimg;

         // Check if directory is writable
         if (!is_writable('../images')) {
            die("The images directory is not writable.");
        }
        if (!move_uploaded_file($_FILES['pimg']['tmp_name'], $target)) {
            die("Failed to upload image.");
        }
    }

    // Update query
    $stmt = $pdo->prepare("UPDATE aside SET title=:pname, des=:pdesc, image=:pimg WHERE id=:id");
    $stmt->execute([
        'pname' => $pname,
        'pdesc' => $pdesc,
        'pimg' => $pimg,
        'id' => $id
    ]);

    header("Location: /projectlab2/admin/index.php?p=viewaside");
    exit();
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Aside</title>
    <link rel="shortcut icon" href="../images/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Aside</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="pname" class="form-control" value="<?php echo isset($row['title']) ? htmlspecialchars($row['title']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Description:</label>
                <textarea name="pdesc" class="form-control" required><?php echo isset($row['des']) ? htmlspecialchars($row['des']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="pimg" class="form-control-file">
                <?php if (!empty($row['image'])): ?>
                    <img src="../images/<?php echo htmlspecialchars($row['image']); ?>" width="100" alt="Product Image">
                <?php endif; ?>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="/projectlab2/admin/index.php?p=viewaside" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

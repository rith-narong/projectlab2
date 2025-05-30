<?php
// Include database connection file
include '../db.php'; // Ensure this file initializes $conn properly
include '../config.php';
$result = dbSelect("categories", "*", "", "");
 

try {
    // Establish PDO connection before executing queries
    $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PWD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['submit'])) {
    // Sanitize and validate input
    $name = htmlspecialchars($_POST['pname']);
    $description = htmlspecialchars($_POST['pdesc']);
    $price = filter_var($_POST['pprice'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $stock = filter_var($_POST['pstock'], FILTER_SANITIZE_NUMBER_INT);
    $category = $_POST['category_id'];

    // Handle Image Upload
    if (isset($_FILES['pimg']) && $_FILES['pimg']['error'] === UPLOAD_ERR_OK) {
        // Define upload directory - use a relative path
        $upload_dir = __DIR__ . "/../images/";

        // Ensure the uploads directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Sanitize the image filename and create a unique filename to prevent overwriting
        $image = basename($_FILES['pimg']['name']);
        $imageid = uniqid() . "_" . $image;
        $image_path = $upload_dir . $imageid;

        // Move uploaded file to uploads folder
        if (move_uploaded_file($_FILES['pimg']['tmp_name'], $image_path)) {
            try {
                // Insert data into the database
                $sql = "INSERT INTO products (name, description, price, stock, category_id, image) 
                        VALUES (:name, :description, :price, :stock, :category, :image)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':description' => $description,
                    ':price' => $price,
                    ':stock' => $stock,
                    ':category' => $category,
                    ':image' => $imageid // Store unique filename
                ]);

                echo "<div class='alert alert-success text-center'>Product added successfully!</div>";
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger text-center'>Error: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger text-center'>Image upload failed!</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>File upload failed or no file selected.</div>";
    }
}

// Fetch Data from Database
$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4 class="text-center">Add Products</h4>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <label for="pname">Product Name</label>
                        <input type="text" name="pname" placeholder="Enter Product Name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pdesc">Description</label>
                        <textarea rows="3" name="pdesc" placeholder="Enter Description" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="pprice">Price</label>
                        <input type="number" name="pprice" placeholder="Enter Product Price" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="pstock">Stock</label>
                        <input type="number" name="pstock" placeholder="Enter Product Stock" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="pcategory">Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="" disabled selected>Select Category</option>
                            <?php
                                foreach ($result as $row) {
                            ?>
                            <option value="<?=$row['id']?>"><?=$row['name']?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="pimg">Upload Product Image</label>
                        <input type="file" name="pimg" class="form-control-file" required>
                    </div>
                    <div class="col-md-12 mt-3 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

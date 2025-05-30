<?php
// Include database connection file
include '../db.php'; // Ensure this file initializes $conn properly
define("HOST", "127.0.0.1");
define("USER", "root");
define("PWD", "");
define("DB", "ecommerce");

try {
    
    // Set DSN (Data Source Name) for PDO
    $dsn = "mysql:host=" . HOST . ";dbname=" . DB . ";charset=utf8";

    // Create a PDO instance
    $pdo = new PDO($dsn, USER, PWD);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    

    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

try {
    // Establish PDO connection before executing queries
    $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PWD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['submit'])) {
    // Sanitize and validate input
    $title = htmlspecialchars(trim($_POST['title']));
    $des = htmlspecialchars(trim($_POST['des']));

    // Ensure fields are not empty
    if (empty($title) || empty($des)) {
        echo "<div class='alert alert-danger text-center'>All fields are required!</div>";
    } else {
        // Handle Image Upload
        if (isset($_FILES['pimg']) && $_FILES['pimg']['error'] === UPLOAD_ERR_OK) {
            // Define upload directory
            $upload_dir = __DIR__ . "/../images/";

            // Ensure the uploads directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Sanitize the image filename and create a unique filename
            $image = basename($_FILES['pimg']['name']);
            $imageid = uniqid() . "_" . $image;
            $image_path = $upload_dir . $imageid;

            // Move uploaded file to uploads folder
            if (move_uploaded_file($_FILES['pimg']['tmp_name'], $image_path)) {
                try {
                    // Insert data into the database
                    $sql = "INSERT INTO aside (title, des, image) 
                            VALUES (:title, :des, :image)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':title' => $title,  // Corrected from $name to $title
                        ':des' => $des,
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
}

// Fetch Data from Database
$sql = "SELECT * FROM aside";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4 class="text-center">Add Aside</h4>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <label for="title">Product Name</label>
                        <input type="text" name="title" placeholder="Enter Product Name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="des">Description</label>
                        <textarea rows="3" name="des" placeholder="Enter Description" class="form-control" required></textarea>
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

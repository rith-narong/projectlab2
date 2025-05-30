<?php
// Database connection
include("../db.php");
include("../config.php");

try {
    $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PWD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("SET @num := 0;");
    $conn->exec("UPDATE categories SET id = @num := (@num+1);");
    $conn->exec("ALTER TABLE categories AUTO_INCREMENT = 1;");

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Insert data into categories table
if (isset($_POST['submit'])) {
    $pname = $_POST['pname'];
    $pdesc = $_POST['pdesc'];

    try {
        $sql = "INSERT INTO categories (name, description) VALUES (:pname, :pdesc)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pname', $pname);
        $stmt->bindParam(':pdesc', $pdesc);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Product added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error adding product.</div>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4 class="text-center">Add Category</h4>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <label for="pname">Product Name</label>
                        <input type="text" name="pname" placeholder="Enter Product Name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pdesc">Description</label>
                        <textarea rows="3" name="pdesc" placeholder="Enter Description" class="form-control" required></textarea>
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

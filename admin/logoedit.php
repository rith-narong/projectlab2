<?php
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

// Fetch the current logo using PDO
$stmt = $pdo->prepare("SELECT * FROM logo LIMIT 1");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['logo'])) {
  $targetDir = "../images/";
  $targetFile = $targetDir . basename($_FILES["logo"]["name"]);
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Check if the file is an image
  if (getimagesize($_FILES["logo"]["tmp_name"])) {
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFile)) {
      // Update the logo in the database
      $stmt = $pdo->prepare("UPDATE logo SET image = :image WHERE id = 1");
      $stmt->bindValue(':image', basename($_FILES["logo"]["name"]));
      $stmt->execute();
      $message = "Logo updated successfully!";
    } else {
      $message = "Sorry, there was an error uploading your file.";
    }
  } else {
    $message = "File is not an image.";
  }
}
?>

<div class="container mt-5">
  <h2>Edit Logo</h2>

  <!-- Display current logo -->
  <?php if (isset($row['image'])): ?>
  <div class="row">
    <div class="col-md-6">
      <h5>Current Logo</h5>
      <img id="current-logo" src="../images/<?= htmlspecialchars($row['image']) ?>" alt="Current Logo" class="img-fluid" />
    </div>
  </div>
  <?php endif; ?>

  <!-- Display message if any -->
  <?php if (isset($message)): ?>
  <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <!-- Form to upload a new logo -->
  <form action="index.php?p=logoedit" method="POST" enctype="multipart/form-data">
    <div class="form-group mt-3">
      <label for="logoUpload">Upload New Logo</label>
      <input type="file" class="form-control-file" id="logoUpload" name="logo" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Update Logo</button>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

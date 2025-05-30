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

  // Reset ID auto-increment properly
  $pdo->exec("SET @num := 0;");
  $pdo->exec("UPDATE aside SET id = @num := (@num+1);");
  $pdo->exec("ALTER TABLE aside AUTO_INCREMENT = 1;");
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// Fetch the products using PDO
$result = dbSelect("aside", "*", "", "");
$num = is_array($result) ? count($result) : 0;
?>
<div class="container-fluid body-area mt-5">
  <div class="row mt-2"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 view-area mt-2 p-1">
      <div class="card">
        <div class="card-header">
          <h4 class="text-center">View Aside</h4>
        </div>
        <div class="card-body">
          <table id="dtBasicExample" class="table table-responsive table-striped table-bordered w-100 d-block d-md-table" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="th-sm">ID</th>
                <th class="th-sm">Title</th>
                <th class="th-sm">Aside Image</th>
                <th class="th-sm">Aside Description</th>
                <th class="th-sm">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($num > 0) : ?>
                <?php foreach ($result as $row) : ?>
                  <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><img src="../images/<?= htmlspecialchars($row['image']) ?>" class="img-thumbnail" height="50px" width="50px" id="pimg"></td>
                    <td>
                      <div class="product-description" id="desc-<?= $row['id'] ?>" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?= htmlspecialchars($row['des']) ?>
                      </div>
                      <button class="btn btn-info btn-sm mt-2" onclick="toggleDescription(<?= $row['id'] ?>)">Show Description</button>
                    </td>
                    <td>
                      <a href="/projectlab2/admin/editaside.php?id=<?= $row['id'] ?>" class="badge badge-primary">Edit</a>
                      <a href="./aside/deleteaside.php?id=<?= $row['id'] ?>" class="badge badge-danger" >Delete</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="5" class="text-center">No records found</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // JavaScript function to toggle the visibility of the description
  function toggleDescription(productId) {
    var description = document.getElementById("desc-" + productId);
    var button = description.nextElementSibling;

    // Toggle description visibility
    if (description.style.whiteSpace === "nowrap") {
      description.style.whiteSpace = "normal"; // Show full description
      button.innerText = "Hide Description"; // Change button text
    } else {
      description.style.whiteSpace = "nowrap"; // Hide description
      button.innerText = "Show Description"; // Change button text
    }
  }
</script>

<style>
  .product-description {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>

<?php
include '../db.php'; // Ensure this file initializes $conn properly
include '../config.php';
// Fetch the products using PDO
$result = dbSelect("products", "*", "", "");
// Check if the result is not empty and count the number of rows
$num = count($result);
?>
<div class="container-fluid body-area mt-5">
  <div class="row mt-2"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 view-area mt-2 p-1">
      <div class="card">
        <div class="card-header">
          <h4 class="text-center">View Products</h4>
        </div>
        <div class="card-body">
          <table id="dtBasicExample"
            class="table table-responsive table-striped table-bordered w-100 d-block d-md-table" cellspacing="0"
            width="100%">
            <thead>
              <th class="th-sm">ID</th>
              <th class="th-sm">Product Name</th>
              <th class="th-sm">Product Price</th>
              <th class="th-sm">Product Image</th>
              <th class="th-sm">Product Quantity</th>
              <th class="th-sm">Product Description</th>
              <th class="th-sm">Category</th>
              <th class="th-sm">Action</th>
            </thead>
            <tbody>
              <?php
              // Loop through the result set returned by PDO
              foreach ($result as $row) {
              ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= $row['name'] ?></td>
                  <td>$ <?= $row['price'] ?></td>
                  <td><img src="../images/<?= $row['image'] ?>" class="img-thumbnail" height="50px" width="50px" id="pimg"></td>
                  <td><?= $row['stock'] ?></td>
                  <td>
                    <div class="product-description" id="desc-<?= $row['id'] ?>" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      <?= $row['description'] ?>
                    </div>
                    <button class="btn btn-info btn-sm mt-2" onclick="toggleDescription(<?= $row['id'] ?>)">Show Description</button>
                  </td>
                  <td><?= $row['category_id'] ?></td>
                  <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="badge badge-primary">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="badge badge-danger">Delete</a>
                  </td>
                </tr>
              <?php
              }
              ?>
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
    /* You can adjust the width */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>
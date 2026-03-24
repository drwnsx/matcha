<?php include "database.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Popnail</title>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-danger-subtle">

<nav class="navbar bg-light px-3">
  <span class="navbar-brand">Popnail</span>
  <span class="badge bg-danger" id="cartCount">0</span>
</nav>

<div class="container mt-4">
  <div class="row">

<?php
$result = $conn->query("SELECT * FROM products");
while ($product = $result->fetch_assoc()):
?>

  <div class="col-md-3 mb-4">
    <div class="card h-100">
      <img src="images/<?php echo $product['img']; ?>" class="card-img-top">
      <div class="card-body text-center">
        <h5><?php echo $product['name']; ?></h5>
        <p>₱<?php echo $product['price']; ?></p>
        <p>Stock: <?php echo $product['stock']; ?></p>

        <button class="btn btn-danger w-100"
          onclick="buyNow(<?php echo $product['product_id']; ?>)">
          Buy Now
        </button>
      </div>
    </div>
  </div>

<?php endwhile; ?>

  </div>
</div>

<script>
function buyNow(productId) {
  fetch("purchase.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "product_id=" + productId
  })
  .then(res => res.text())
  .then(data => {
    if (data === "success") {
      alert("Purchase successful!");
      location.reload();
    } else {
      alert(data);
    }
  });
}
</script>

</body>
</html>
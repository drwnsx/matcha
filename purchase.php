<?php
require 'database.php';

$productId = $_POST['product_id'];
$stocks = 1;


$stmt = $conn->prepare("SELECT product_id, name, price, stock FROM products WHERE product_id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo json_encode(["status" => "error", "message" => "Product not found"]);
    exit;
}

if ($product['stock'] < $stocks) {
    echo json_encode(["status" => "error", "message" => "Out of stock"]);
    exit;
}

$price = $product['price'];
$productName = $product['name'];


$update = $conn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");
$update->bind_param("ii", $stocks, $productId);
$update->execute();


$order = $conn->prepare("INSERT INTO orders (product_id, product_name, stocks, price) VALUES (?, ?, ?, ?)");
$order->bind_param("isid", $productId, $productName, $stocks, $price);
$order->execute();


$stmt2 = $conn->prepare("SELECT stock FROM products WHERE product_id = ?");
$stmt2->bind_param("i", $productId);
$stmt2->execute();
$result2 = $stmt2->get_result();
$newStock = $result2->fetch_assoc()['stock'];

echo json_encode(["status" => "success", "newStock" => $newStock]);
?>
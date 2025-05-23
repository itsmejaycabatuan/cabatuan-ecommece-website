<?php
session_start();
require 'vendor/autoload.php';

use Aries\MiniFrameworkStore\Models\Product;

header('Content-Type: application/json');

$product_id = isset($_POST['productId']) ? intval($_POST['productId']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if ($product_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID.']);
    exit;
}

if ($quantity <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid quantity.']);
    exit;
}

$product = new Product();
$productDetails = $product->getById($product_id);

if (!$productDetails) {
    echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ✅ Increment quantity if product already in cart
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    $_SESSION['cart'][$product_id]['total'] = $_SESSION['cart'][$product_id]['price'] * $_SESSION['cart'][$product_id]['quantity'];
} else {
    $_SESSION['cart'][$product_id] = [
        'product_id' => $product_id,
        'name' => $productDetails['name'],
        'price' => $productDetails['price'],
        'image_path' => $productDetails['image_path'],
        'quantity' => $quantity,
        'total' => $productDetails['price'] * $quantity
    ];
}

echo json_encode(['status' => 'success', 'message' => 'Product added to cart.']);
exit;

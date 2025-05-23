<?php 
include 'helpers/functions.php'; 
template('header.php');

use Aries\MiniFrameworkStore\Models\Category;
use Aries\MiniFrameworkStore\Models\Product;
use Carbon\Carbon;

$categories = new Category();
$product = new Product();

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $category = $_POST['category'];
    $image = $_FILES['image'];

    $targetFile = null;
    if ($image['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $targetFile);
    }

    $product->insert([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'slug' => strtolower(str_replace(' ', '-', $name)),
        'image_path' => $targetFile,
        'category_id' => $category,
        'created_at' => Carbon::now('Asia/Manila'),
        'updated_at' => Carbon::now()
    ]);

    $message = "Product added successfully!";
}
?>

<style>
    body {
        background: linear-gradient(135deg, #4b2e05, #a9743b); /* dark brown gradient */
        min-height: 100vh;
        color: #3c2f2f;
    }
    .form-container {
        background: #fff9f0; /* light cream */
        box-shadow: 0 8px 16px rgba(0,0,0,0.3);
        border-radius: 12px;
        padding: 2.5rem 2rem;
        margin-top: 3rem;
        margin-bottom: 3rem;
    }
    h1 {
        color: #593d1e;
        font-weight: 700;
    }
    label.form-label {
        color: #4a2c04;
        font-weight: 600;
    }
    .btn-primary {
        background-color: #6b3e07;
        border-color: #6b3e07;
    }
    .btn-primary:hover {
        background-color: #8a4e0a;
        border-color: #8a4e0a;
    }
    .alert-success {
        background-color: #d8f3dc;
        color: #344e41;
        border-color: #b7d5c6;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 form-container">
            <h1 class="mb-4 text-center">Add New Product</h1>

            <?php if (isset($message)): ?>
                <div class="alert alert-success text-center" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="add-product.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="productName" class="form-label fw-semibold">Product Name</label>
                    <input type="text" class="form-control" id="productName" name="name" required placeholder="Enter product name">
                </div>

                <div class="mb-3">
                    <label for="productDescription" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control" id="productDescription" name="description" rows="5" placeholder="Enter product description"></textarea>
                </div>

                <div class="mb-3">
                    <label for="productPrice" class="form-label fw-semibold">Price</label>
                    <input type="number" step="0.01" class="form-control" id="productPrice" name="price" required placeholder="Enter price in PHP">
                </div>

                <div class="mb-3">
                    <label for="productCategory" class="form-label fw-semibold">Category</label>
                    <select class="form-select" id="productCategory" name="category" required>
                        <option value="" selected disabled>Select category</option>
                        <?php foreach($categories->getAll() as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="productImage" class="form-label fw-semibold">Product Image</label>
                    <input class="form-control" type="file" id="productImage" name="image" accept="image/*">
                </div>

                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-primary btn-lg">Add Product

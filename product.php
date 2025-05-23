<?php include 'helpers/functions.php'; ?>
<?php

if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

?>
<?php template('header.php'); ?>

<?php

use Aries\MiniFrameworkStore\Models\Product;

$productId = $_GET['id'];
$products = new Product();
$product = $products->getById($productId);

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);

?>

<!-- Custom styles -->
<style>
    body {
        background: linear-gradient(135deg, #2c2c2c, #1b1b1b);
        color: #e0e0e0;
    }

    .product-container {
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
    }

    .product-image {
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.5);
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .product-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #ffffff;
    }

    .product-price {
        font-size: 1.5rem;
        color: #80ff80;
        margin-bottom: 20px;
    }

    .product-description {
        font-size: 1.1rem;
        color: #cccccc;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 12px 25px;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    @media (max-width: 768px) {
        .product-title {
            font-size: 2rem;
        }

        .product-price {
            font-size: 1.2rem;
        }
    }
</style>

<!-- Product Section -->
<div class="container my-5">
    <div class="product-container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Product Image" class="product-image img-fluid">
            </div>
            <div class="col-md-6">
                <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                <h4 class="product-price"><?php echo $pesoFormatter->formatCurrency($product['price'], 'PHP'); ?></h4>
                <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                <a href="cart.php?product_id=<?php echo $product['id'] ?>" class="btn btn-success mt-3">Add to Cart</a>
            </div>
        </div>
    </div>
</div>

 
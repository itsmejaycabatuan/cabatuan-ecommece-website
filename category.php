<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>

<?php

use Aries\MiniFrameworkStore\Models\Product;

$products = new Product();
$category = $_GET['name'] ?? 'Unknown Category';

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);

?>

<!-- Custom styles -->
<style>
    body {
        background: linear-gradient(135deg, #2b2b2b, #1f1f1f);
        color: #f0f0f0;
    }

    .category-banner {
        background: linear-gradient(to right, #3e3e3e, #292929);
        padding: 60px 20px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 40px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    }

    .category-banner h1 {
        font-size: 3rem;
        font-weight: bold;
        color: #ffffff;
    }

    .category-banner p {
        color: #cccccc;
        font-size: 1.2rem;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .card-title, .card-text, .card-subtitle {
        color: #f1f1f1;
    }

    .btn-primary, .btn-success {
        border: none;
        padding: 10px;
    }

    .btn-primary:hover, .btn-success:hover {
        opacity: 0.9;
    }

    .btn-primary {
        background-color: #007bff;
    }

    .btn-success {
        background-color: #28a745;
    }

    .card-body {
        padding: 20px;
    }
</style>

<!-- Category Banner -->
<div class="container">
    <div class="category-banner">
        <h1><?php echo htmlspecialchars($category); ?></h1>
        <p>Explore our collection of carefully curated products</p>
    </div>
</div>

<!-- Product Grid -->
<div class="container mb-5">
    <div class="row g-4">
        <?php foreach ($products->getByCategory($category) as $product): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <img src="<?php echo htmlspecialchars($product['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-success">
                            <?php echo $pesoFormatter->formatCurrency($product['price'], 'PHP'); ?>
                        </h6>
                        <p class="card-text flex-grow-1"><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="d-grid gap-2 mt-3">
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">View Product</a>
                            <a href="cart.php?product_id=<?php echo $product['id']; ?>" class="btn btn-success">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



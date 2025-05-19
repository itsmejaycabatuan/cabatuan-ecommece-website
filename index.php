<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\Product;

$products = new Product();

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);

?>
<div class="container">

</div>

<div class="container my-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-12 text-center">
            <h1 style="font-family: 'Arial', sans-serif;">Welcome to AJC Online Shop</h1>
            <p class="lead">Your one-stop shop for all your needs!</p>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4"> <h2>Products</h2>
        <?php foreach($products->getAll() as $product): ?>
        <div class="col">
            <div class="card h-100"> <img src="<?php echo $product['image_path'] ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column justify-content-between"> <div>
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $pesoFormatter->formatCurrency($product['price'], 'PHP'); ?></h6>
                        <p class="card-text"><?php
                            $description = $product['description'];
                            if (strlen($description) > 100) {
                                echo htmlspecialchars(substr($description, 0, 100)) . '... <a href="product.php?id=' . $product['id'] . '">Read More</a>';
                            } else {
                                echo htmlspecialchars($description);
                            }
                            ?></p>
                    </div>
                    <div class="mt-2">
                        <a href="product.php?id=<?php echo $product['id'] ?>" class="btn btn-primary btn-sm w-100 mb-2">View Product</a>
                        <button class="btn btn-success btn-block add-to-cart w-100" data-productid="<?php echo $product['id'] ?>" data-quantity="1">
                            <i class="bi bi-cart-plus-fill"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php template('footer.php'); ?>
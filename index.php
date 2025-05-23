<?php
include 'helpers/functions.php';
template('header.php');

use Aries\MiniFrameworkStore\Models\Product;

$products = new Product();

$amountLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amountLocale, NumberFormatter::CURRENCY);
?>

<style>
.hero {
    background: url('assets/images/bg.jpg') no-repeat center center / cover;
    position: relative;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.6);
    backdrop-filter: blur(5px);
    z-index: 1;
}

.hero .content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.card:hover {
    transform: translateY(-5px);
    transition: 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
</style>

<div class="hero mb-5">
    <div class="content">
        <h1 class="display-4 fw-bold">AJC Online Shop</h1>
        <p class="lead">Your one-stop shop for all your needs</p>
    </div>
</div>

<div class="container">
    <h2 class="text-center mb-4">🛍️ Our Products</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($products->getAll() as $product): ?>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="<?php echo $product['image_path']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $pesoFormatter->formatCurrency($product['price'], 'PHP'); ?></h6>
                        <p class="card-text">
                            <?php
                            $description = $product['description'];
                            echo htmlspecialchars(strlen($description) > 100 ? substr($description, 0, 100) . '... <a href="product.php?id=' . $product['id'] . '">Read More</a>' : $description);
                            ?>
                        </p>
                    </div>
                    <div class="mt-2">
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary btn-sm w-100 mb-2">View Product</a>
                        <button class="btn btn-success btn-block add-to-cart w-100" data-productid="<?php echo $product['id']; ?>" data-quantity="1">
                            <i class="bi bi-cart-plus-fill"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
        const productId = button.dataset.productid;
        const quantity = button.dataset.quantity;

        fetch('/cabatuan-ecommece-website/cart-process.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `productId=${productId}&quantity=${quantity}`
        })
        .then(response => response.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                alert(data.message);
            } catch (e) {
                console.error('Server response is not valid JSON:', text);
                alert('Error adding to cart. Check console for details.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Network error. Please try again.');
        });
    });
});
</script>

<?php template('footer.php'); ?>

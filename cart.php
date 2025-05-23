<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>

<?php
if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        echo "<script>alert('Product removed from cart');</script>";
    }
}

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);
?>

<!-- Custom Styling -->
<style>
    body {
        background: linear-gradient(to right, #1f1f1f, #2b2b2b);
        color: #f1f1f1;
    }

    .container {
        background-color: rgba(255, 255, 255, 0.04);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
    }

    h1 {
        font-size: 2.5rem;
        color: #ffffff;
        margin-bottom: 30px;
    }

    .table {
        background-color: rgba(255, 255, 255, 0.02);
        border-radius: 10px;
        overflow: hidden;
        color: #ffffff;
    }

    .table th,
.table td {
    background-color: transparent;
    border-color: #444;
    color: #ffffff; /* Make text inside the cart white */
}


    .btn {
        padding: 10px 20px;
        font-size: 1rem;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0069d9;
    }

    .text-end {
        text-align: right;
    }

    a {
        color: inherit;
        text-decoration: none;
    }
</style>

<!-- Cart Content -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h1>Shopping Cart</h1>

            <?php if (countCart() == 0): ?>
                <p>Your cart is empty.</p>
                <a href="index.php" class="btn btn-primary">Continue Shopping</a>
            <?php else: ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $superTotal = 0; ?>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <?php if (!is_array($item)) continue; ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo (int)$item['quantity']; ?></td>
                                <td><?php echo $pesoFormatter->formatCurrency($item['price'], 'PHP'); ?></td>
                                <td><?php echo $pesoFormatter->formatCurrency($item['total'], 'PHP'); ?></td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $item['product_id']; ?>" class="btn btn-danger">Remove</a>
                                </td>
                            </tr>
                            <?php $superTotal += $item['total']; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td colspan="2"><strong><?php echo $pesoFormatter->formatCurrency($superTotal, 'PHP'); ?></strong></td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4">
                    <a href="checkout.php" class="btn btn-success">Checkout</a>
                    <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>



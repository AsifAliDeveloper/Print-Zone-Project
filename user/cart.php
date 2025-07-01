<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Your Cart</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><img src="<?php echo $item['image_path']; ?>" alt="Product Image" style="width: 100px;"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    <td>
                        <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>" class="btn btn-danger">Remove</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center">
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

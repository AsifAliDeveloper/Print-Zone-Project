<?php
session_start();
include('db.php');

// Check if the product ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Product ID is required.");
}

// Get the product ID from the URL
$product_id = (int) $_GET['id'];

// Search for the product in the session's cart
$product_in_cart = null;
foreach ($_SESSION['cart'] as $item) {
    if ($item['id'] == $product_id) {
        $product_in_cart = $item;
        break;
    }
}

if (!$product_in_cart) {
    die("Product not found in your cart.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - <?php echo htmlspecialchars($product_in_cart['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Product Details</h2>

    <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
        <img src="<?php echo htmlspecialchars($product_in_cart['image_path']); ?>" class="card-img-top" alt="Product Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($product_in_cart['name']); ?></h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($product_in_cart['description'])); ?></p>
            <p class="card-text"><strong>Price: $<?php echo number_format($product_in_cart['price'], 2); ?></strong></p>
            <p class="card-text"><strong>Quantity: <?php echo $product_in_cart['quantity']; ?></strong></p>

            <!-- Display total price for the quantity of the item in the cart -->
            <p class="card-text"><strong>Total: $<?php echo number_format($product_in_cart['price'] * $product_in_cart['quantity'], 2); ?></strong></p>

            <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

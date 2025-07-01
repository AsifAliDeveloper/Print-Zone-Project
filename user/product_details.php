<?php
session_start();
include('db.php');

// Check if the product ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Product ID is required.");
}

// Get the product ID from the URL
$product_id = (int) $_GET['id'];

// Fetch the product details from the database
$query = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($query);

// Check if the product exists
if ($result->num_rows == 0) {
    die("Product not found.");
}

// Fetch the product details
$product = $result->fetch_assoc();

// Add to cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1; // Default quantity to 1 if not provided

    // If the cart doesn't exist in the session, create it
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $product_id) {
            $cart_item['quantity'] += $quantity;  // Update quantity if product is already in the cart
            $product_exists = true;
            break;
        }
    }

    // If the product is not in the cart, add it
    if (!$product_exists) {
        $_SESSION['cart'][] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'image_path' => $product['image_path']
        ];
    }

    // Redirect to the cart page (optional)
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - <?php echo htmlspecialchars($product['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Product Details</h2>

    <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
        <!-- Product Image -->
        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" class="card-img-top" alt="Product Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            <p class="card-text"><strong>Price: $<?php echo number_format($product['price'], 2); ?></strong></p>

            <!-- Add to Cart Form -->
            <form action="product_details.php?id=<?php echo $product['id']; ?>" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
                </div>
                <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
            </form>

            <!-- If the user is a company (logged in), show edit and delete options -->
            <?php if (isset($_SESSION['company_id']) && $_SESSION['company_id'] == $product['company_id']): ?>
                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-warning">Edit Product</a>
                <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Back to Product List -->
    <a href="index.php" class="btn btn-secondary">Back to Product List</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

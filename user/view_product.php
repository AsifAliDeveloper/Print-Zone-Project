<?php

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
include 'db.php';

// Fetch all products from the product table
$query = "SELECT id, name, description, price, image_path FROM products";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching products: " . $conn->error);
}

// Fetch recent products
$recentproducts = $conn->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 6");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Print Zone</title>
    <!-- Logo Icon -->
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <!-- User Panel -->
    <link rel="stylesheet" href="style.css"> <!-- User-specific CSS -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!--- Available Products --->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Available Products</h2>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo $product['image_path']; ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="card-text"><strong>Price: $<?php echo number_format($product['price'], 2); ?></strong></p>
                                <a href="product_details.php?id=<?php echo $product['id']; ?>" class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No products available.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
<?php
session_start();
include('db.php');

// Check if company is logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: company_login.php");
    exit();
}

// Get company details
$company_id = $_SESSION['company_id'];
$company_query = $conn->query("SELECT * FROM companies WHERE id = $company_id");
$company = $company_query->fetch_assoc();

// Fetch products
$product_query = $conn->query("SELECT COUNT(*) AS product_count FROM products WHERE company_id = $company_id");
$product_count = $product_query->fetch_assoc()['product_count'];

// Fetch cards
$card_query = $conn->query("SELECT COUNT(*) AS card_count FROM cards WHERE company_id = $company_id");
$card_count = $card_query->fetch_assoc()['card_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Include Header -->
    <?php include('header.php'); ?> <!-- Include header -->
    <!-- End header -->

<div class="container mt-5">
    <h1 class="text-center">Welcome, <?php echo htmlspecialchars($company['name']); ?></h1>
    <div class="row mt-4">
        <!-- Overview Cards -->
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Total Products</h4>
                    <p class="card-text fs-2"><?php echo $product_count; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Total Cards</h4>
                    <p class="card-text fs-2"><?php echo $card_count; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Account Created</h4>
                    <p class="card-text fs-5"><?php echo date("F j, Y", strtotime($company['created_at'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Manage Products -->
    <div class="mt-5">
        <h2>Manage Products</h2>
        <a href="add_product.php" class="btn btn-primary mb-3">Add New Product</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = $conn->query("SELECT * FROM products WHERE company_id = $company_id");
                if ($products->num_rows > 0) {
                    while ($product = $products->fetch_assoc()) {
                        echo "<tr>
                                <td>{$product['id']}</td>
                                <td>" . htmlspecialchars($product['name']) . "</td>
                                <td>" . htmlspecialchars($product['description']) . "</td>
                                <td>$" . number_format($product['price'], 2) . "</td>
                                <td>
                                    <a href='edit_product.php?id={$product['id']}' class='btn btn-sm btn-warning'>Edit</a>
                                    <a href='delete_product.php?id={$product['id']}' class='btn btn-sm btn-danger'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No products available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Manage Cards -->
    <div class="mt-5">
        <h2>Manage Cards</h2>
        <a href="upload_card.php" class="btn btn-primary mb-3">Upload New Card</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Uploaded At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cards = $conn->query("SELECT * FROM cards WHERE company_id = $company_id");
                if ($cards->num_rows > 0) {
                    while ($card = $cards->fetch_assoc()) {
                        echo "<tr>
                                <td>{$card['id']}</td>
                                <td>" . htmlspecialchars($card['card_title']) . "</td>
                                <td>{$card['uploaded_at']}</td>
                                <td>
                                    <a href='view_card.php?id={$card['id']}' class='btn btn-sm btn-info'>View</a>
                                    <a href='delete_card.php?id={$card['id']}' class='btn btn-sm btn-danger'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No cards available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

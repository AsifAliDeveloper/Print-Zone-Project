<?php
session_start();
include('db.php');

// Check if the company is logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: company_login.php");
    exit();
}

// Get the company ID from the session
$company_id = $_SESSION['company_id'];

// Check if the product ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Product ID is required.");
}

// Get the product ID from the URL
$product_id = (int) $_GET['id'];

// Check if the product exists and belongs to the logged-in company
$product_query = $conn->query("SELECT * FROM products WHERE id = $product_id AND company_id = $company_id");
if ($product_query->num_rows == 0) {
    die("Product not found or access denied.");
}

// Fetch the product details (optional, for additional logic or logging)
$product = $product_query->fetch_assoc();

// Delete the product from the database
$delete_query = "DELETE FROM products WHERE id = $product_id AND company_id = $company_id";
if ($conn->query($delete_query)) {
    // Redirect to the dashboard or another page with a success message
    header("Location: dashboard.php?message=Product deleted successfully.");
    exit();
} else {
    die("Error deleting product: " . $conn->error);
}
?>

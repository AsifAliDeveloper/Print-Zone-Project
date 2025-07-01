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

// Check if the product ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Product ID is required.");
}

// Get product details
$product_id = (int) $_GET['id'];
$product_query = $conn->query("SELECT * FROM products WHERE id = $product_id AND company_id = $company_id");
if ($product_query->num_rows == 0) {
    die("Product not found or access denied.");
}
$product = $product_query->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $image = $_FILES['image'];

    $update_image_query = "";

    // Check if a new image is uploaded
    if ($image['size'] > 0) {
        $uploadDir = "uploads/products/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }

        // Generate unique file name and move uploaded file
        $imageName = basename($image['name']);
        $targetFile = $uploadDir . uniqid() . "_" . $imageName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $update_image_query = ", image_path = '$targetFile'";
        } else {
            $error_message = "Failed to upload image.";
        }
    }

    // Update product details
    $update_query = "UPDATE products 
                     SET name = '$name', description = '$description', price = '$price' $update_image_query
                     WHERE id = $product_id AND company_id = $company_id";
                     
    if ($conn->query($update_query)) {
        $success_message = "Product updated successfully.";
    } else {
        $error_message = "Error updating product: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Edit Product</h2>

    <!-- Show success or error message -->
    <?php if (isset($success_message)) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php } elseif (isset($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

    <form action="edit_product.php?id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <!-- Product Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <!-- Product Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Product Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>
        </div>

        <!-- Product Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <small class="text-muted">Leave blank to keep the current image.</small>
            <?php if (!empty($product['image_path'])): ?>
                <div class="mt-2">
                    <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="Current Product Image" width="150">
                </div>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="update_product" class="btn btn-primary w-100">Update Product</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

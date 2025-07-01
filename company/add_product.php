<?php
// Start the session
session_start();

// Include the database connection
include('db.php'); // Ensure you have a db.php file for DB connection

// Check if the company is logged in, otherwise redirect to login page
if (!isset($_SESSION['company_id'])) {
    header("Location: company_login.php");
    exit();
}

// Get the company ID from the session
$company_id = $_SESSION['company_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $image = $_FILES['image'];

    // Image upload directory
    $uploadDir = "uploads/products/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }

    // Process the image file
    $imageName = basename($image['name']);
    $targetFile = $uploadDir . uniqid() . "_" . $imageName; // Generate unique file name

    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        // Insert product data into the database
        $sql = "INSERT INTO products (company_id, name, description, price, image_path) 
                VALUES ('$company_id', '$name', '$description', '$price', '$targetFile')";
        
        if ($conn->query($sql)) {
            $success_message = "Product added successfully!";
        } else {
            $error_message = "Error adding product: " . $conn->error;
        }
    } else {
        $error_message = "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Add New Product</h2>

    <!-- Show success or error message -->
    <?php if (isset($success_message)) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php } elseif (isset($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

    <form action="add_product.php" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required>
        </div>

        <!-- Product Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter product description" rows="4" required></textarea>
        </div>

        <!-- Product Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Product Price</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Enter product price" step="0.01" required>
        </div>

        <!-- Product Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="add_product" class="btn btn-primary w-100">Add Product</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

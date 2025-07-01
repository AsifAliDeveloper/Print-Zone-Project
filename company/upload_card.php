<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Upload Card</h2>
        <form action="upload_card.php" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
            <!-- Card Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Card Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter card title" required>
            </div>

            <!-- Card Image -->
            <div class="mb-3">
                <label for="card_image" class="form-label">Upload Card</label>
                <input type="file" class="form-control" id="card_image" name="card_image" accept="image/*" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="upload_card" class="btn btn-primary w-100">Upload Card</button>
        </form>
    </div>
</body>
</html>

<?php
session_start();

// Include database connection
include('db.php'); // Ensure you have a db.php file for DB connection

// Check if the company is logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: company_login.php");
    exit();
}

// Get company ID from session
$company_id = $_SESSION['company_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_card'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $card_image = $_FILES['card_image'];

    // Directory to store uploaded cards
    $uploadDir = "uploads/cards/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }

    // Process uploaded card image
    $imageName = basename($card_image['name']);
    $targetFile = $uploadDir . uniqid() . "_" . $imageName; // Generate a unique file name

    if (move_uploaded_file($card_image['tmp_name'], $targetFile)) {
        // Insert card data into the database
        $sql = "INSERT INTO cards (company_id, card_title, card_path) 
                VALUES ('$company_id', '$title', '$targetFile')";

        if ($conn->query($sql)) {
            echo "<div class='alert alert-success'>Card uploaded successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error uploading card: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Failed to upload card image.</div>";
    }
}
?>

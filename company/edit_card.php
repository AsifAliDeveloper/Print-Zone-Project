<?php
session_start();
include('db.php');

// Check if the company is logged in
if (!isset($_SESSION['company_id'])) {
    header("Location: company_login.php");
    exit();
}

// Check if the card ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Card ID is required.");
}

// Get the card ID from the URL
$card_id = (int) $_GET['id'];

// Fetch the card details from the database to populate the form
$query = "SELECT * FROM cards WHERE id = $card_id AND company_id = " . $_SESSION['company_id'];
$result = $conn->query($query);

// Check if the card exists
if ($result->num_rows == 0) {
    die("Card not found or access denied.");
}

// Fetch the card details
$card = $result->fetch_assoc();

// Handle the form submission to update the card
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $_POST['price'];  // Get price from form input
    $image = $_FILES['image'];

    // Check if an image was uploaded
    if ($image['error'] == 0) {
        // Image upload directory
        $uploadDir = "uploads/cards/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
        }

        // Process the image file
        $imageName = basename($image['name']);
        $targetFile = $uploadDir . uniqid() . "_" . $imageName; // Generate unique file name

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Update the card in the database with the new image and other details
            $sql = "UPDATE cards SET name = '$name', description = '$description', price = '$price', image_path = '$targetFile' 
                    WHERE id = $card_id AND company_id = " . $_SESSION['company_id'];
        } else {
            $error_message = "Failed to upload image.";
        }
    } else {
        // If no new image is uploaded, only update other details
        $sql = "UPDATE cards SET name = '$name', description = '$description', price = '$price' 
                WHERE id = $card_id AND company_id = " . $_SESSION['company_id'];
    }

    // Execute the update query
    if ($conn->query($sql)) {
        header("Location: view_card.php?id=$card_id");  // Redirect to the card view page after successful update
        exit();
    } else {
        $error_message = "Error updating card: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Card - <?php echo htmlspecialchars($card['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Edit Card Details</h2>

    <!-- Show error or success messages -->
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="edit_card.php?id=<?php echo $card['id']; ?>" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
    <!-- Card Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Card Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($card['card_title']); ?>" required>
    </div>

    <!-- Card Description -->
    <div class="mb-3">
        <label for="description" class="form-label">Card Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($card['description']); ?></textarea>
    </div>

    <!-- Card Price -->
    <div class="mb-3">
        <label for="price" class="form-label">Card Price</label>
        <input type="number" class="form-control" id="price" name="price" value="<?php echo $card['price']; ?>" step="0.01" required>
    </div>

    <!-- Current Image -->
    <div class="mb-3">
        <label class="form-label">Current Card Image</label>
        <div>
            <?php if (!empty($card['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($card['image_path']); ?>" alt="Card Image" class="img-thumbnail" style="max-width: 200px;">
            <?php else: ?>
                <p>No image available</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Upload New Image (Optional) -->
    <div class="mb-3">
        <label for="image" class="form-label">Upload New Image (Optional)</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary w-100">Update Card</button>
</form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

<?php
// Include the database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo'])) {
    $user_id = 1; // Example user ID (replace with session or login ID)
    $upload_dir = 'logos/';
    if (!is_dir($upload_dir)) mkdir($upload_dir);

    $file_name = basename($_FILES['logo']['name']);
    $file_path = $upload_dir . $file_name;
    $file_type = mime_content_type($_FILES['logo']['tmp_name']);

    // Validate file type
    if (in_array($file_type, ['image/jpeg', 'image/png'])) {
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $file_path)) {
            $conn->query("INSERT INTO user_logos (user_id, logo_path) VALUES ($user_id, '$file_path')");
            $message = "Logo uploaded successfully!";
        } else {
            $message = "Error uploading logo.";
        }
    } else {
        $message = "Invalid file type. Please upload JPEG or PNG.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Logo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Upload Your Logo</h3>
    <?php if (isset($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="logo" class="form-label">Choose Logo:</label>
            <input type="file" name="logo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
</body>
</html>

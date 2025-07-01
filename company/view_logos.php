<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'print_zone');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch logos from the database
$result = $conn->query("SELECT * FROM user_logos ORDER BY uploaded_at DESC");

if (!$result) {
    die("Error fetching logos: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Company Logos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Uploaded Company Logos</h3>
    <?php if ($result->num_rows > 0): ?>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img src="<?= $row['logo_path'] ?>" class="card-img-top" alt="Company Logo">
                        <div class="card-body">
                            <p class="card-text">Uploaded at: <?= $row['uploaded_at'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No logos uploaded yet.</p>
    <?php endif; ?>
</div>
</body>
</html>

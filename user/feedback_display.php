<?php
include 'db.php';

// Fetch feedback data
$result = $conn->query("SELECT f.rating, f.comment, f.created_at, username 
                        FROM feedback f
                        JOIN users u ON f.user_id = u.id
                        ORDER BY f.created_at DESC");

// Calculate average rating
$avg_result = $conn->query("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM feedback");
$avg_data = $avg_result->fetch_assoc();
$average_rating = round($avg_data['avg_rating'], 1);
$total_reviews = $avg_data['total_reviews'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Customer Feedback</title>
</head>
<body>
    <div class="container mt-4">
        <h1>Customer Feedback</h1>
        <div class="mb-4">
            <h3>Average Rating: <?php echo $average_rating; ?> / 5</h3>
            <p><?php echo $total_reviews; ?> reviews</p>
        </div>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['username']; ?></h5>
                    <p class="card-text">Rating: <?php echo str_repeat('⭐', $row['rating']); ?></p>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($row['comment'])); ?></p>
                    <p class="card-text"><small class="text-muted">Submitted on <?php echo $row['created_at']; ?></small></p>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>

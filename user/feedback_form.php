<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO feedback (user_id, rating, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $rating, $comment);
    $stmt->execute();

    echo "<div class='alert alert-success'>Thank you for your feedback!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Submit Feedback</title>
</head>
<body>
    <div class="container mt-4">
        <h1>Submit Feedback</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="rating" class="form-label">Rating (1-5)</label>
                <select name="rating" id="rating" class="form-select" required>
                    <option value="" disabled selected>Choose a rating</option>
                    <option value="1">1 - Very Bad</option>
                    <option value="2">2 - Bad</option>
                    <option value="3">3 - Average</option>
                    <option value="4">4 - Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Write your feedback..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>

<?php
include 'db.php';
//include 'admin_login_check.php';

// Handle feedback deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM feedback WHERE id = $id");
    header("Location: admin_feedback.php");
    exit;
}

// Fetch all feedback
$result = $conn->query("SELECT f.id, f.rating, f.comment, f.created_at, username 
                        FROM feedback f
                        JOIN users u ON f.user_id = u.id
                        ORDER BY f.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Manage Feedback</title>
    <link rel="icon" href="images/logo.png" type="image/icon type">
</head>
<body>
    <div class="container mt-4">
        <h1>Manage Feedback</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['rating']; ?></td>
                    <td><?php echo htmlspecialchars($row['comment']); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

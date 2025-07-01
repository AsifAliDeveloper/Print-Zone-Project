<?php
session_start();
include('db.php');

// Check if the card ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Card ID is required.");
}

// Get the card ID from the URL
$card_id = (int) $_GET['id'];

// Fetch the card details from the database
$query = "SELECT * FROM cards WHERE id = $card_id";
$result = $conn->query($query);

// Check if the card exists
if ($result->num_rows == 0) {
    die("Card not found.");
}

// Fetch the card details
$card = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Details - <?php echo htmlspecialchars($card['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Card Details</h2>

    <div class="card mb-4" style="max-width: 800px; margin: 0 auto;">
        <!-- Card Image -->
        <img src="<?php echo htmlspecialchars($card['card_path']); ?>" class="card-img-top" alt="Card Image">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($card['card_title']); ?></h5>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($card['description'])); ?></p>
            <p class="card-text"><strong>Price: $<?php echo number_format($card['price'], 2); ?></strong></p>
            
            <!-- If the user is a company (logged in), show edit and delete options -->
            <?php if (isset($_SESSION['company_id']) && $_SESSION['company_id'] == $card['company_id']): ?>
                <a href="edit_card.php?id=<?php echo $card['id']; ?>" class="btn btn-warning">Edit Card</a>
                <a href="delete_card.php?id=<?php echo $card['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this card?')">Delete Card</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Back to Card List -->
    <a href="index.php" class="btn btn-secondary">Back to Card List</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

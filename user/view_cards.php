<?php
include('db.php');

// Fetch uploaded cards
$query = "SELECT card_title, card_path, uploaded_at FROM cards  ORDER BY uploaded_at DESC";
$result = $conn->query($query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Uploaded Cards</h2>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($card = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?php echo htmlspecialchars($card['card_path']); ?>" 
                                 class="card-img-top" 
                                 alt="Card Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($card['card_title']); ?></h5>
                                <p class="card-text"><small class="text-muted">Uploaded on: <?php echo $card['uploaded_at']; ?></small></p>
                                <!-- Details Button -->
                                <a href="cart_details.php?id=<?php echo $cart['id']; ?>" class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No cards uploaded yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

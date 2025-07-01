<?php
// Include the database connection
include 'db.php';

// Fetch the order ID from the GET request
$order_id = $_GET['order_id'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking Result</title>
    <!-- Logo Icon -->
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Include Header -->
    <?php include('header.php'); ?> <!-- Include header -->
    <!-- End header -->



    <div class="container mt-5">
        <h1 class="text-center mb-4">Order Tracking - Print Zone</h1>

          <form action="track_order.php" method="GET" class="mb-5">
            <div class="input-group mb-3">
                <input type="text" name="order_id" class="form-control" placeholder="Enter your Order ID" required>
                <button class="btn btn-primary" type="submit">Track Order</button>
            </div>
          </form>
        

        <?php
        if ($order_id) {
            // Query to fetch order details
            $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
            $stmt->bind_param("s", $order_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Display order details
                $order = $result->fetch_assoc();
                echo "<div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>Order ID: " . htmlspecialchars($order['order_id']) . "</h5>
                            <p class='card-text'>Customer Name: " . htmlspecialchars($order['customer_name']) . "</p>
                            <p class='card-text'>Order Status: <strong>" . htmlspecialchars($order['order_status']) . "</strong></p>
                            <p class='card-text'><small class='text-muted'>Created At: " . htmlspecialchars($order['created_at']) . "</small></p>
                        </div>
                    </div>";
            } else {
                // If no order found
                echo "<div class='alert alert-danger'>No order found with ID: " . htmlspecialchars($order_id) . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-warning'>Please provide a valid Order ID.</div>";
        }

        // Close connection
        $conn->close();
        ?>
        <div class="mt-4">
            <a href="index.php" class="btn btn-secondary">Back to Tracking</a>
        </div>
    </div>



    <!--  Start footer -->
    <?php include('footer.php'); ?> <!-- Include footer -->
    <!-- End footer -->

</body>
</html>

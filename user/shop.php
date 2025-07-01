<?php
session_start();

// Include the database connection
include 'db.php';

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping</title>
    <!-- Logo Icon -->
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Include Header -->
    <?php include('header.php'); ?> <!-- Include header -->
    <!-- End header -->

    <!--- Available Products --->
    <?php include('view_product.php')  ?>

    <!-- Include view_cards -->
    <?php include('view_cards.php'); ?> <!-- Include card -->
    <!-- End cards -->

    <!--  Start footer -->
    <?php include('footer.php'); ?> <!-- Include footer -->
    <!-- End footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

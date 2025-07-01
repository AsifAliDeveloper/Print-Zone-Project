<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection
include 'db.php';


// Fetch limited products for the homepage
$homepageProducts = $conn->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 3");

if (!$homepageProducts) {
    die("Error fetching homepage products: " . $conn->error);
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Print Zone</title>
    <!-- Logo Icon -->
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <!-- User Panel -->
    <link rel="stylesheet" href="style.css"> <!-- User-specific CSS -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Include Header -->
    <?php include('header.php'); ?> <!-- Include header -->
    <!-- End header -->

    <!-- Carousel -->
    <div id="demo" class="carousel slide" data-bs-ride="carousel">

        <!-- Indicators/dots -->
        <!--<div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        </div>-->

        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="image-resposive" src="images/bp3.jpg" alt="banner" class="d-block" style="width:100%; height:500px;">
                <div class="carousel-caption" style="color: black;">
                    <h1>Trade-in-offer</h1>
                    <p><span>Super value deal</span><br>Save more with coupons & up to 70% off!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="image-resposive" src="images/s7.jpg" alt="Chicago" class="d-block" style="width:100%; height:500px;">
                <div class="carousel-caption" style="color: white;">
                    <h1>Trade-in-offer</h1>
                    <p><span>Super value deal</span><br>Save more with coupons & up to 70% off!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="image-resposive" src="images/m8.jpg" alt="New York" class="d-block" style="width:100%; height:500px;">
                <div class="carousel-caption" style="color: black;">
                    <h1>Trade-in-offer</h1>
                    <p><span>Super value deal</span><br>Save more with coupons & up to 70% off!</p>
                </div>
            </div>
        </div>

        <!-- Left and right controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>


        <!-- Hero Section -->
    <section id="hero">
        <div class="container-fluid bg-light text-center p-5">
            <h1>Welcome to Print Zone</h1>
            <h4>Trade-in-offer</h4>
            <h2>Super value deal</h2>
            <h1>On all products</h1>
            <p>Your one-stop shop for printing supplies and accessories! Save more with coupons & up to 70% off!</p>
        </div>
    </section>


    <!--- Available Products --->
    <?php include('view_product.php')  ?>

    <!-- Banner Section -->
    <section id="banner" class="text-center text-white d-flex align-items-center justify-content-center" style="background: url('images/banner/b2.jpg') no-repeat center center/cover; height: 60vh;">
        <div class="container">
            <h4 class="fw-bold">Repair Services</h4>
            <h2 class="mt-3">
                Up to <span class="text-warning fw-bold">70% off</span> - All T-Shirts & Accessories
            </h2>
            <a href="#" class="btn btn-primary mt-4 px-4 py-2">Explore More</a>
        </div>
    </section>


    <!-- Include view_cards -->
    <?php include('view_cards.php'); ?> <!-- Include card -->
    <!-- End cards -->

    <!--  Start footer -->
    <?php include('footer.php'); ?> <!-- Include footer -->
    <!-- End footer -->

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>
</html>



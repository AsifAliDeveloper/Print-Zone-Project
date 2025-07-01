<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header - Print Zone</title>
    <!-- Logo Icon -->
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <!-- User Panel -->
    <link rel="stylesheet" href="style.css"> <!-- User-specific CSS -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Include Header -->
    <?php include('header.php'); ?> <!-- Include header -->
    <!-- End header -->


    <section id="page-header"  class="about-header text-center text-white d-flex align-items-center justify-content-center" style="background: url('images/about/banner.png') no-repeat center center/cover; height: 400px;">
        <div class="container">
            <h2 class="display-4 fw-bold">About Us</h2>
            <p class="lead mt-3">Print Zone Website for Printing Press Services</p>
        </div>
    </section>


   
        <section  class="section-p1 mt-5">
        
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <img src="images/about/About.jpg" alt="about us" style="width:100%">
                </div>
                <div class="col-lg-6">
                    <p>Print Zone is Pakistan's leading website for printing press services, offering extensive customization options for products like T-shirts, mugs, bags, pens, caps, and more. The platform simplifies customization with a file upload feature and provides seamless communication via integrated WhatsApp support. Using cutting-edge technology and high-quality materials, Print Zone ensures vibrant, durable, and precise results. Trusted by individuals and businesses for competitive pricing and exceptional service, Print Zone is your go-to for personalized gifts, brand promotion, and creative expression. Visit today to bring your ideas to life!</p>  
                </div>
                <marquee bgcolor ="#77c4ff" loop="-1" scrollamount="5" width="100%">
                "Print Zone" is Pakistan's most popular website for printing press services, offering an extensive range of customization options to meet diverse needs. At Print Zone, we specialize in printing logos and text on a variety of products, including T-shirts, mugs, bags, pens, caps, and more.
                </marquee>
            </div>
        </div>
        </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="bi bi-award display-4 text-primary"></i>
                    <h3>Quality</h3>
                    <p>We provide high-quality products for all your needs.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-globe display-4 text-primary"></i>
                    <h3>Global Reach</h3>
                    <p>Our services reach customers worldwide.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-heart display-4 text-primary"></i>
                    <h3>Customer Care</h3>
                    <p>We are always here to assist you 24/7.</p>
                </div>
            </div>
        </div>
    </section>

    <!--  Start footer -->
      <?php include('footer.php'); ?> 
    <!-- End footer -->

</body>
</html>

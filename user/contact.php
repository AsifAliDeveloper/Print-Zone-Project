<?php
// Include the database connection
include 'db.php';

// Handle Form Submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $messageContent = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$messageContent')";
    if ($conn->query($sql) === TRUE) {
        $message = "Your message has been sent successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Logo Icon -->
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <!-- User Panel -->
    <link rel="stylesheet" href="style.css"> <!-- User-specific CSS -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Include Header -->
    <?php include('header.php'); ?> <!-- Include header -->
    <!-- End header -->

    <section id="page-header"  class="about-header text-center text-white d-flex align-items-center justify-content-center" style="background: url('images/about/banner.png') no-repeat center center/cover; height: 400px;">
        <div class="container">
            <h2 class="display-4 fw-bold">#Let's_Talk</h2>
            <p class="lead mt-3">LEAVE A MESSAGE, We love to hear from you!</p>
        </div>
    </section>

    <!-- Contact Details Section -->
  <section id="contact-details" class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Details -->
            <div class="col-md-6">
                <span class="text-primary fw-bold">GET IN TOUCH</span>
                <h2 class="mt-3">Visit one of our agency locations or contact us today</h2>
                <h3 class="mt-4">Head Office</h3>
                <ul class="list-unstyled mt-3">
                    <li class="d-flex align-items-start mb-3">
                        <i class="bi bi-geo-alt-fill text-primary me-3 fs-4"></i>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
                    </li>
                    <li class="d-flex align-items-start mb-3">
                        <i class="bi bi-envelope-fill text-primary me-3 fs-4"></i>
                        <p>umar@gmail.com</p>
                    </li>
                    <li class="d-flex align-items-start mb-3">
                        <i class="bi bi-telephone-fill text-primary me-3 fs-4"></i>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="bi bi-clock-fill text-primary me-3 fs-4"></i>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
                    </li>
                </ul>
            </div>

            <!-- Google Map -->
            <div class="col-md-6">
                <div class="ratio ratio-16x9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3510.272191928104!2d70.37189117415747!3d28.380845695467922!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39375f95942aad7b%3A0x2a4acb4acd47461e!2sKhawaja%20fareed%20university%20%2CRYK%2C%20Pakistan!5e0!3m2!1sen!2s!4v1721295679050!5m2!1sen!2s"
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
  </section>



  <div class="container mt-5">
    <h2 class="text-center">Contact Us</h2>
    <p class="text-center">We'd love to hear from you! Please fill out the form below.</p>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info text-center"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" action="" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Write your message here..." required></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Send Message</button>
        </div>
    </form>
  </div>

  <!-- Form Details Section -->
  <section id="form-details" class="py-5">
    <div class="container">
        <div class="row">
            <!-- People Section -->
            <div class="col-lg">
                <div class="row g-4">
                    <!-- Person 1 -->
                    <div class="col-md-4 text-center">
                        <img src="images/people/1.png" alt="Person 1" class="img-fluid rounded-circle mb-2">
                        <p>
                            <strong>John Deo</strong><br>
                            Senior Marketing Manager<br>
                            Phone: +92 3156731990<br>
                            Email: <a href="mailto:kfueit@gmail.com" class="text-decoration-none">kfueit@gmail.com</a>
                        </p>
                    </div>
                    <!-- Person 2 -->
                    <div class="col-md-4 text-center">
                        <img src="images/people/2.png" alt="Person 2" class="img-fluid rounded-circle mb-2">
                        <p>
                            <strong>John Deo</strong><br>
                            Senior Marketing Manager<br>
                            Phone: +92 3156731990<br>
                            Email: <a href="mailto:kfueit@gmail.com" class="text-decoration-none">kfueit@gmail.com</a>
                        </p>
                    </div>
                    <!-- Person 3 -->
                    <div class="col-md-4 text-center">
                        <img src="images/people/3.png" alt="Person 3" class="img-fluid rounded-circle mb-2">
                        <p>
                            <strong>John Deo</strong><br>
                            Senior Marketing Manager<br>
                            Phone: +92 3156731990<br>
                            Email: <a href="mailto:kfueit@gmail.com" class="text-decoration-none">kfueit@gmail.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

  <!--  Start footer -->
  <?php include('footer.php'); ?> <!-- Include footer -->
  <!-- End footer -->

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Start the session
session_start();

// Include the database connection
include('db.php'); // Ensure you have a db.php file for DB connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Get form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $website = $conn->real_escape_string($_POST['website']);
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = "SELECT * FROM companies WHERE email = '$email'";
    $result = $conn->query($check_email);
    if ($result->num_rows > 0) {
        $error_message = "Email already registered.";
    } else {
        // Insert company details into the database
        $sql = "INSERT INTO companies (name, email, password, phone, address, website, status)
                VALUES ('$name', '$email', '$hashed_password', '$phone', '$address', '$website', 'active')";
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['company_id'] = $conn->insert_id; // Store the new company's ID in session
            $_SESSION['company_name'] = $name; // Store the company name
            header("Location: company_dashboard.php"); // Redirect to the dashboard after registration
            exit();
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Company Registration</h2>
    
    <!-- Show error message if any -->
    <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

    <form action="company_register.php" method="POST" class="border p-4 rounded shadow-sm">
        <!-- Company Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Company Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter company name" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter company email" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter company phone number" required>
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter company address">
        </div>

        <!-- Website -->
        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="text" class="form-control" id="website" name="website" placeholder="Enter company website">
        </div>

        <!-- Submit Button -->
        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
    </form>
    <div class="mt-3 text-center">
        <p>Already have an account? <a href="company_login.php">Login here</a></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

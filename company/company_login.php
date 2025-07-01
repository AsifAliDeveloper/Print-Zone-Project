<?php
// Start the session
session_start();

// Include the database connection
include('db.php'); // Include your database connection file

// Check if the user is already logged in, redirect to dashboard
if (isset($_SESSION['company_id'])) {
    header("Location: company_dashboard.php");
    exit();
}

// Handle login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Get form data
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Check if email exists
    $sql = "SELECT * FROM companies WHERE email = '$email' AND status = 'active'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the company record
        $company = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $company['password'])) {
            // Password is correct, set session variables
            $_SESSION['company_id'] = $company['id'];
            $_SESSION['company_name'] = $company['name'];
            header("Location: company_dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            // Incorrect password
            $error_message = "Invalid email or password.";
        }
    } else {
        // No user found with that email
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Company Login</h2>

    <!-- Show error message if any -->
    <?php if (isset($error_message)) { ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php } ?>

    <form action="company_login.php" method="POST" class="border p-4 rounded shadow-sm">
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

        <!-- Submit Button -->
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    </form>
    <div class="mt-3 text-center">
        <p>Don't have an account? <a href="company_register.php">Register here</a></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

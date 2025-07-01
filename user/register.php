<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    
    // Include the database connection
    include 'db.php';

    // Sanitize inputs
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validate email and password
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif ($password !== $password_confirm) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $email_check_query = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($email_check_query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Email is already registered. Please login.";
        } else {
            // Insert new user
            $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param('sss', $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $success_message = "Registration successful! Redirecting to login...";
                echo "<script>setTimeout(function() { window.location.href = 'login.php'; }, 2000);</script>";
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Print Zone</title>
    <!-- Logo Icon -->
    <link rel="icon" href="images/logo.png" type="image/icon type">
    <!-- User Panel -->
    <link rel="stylesheet" href="style.css"> <!-- User-specific CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php endif; ?>
                        <form action="register.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php">Already registered? Login here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

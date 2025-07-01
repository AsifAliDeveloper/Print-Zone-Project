<?php
// Database Connection
include('db.php');

// Fetch notifications
$notificationsQuery = "SELECT COUNT(*) as unread_count FROM notifications WHERE status = 'unread'";
$notificationsResult = $conn->query($notificationsQuery);
$unreadNotifications = $notificationsResult->fetch_assoc()['unread_count'] ?? 0;

// Fetch user profile (assuming a user is logged in with ID 1)
/*$userQuery = "SELECT name, profile_pic FROM users WHERE id = 1";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
        </a>

        <!-- Toggle Button for Mobile View -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Navigation Links -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                </li>
            </ul>

            <!-- Search Bar -->
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <!-- Notifications -->
            <a href="#" class="btn btn-outline-primary position-relative mx-3">
                <i class="bi bi-bell"></i> <!-- Bootstrap Icons -->
                <?php if ($unreadNotifications > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= $unreadNotifications ?>
                </span>
                <?php endif; ?>
            </a>

            <!-- Profile Dropdown -->
            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= $user['profile_pic'] ?? 'default-profile.png' ?>" alt="Profile" width="30" height="30" class="rounded-circle">
                    <?= htmlspecialchars($user['name'] ?? 'User') ?>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="#">My Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Log Out</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

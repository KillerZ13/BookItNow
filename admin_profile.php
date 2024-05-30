<?php
include 'includes/functions.php';

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

// Admin-specific actions or details can be added here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<header>
    <div class="container">
        <div id="branding">
            <h1>Hotel Booking</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="admin_profile.php">Admin Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<section id="main">
    <div class="container">
        <h2>Welcome Admin!</h2>
        <!-- Admin-specific content goes here -->
    </div>
</section>
</body>
</html>

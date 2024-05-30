<?php
include 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hotel Booking</title>
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
                <?php if(isLoggedIn()): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="signup.php">Signup</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<section id="showcase">
    <div class="container">
        <h1>Welcome to Hotel Booking</h1>
        <p>Book your stay at the best hotels around the world</p>
    </div>
</section>
</body>
</html>

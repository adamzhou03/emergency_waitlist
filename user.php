<?php require 'user_logic.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="user_scripts.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION["patient_name"]); ?>!</h1>
    <p>Your code is: <?php echo htmlspecialchars($_SESSION["code"]); ?></p>
    <p>Your place in queue is: <?php echo htmlspecialchars($_SESSION["queue_number"]); ?></p>
    <p>Estimated Wait Time: <?php echo htmlspecialchars($_SESSION["est_wait_time"]); ?></p>
    <p id="user_titles">This is the user dashboard.</p>
    <a href="user_logout.php">Logout</a>
</body>
</html>
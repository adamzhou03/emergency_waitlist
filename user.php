<?php require 'user_logic.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="user_scripts.js"></script>
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION["patient_name"]); ?>!</h1>
    <p>Your code is: <?php echo htmlspecialchars($_SESSION["code"]); ?></p>
    <p>This is the user dashboard.</p>
    <a href="user_logout.php">Logout</a>
</body>
</html>
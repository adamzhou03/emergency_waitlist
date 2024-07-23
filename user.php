<?php
session_start();

// Check if the user is logged in, if not then redirect them to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: user_login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION["patient_name"]); ?>!</h1>
    <p>This is the user dashboard.</p>
    <a href="user_logout.php">Logout</a>
</body>
</html>
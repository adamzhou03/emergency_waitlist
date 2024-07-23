<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "hospital_triage";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    // Verify password
    if ($stmt->num_rows == 1 && password_verify($password, $hashed_password)) {
        // Password is correct, start a new session
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["username"] = $username;

        // Redirect to admin dashboard
        header("location: admin.php");
    } else {
        // Display an error message if username or password is invalid
        echo "The username or password you entered was not valid.";
    }

    $stmt->close();
}

$conn->close();
?>
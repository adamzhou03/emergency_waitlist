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
    $user_name = $_POST['user_name'];
    $code = $_POST['code'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT user_name, code, patient_id FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_name, $db_code, $patient_id);
    $stmt->fetch();

    // Verify password
    if ($stmt->num_rows == 1 && (strcmp($code, db_code))) {
        // Password is correct, start a new session
        $_SESSION["loggedin"] = true;
        $_SESSION["patient_id"] = $patient_id;
        $_SESSION["user_name"] = $patient_name;

        // Redirect to user dashboard
        header("location: user_dashboard.php");
    } else {
        // Display an error message if username or password is invalid
        echo "The username or code you entered was not valid.";
    }

    $stmt->close();
}

$conn->close();
?>
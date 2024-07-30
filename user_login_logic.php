<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable( __DIR__ );
$dotenv->load();
session_start();

// Database connection
$db_host = $_ENV[ 'DB_HOST' ];
$db_user = $_ENV[ 'DB_USER' ];
$db_password = $_ENV[ 'DB_PASSWORD' ];
$db_name = 'hospital_triage';

$conn = new mysqli( $db_host, $db_user, $db_password, $db_name );

// Check connection
if ( $conn->connect_error ) {
    die( 'Connection failed: ' . $conn->connect_error );
}

// Login logic
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    if ( isset( $_POST[ 'user_name' ] ) && isset( $_POST[ 'code' ] )) {
        $user_name = $_POST[ 'user_name' ];
        $code = $_POST[ 'code' ];

        // Prepare and bind
        $stmt = $conn->prepare( 'SELECT patient_name, code, patient_id, queue_number FROM patients WHERE patient_name = ?' );
        $stmt->bind_param( 's', $user_name );
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result( $patient_name, $db_code, $patient_id, $queue_number );
        echo $patient_name;
        echo $patient_id;
        echo $db_code;
        echo $queue_number;
        $stmt->fetch();
        $wait_time = strval($queue_number * 15);
        $wait_time .= " mins";

        // Verify password
        if ( $stmt->num_rows == 1 && $code == $db_code ) {
            // Password is correct, start a new session
            $_SESSION[ 'loggedin' ] = true;
            $_SESSION[ 'patient_name' ] = $patient_name;
            $_SESSION[ 'code' ] = $code;
            $_SESSION[ 'patient_id' ] = $patient_id;
            $_SESSION[ 'queue_number' ] = $queue_number;
            $_SESSION[ 'est_wait_time' ] = $wait_time;

            // Redirect to user dashboard
            header( 'location: user.php' );
        } else {
            // Display an error message if username or password is invalid
            echo 'The username or code you entered was not valid.';
        }

        $stmt->close();
    }

}



$conn->close();
?>
<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;

// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
session_start();

$db_host = $_ENV['DB_HOST'];
$db_user = $_ENV['DB_USER'];
$db_password = $_ENV['DB_PASSWORD'];
$db_name = "hospital_triage";

// Check if the user is logged in, if not then redirect them to the login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: admin_login.php");
    exit;
}

if (isset($_REQUEST[ 'action' ])) {
    if ($_REQUEST[ 'action' ] == 'getPatients') {
        getPatients();
    } else if ($_REQUEST[ 'action' ] == 'removePatient') {
        removePatient($_REQUEST['patient_id']);
    } else if ($_REQUEST[ 'action' ] == 'addPatient') {
        addPatient($_REQUEST[ 'patient_name' ], $_REQUEST[ 'severity_level' ], $_REQUEST[ 'time_of_arrival' ]);
    }

}
function getPatients() {
    global $db_host, $db_user, $db_password, $db_name;
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT patient_id, patient_name, severity_level, time_of_arrival, code FROM patients");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($patient_id, $patient_name, $severity_level, $time_of_arrival, $code);
    
    while ($stmt->fetch()) {
        $response[] = array(
            'patient_id' => $patient_id,
            'patient_name' => $patient_name,
            'severity_level' => $severity_level,
            'time_of_arrival' => $time_of_arrival,
            'code' => $code
        );
    }
    echo json_encode( $response );

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    exit;



}

function addPatient($patient_name, $severity_level, $time_of_arrival) {
    global $db_host, $db_user, $db_password, $db_name;
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO patients (patient_name, 
    severity_level, time_of_arrival) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $patient_name, $severity_level, $time_of_arrival);  
    $stmt->execute();  
    $stmt->close(); 
    $stmt = $conn->prepare("CALL update_queue_numbers();");
    $stmt->execute();  
    $conn->close();

    $response = $patient_id;
    echo $response;
    exit;
}

function removePatient($patient_id) {
    global $db_host, $db_user, $db_password, $db_name;
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("DELETE FROM patients WHERE patient_id = ?");
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $stmt->close();
    $stmt = $conn->prepare("CALL update_queue_numbers();");
    $stmt->execute();
    $conn->close();
    echo $response = $patient_id;
    exit;
}
?>
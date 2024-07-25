<?php include 'admin_logic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="admin_scripts.js"></script>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    <p id="admin_titles">This is the admin dashboard.</p>
    <a href="admin_logout.php">Logout</a>
    <table id="patient_table">
    <th>
        Patient Name
    </th>
    <th>
        Severity Level
    </th>
    <th>
        Time of Arrival
    </th>
    <th>
        Code
    </th>
    <th>
        Time in Queue
    </th>
</table>

<form id='patientForm'>
        <div>
            <br>
            <p id="admin_titles">Patient Form</p>
        </div>
        <div>
            <label for="patient_name">Patient Name:</label>
            <input type="text" id="patient_name" name="patient_name" required>
        </div>
        <div>
            <label for="severity_level">Severity Level:</label>
            <select id="severity_level" name="severity_level" required>
                <option value="" disabled selected>Select a level</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </div>
        <div>
            <br>
            <button type="submit">Submit</button>
        </div>

<form>
</body>
</html>
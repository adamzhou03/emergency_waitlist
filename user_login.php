
<?php include 'user_login_logic.php' ?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8'>
<title>User Login</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>User Login</h2>
<form action = 'user_login.php' method = 'post'>
<label for = 'name'>Name:</label>
<input type = 'text' id = 'user_name' name = 'user_name' required><br><br>
<label for = 'code'>Code:</label>
<input type = 'text' id = 'code' name = 'code' required><br><br>
<input type = 'submit' value = 'Login'>
</form>
</body>
</html>
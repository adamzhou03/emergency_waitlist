# emergency_waitlist
Repository for CSI 3140 Assignment 4 - Group 39

Student Name 1: Adam Zhou Student Number 1: 300244610

Student Name 2: Bryson Crooks Student Number 2: 300136193

To set up locally:
The file index.php contains the main page for the hospital triage application. To set up and run the application a local apache server must be running (with an application such as xampp) as well as a MySql server running with the .sql file found in the "database" directory of this repository imported through phpmyadmin.

Functionality:
The home page "index.php" leads to either the admin login page or the user login page. The admin/hospital staff may login with the creditials username: "admin" and password: "admin". Users/patients may login by providing their name and their given code, which is created when they are added to the triage.
After an admin logs in they are taken to the main admin page where they are able to see the full list of patients in the queue, add and remove patients from the queue, and logout.
After a user logs in they are taken to the main user page where they are able to see their code and place in the queue, and logout. 

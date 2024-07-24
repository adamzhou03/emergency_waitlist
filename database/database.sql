CREATE DATABASE hospital_triage;
USE hospital_triage;

CREATE TABLE patients (
    patient_id int AUTO_INCREMENT,
    patient_name VARCHAR(100) NOT NULL,
    severity_level INT NOT NULL CHECK (severity_level BETWEEN 1 AND 10),
    time_of_arrival DATETIME NOT NULL,
    code VARCHAR(3) NOT NULL CHECK (CHAR_LENGTH(code) = 3),
    PRIMARY KEY (patient_id)
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password) VALUES ('admin', 'admin');

INSERT INTO patients (patient_name, severity_level, time_of_arrival, code) 
VALUES ('user1', '1', '2024-07-23 14:30:00', 'aaa');

INSERT INTO patients (patient_name, severity_level, time_of_arrival, code) 
VALUES ('user2', '3', '2024-07-22 14:30:00', 'bbb');

INSERT INTO patients (patient_name, severity_level, time_of_arrival, code) 
VALUES ('user3', '5', '2024-07-20 14:30:00', 'ccc');

INSERT INTO patients (patient_name, severity_level, time_of_arrival, code) 
VALUES ('user4', '7', '2024-07-21 14:30:00', 'ddd');

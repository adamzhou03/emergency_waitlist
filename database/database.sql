-- Create the database and use it
CREATE DATABASE hospital_triage;
USE hospital_triage;

-- Create the patients table
CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(100) NOT NULL,
    severity_level INT NOT NULL CHECK (severity_level BETWEEN 1 AND 10),
    time_of_arrival DATETIME NOT NULL,
    code CHAR(3) NOT NULL,
    queue_number INT
);

-- Create the admins table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Create the RandString function
DELIMITER $$

CREATE FUNCTION RandString(length SMALLINT) 
RETURNS CHAR(255) CHARSET utf8
BEGIN
    DECLARE returnStr CHAR(255) DEFAULT '';
    DECLARE allowedChars CHAR(26) DEFAULT 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    DECLARE i INT DEFAULT 0;

    WHILE (i < length) DO
        SET returnStr = CONCAT(returnStr, SUBSTRING(allowedChars, FLOOR(RAND() * LENGTH(allowedChars) + 1), 1));
        SET i = i + 1;
    END WHILE;

    RETURN returnStr;
END$$

DELIMITER ;

-- Create the update_queue_numbers stored procedure
DELIMITER $$

CREATE PROCEDURE update_queue_numbers()
BEGIN
    UPDATE patients p
    JOIN (
        SELECT 
            patient_id,
            @row_number := @row_number + 1 AS queue_number
        FROM (
            SELECT patient_id
            FROM patients
            ORDER BY severity_level DESC, time_of_arrival ASC
        ) AS sorted_patients
        JOIN (SELECT @row_number := 0) AS r
    ) AS ranked_patients
    ON p.patient_id = ranked_patients.patient_id
    SET p.queue_number = ranked_patients.queue_number;
END$$

DELIMITER ;

-- Create the before insert trigger for code generation
DELIMITER $$

CREATE TRIGGER Patient_beforeInsert_code
BEFORE INSERT ON patients
FOR EACH ROW
BEGIN
    DECLARE code_exists INT;
    DECLARE new_code CHAR(3);

    REPEAT
        SET new_code = RandString(3);
        SELECT COUNT(*) INTO code_exists FROM patients WHERE code = new_code;
    UNTIL code_exists = 0 END REPEAT;

    SET NEW.code = new_code;
END$$

DELIMITER ;

-- Insert an admin for testing
INSERT INTO admins (username, password) VALUES ('admin', 'admin');

-- Insert sample patients
INSERT INTO patients (patient_name, severity_level, time_of_arrival) 
VALUES ('user1', 1, '2024-07-23 14:30:00');

INSERT INTO patients (patient_name, severity_level, time_of_arrival) 
VALUES ('user2', 3, '2024-07-22 14:30:00');

INSERT INTO patients (patient_name, severity_level, time_of_arrival) 
VALUES ('user3', 5, '2024-07-20 14:30:00');

INSERT INTO patients (patient_name, severity_level, time_of_arrival) 
VALUES ('user4', 7, '2024-07-21 14:30:00');

CALL update_queue_numbers();

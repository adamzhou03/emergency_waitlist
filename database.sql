CREATE DATABASE hospital_triage;
USE hospital_triage;

CREATE TABLE patients (
    patient_id int AUTO_INCREMENT,
    patient_name VARCHAR(100) NOT NULL,
    severity_level INT NOT NULL CHECK (severity_level BETWEEN 1 AND 10),
    time_of_arrival DATETIME NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE users (
    patient_id INT,
    patient_name VARCHAR(255),
    code VARCHAR(3) NOT NULL UNIQUE CHECK (CHAR_LENGTH(code) = 3),
    
    PRIMARY KEY (patient_id),
    FOREIGN KEY (patient_id) 
        REFERENCES patients(patient_id)
        ON DELETE CASCADE,
    FOREIGN KEY (patient_name)
        REFERENCES patients(patient_name)
)

CREATE PROCEDURE generate_unique_code(OUT new_code VARCHAR(3))
BEGIN
    DECLARE chars CHAR(26) DEFAULT 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    DECLARE i INT DEFAULT 0;
    DECLARE is_unique BOOLEAN DEFAULT FALSE;
    DECLARE random_code VARCHAR(3);

    WHILE NOT is_unique DO
        SET random_code = CONCAT(
            SUBSTRING(chars, FLOOR(1 + (RAND() * 26)), 1),
            SUBSTRING(chars, FLOOR(1 + (RAND() * 26)), 1),
            SUBSTRING(chars, FLOOR(1 + (RAND() * 26)), 1)
        );

        SET i = (SELECT COUNT(*) FROM users WHERE code = random_code);
        IF i = 0 THEN
            SET is_unique = TRUE;
        END IF;
    END WHILE;

    SET new_code = random_code;
END;

CREATE TRIGGER before_insert_users
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
    DECLARE new_code VARCHAR(3);
    CALL generate_unique_code(new_code);
    SET NEW.code = new_code;
END;




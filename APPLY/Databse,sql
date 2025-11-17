CREATE DATABASE IF NOT EXISTS divine_university;
USE divine_university;

CREATE TABLE IF NOT EXISTS applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    applicant_id INT NOT NULL,
    program VARCHAR(100) NOT NULL,
    qualifications TEXT NOT NULL,
    certificate VARCHAR(255),
    status ENUM('Pending','Reviewed','Accepted','Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (applicant_id) REFERENCES applicants(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password) VALUES ('admin', SHA2('admin123', 256));

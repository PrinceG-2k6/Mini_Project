CREATE DATABASE IF NOT EXISTS SeatingPlan;
USE SeatingPlan;

-- Users Table (Admin & Student)
CREATE TABLE users (
  id  VARCHAR(10) UNIQUE,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin', 'student') NOT NULL

);


CREATE Table admin(
  id INT AUTO_INCREMENT PRIMARY KEY,
  admin_id VARCHAR(20) UNIQUE,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Rooms Table
CREATE TABLE rooms (
  room_no VARCHAR(10) PRIMARY KEY,
  num_rows INT NOT NULL,
  columns INT NOT NULL,
  total_benches INT,
  auth_id VARCHAR(10),
  FOREIGN KEY (auth_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE subjects(
  id INT AUTO_INCREMENT PRIMARY KEY,
  semester INT,
  branch VARCHAR(100),
  subject VARCHAR(100),
  UNIQUE (semester , branch ,subject)
);


-- Seating Plan Table
CREATE TABLE seating_plans_left (
  id INT AUTO_INCREMENT PRIMARY KEY,
  Exam_date DATE ,
  shift ENUM('Morning', 'Evening') ,
  branch VARCHAR(100),
  semester INT,
  room_no VARCHAR(10),
  bench_no INT, 
  left_roll_no VARCHAR(20),   
  FOREIGN KEY (room_no) REFERENCES rooms(room_no)
);
CREATE TABLE seating_plans_right (
  id INT AUTO_INCREMENT PRIMARY KEY,
  Exam_date DATE ,
  shift ENUM('Morning', 'Evening') ,
  branch VARCHAR(100),
  semester INT,
  room_no VARCHAR(10),
  bench_no INT,
  right_roll_no VARCHAR(20),  
  FOREIGN KEY (room_no) REFERENCES rooms(room_no)
);


CREATE TABLE IF NOT EXISTS exam_timetable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Exam_date DATE,
    shift ENUM('Morning', 'Evening'),
    branch VARCHAR(100),
    subject VARCHAR(100),
    start_time TIME,
    end_time TIME,
    semester INT
);

-- Insert default admin
INSERT INTO users (id, name, email, password, role)
VALUES ('ADMIN001', 'Prince', 'admin@example.com', 'admin123', 'admin');
Insert INTO admin (admin_id,name,email)
VALUES('ADMIN001', 'Prince', 'admin@example.com');

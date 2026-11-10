CREATE DATABASE IF NOT EXISTS db_course;
USE db_course;

DROP TABLE IF EXISTS enrollments;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS instructors;

CREATE TABLE instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    expertise VARCHAR(100) NOT NULL
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    credits INT NOT NULL DEFAULT 3,
    instructor_id INT NOT NULL,
    FOREIGN KEY (instructor_id) REFERENCES instructors(id) ON DELETE RESTRICT
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    status ENUM('active','completed','dropped') NOT NULL DEFAULT 'active',
    grade DECIMAL(5,2) NULL,
    enrolled_at DATE NOT NULL,
    UNIQUE KEY uq_student_course (student_id, course_id),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

INSERT INTO instructors (name, email, expertise) VALUES
('Dr. Budi Santoso', 'budi@kampus.ac.id', 'Pemrograman Web'),
('Siti Rahma, M.Kom', 'siti@kampus.ac.id', 'Basis Data'),
('Andi Pratama, M.T', 'andi@kampus.ac.id', 'Algoritma');

INSERT INTO students (nim, name, email) VALUES
('2400001', 'Rina Aulia', 'rina@student.ac.id'),
('2400002', 'Dimas Putra', 'dimas@student.ac.id'),
('2400003', 'Salsa Nabila', 'salsa@student.ac.id');

INSERT INTO courses (code, name, credits, instructor_id) VALUES
('IF101', 'Pemrograman Web', 3, 1),
('IF102', 'Basis Data', 3, 2),
('IF103', 'Struktur Data dan Algoritma', 4, 3);

INSERT INTO enrollments (student_id, course_id, status, grade, enrolled_at) VALUES
(1, 1, 'active', NULL, '2026-09-01'),
(1, 2, 'completed', 88.50, '2026-02-01'),
(2, 1, 'active', NULL, '2026-09-01'),
(3, 3, 'dropped', NULL, '2026-09-02');

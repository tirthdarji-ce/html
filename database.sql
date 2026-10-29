CREATE DATABASE IF NOT EXISTS studenthub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE studenthub;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  mobile VARCHAR(10) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('student','admin') NOT NULL DEFAULT 'student',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS students (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL UNIQUE,
  course VARCHAR(100) NOT NULL,
  year_level VARCHAR(30) NOT NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  CONSTRAINT fk_students_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS events (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  category ENUM('Technical','Cultural','Sports') NOT NULL,
  event_date DATE NOT NULL,
  description TEXT NOT NULL,
  poster_path VARCHAR(255) NULL,
  created_by INT UNSIGNED NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_events_creator FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS registrations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id INT UNSIGNED NOT NULL,
  event_id INT UNSIGNED NOT NULL,
  registered_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_student_event(student_id,event_id),
  CONSTRAINT fk_reg_student FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE,
  CONSTRAINT fk_reg_event FOREIGN KEY(event_id) REFERENCES events(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS audit_logs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NULL,
  action VARCHAR(80) NOT NULL,
  details TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_audit_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO events(title,category,event_date,description) VALUES
('Web Development Workshop','Technical','2026-11-12','Practice HTML, CSS, and JavaScript.'),
('Cultural Fest','Cultural','2026-11-22','Student performances and activities.'),
('Sports Tournament','Sports','2026-11-27','Friendly campus competitions.');

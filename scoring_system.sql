
-- Database schema for Scoring System
CREATE DATABASE IF NOT EXISTS scoring_system;
USE scoring_system;

-- Judges table with password field
CREATE TABLE judges (
    judge_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- For storing hashed passwords
    display_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin table
CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- For storing hashed passwords
    display_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users (participants) table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Scores table
CREATE TABLE scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    judge_id INT NOT NULL,
    user_id INT NOT NULL,
    points INT NOT NULL CHECK (points BETWEEN 1 AND 100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (judge_id) REFERENCES judges(judge_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Insert sample data with hashed passwords (password is 'password123')
INSERT INTO admins (username, password, display_name) VALUES
('admin', '$2y$10$8WxmVFNL5gIy9yVJpRUEAu0qOv4xw0Ry0Q9XGRQwQW0zO.jRzJUFe', 'System Admin');

INSERT INTO judges (username, password, display_name) VALUES
('judge1', '$2y$10$8WxmVFNL5gIy9yVJpRUEAu0qOv4xw0Ry0Q9XGRQwQW0zO.jRzJUFe', 'Judge One'),
('judge2', '$2y$10$8WxmVFNL5gIy9yVJpRUEAu0qOv4xw0Ry0Q9XGRQwQW0zO.jRzJUFe', 'Judge Two');

INSERT INTO users (username, display_name) VALUES
('user1', 'Participant One'),
('user2', 'Participant Two'),
('user3', 'Participant Three');

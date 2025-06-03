CREATE DATABASE IF NOT EXISTS bookworm2;
USE bookworm2;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    author VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,
    type ENUM('share', 'want') NOT NULL,
    publisher VARCHAR(100),
    year_published INT,
    binding VARCHAR(50),
    condition_desc TEXT,
    status ENUM('На рассмотрении', 'Опубликована', 'Отклонена', 'Архив') DEFAULT 'На рассмотрении',
    rejection_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

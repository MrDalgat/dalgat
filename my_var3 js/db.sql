CREATE DATABASE IF NOT EXISTS gruzovozoff2;
USE gruzovozoff2;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date_time DATETIME NOT NULL,
    weight VARCHAR(50) NOT NULL,
    dimensions VARCHAR(100) NOT NULL,
    cargo_type VARCHAR(50) NOT NULL,
    from_address TEXT NOT NULL,
    to_address TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'Новая',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL,
    user_id INT NOT NULL,
    review_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES requests(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

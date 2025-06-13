
CREATE DATABASE IF NOT EXISTS veras_cafe;
USE veras_cafe;

CREATE TABLE IF NOT EXISTS foods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price INT NOT NULL,
    kategori ENUM('makanan', 'minuman') NOT NULL,
    image VARCHAR(255)
);

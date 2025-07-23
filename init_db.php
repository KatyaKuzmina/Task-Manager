<?php
$host = 'localhost';
$dbname = 'task_manager';
$user = 'root';
$pass = '';

try {
	$pdo = new PDO("mysql:host=$host", $user, $pass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

	echo "Database '$dbname' created or already exists.<br>";

	$pdo->exec("USE `$dbname`");

	$pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");

	$pdo->exec("
        CREATE TABLE IF NOT EXISTS tasks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            tag VARCHAR(100),
            description TEXT,
            date_started DATE,
            date_till DATE,
            color VARCHAR(20),
            progress ENUM('upcoming', 'in-progress', 'done') DEFAULT 'upcoming',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;
    ");


} catch (PDOException $e) {
	die("Database error: " . $e->getMessage());
}

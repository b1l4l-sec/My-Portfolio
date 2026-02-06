-- Bilal Lbien Portfolio Database Schema
-- Compatible with MySQL 5.7+ and InfinityFree hosting

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `if0_41055255_portfolio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `if0_41055255_portfolio`;

-- Admin Users Table
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (password: bilal0606411104)
-- Password hash generated with: password_hash('bilal0606411104', PASSWORD_DEFAULT)
INSERT INTO `admin_users` (`username`, `password`, `email`) VALUES
('admin', '$2y$10$CS5W64H5Q/1IqmpT.KIif..XkYdmCJI0qRs/j9oBMg5Pik8T4GA0S', 'admin@bilallbien.com');

-- Skills Table
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `proficiency` int(11) NOT NULL DEFAULT 80,
  `icon_class` varchar(50) DEFAULT NULL,
  `order_position` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Skills Data
INSERT INTO `skills` (`name`, `category`, `proficiency`, `icon_class`, `order_position`) VALUES
('Kali Linux', 'Cybersecurity', 95, 'security', 1),
('Red Team Operations', 'Cybersecurity', 90, 'shield', 2),
('Penetration Testing', 'Cybersecurity', 92, 'bug', 3),
('React.js', 'Frontend', 88, 'code', 4),
('Laravel', 'Backend', 85, 'server', 5),
('PHP', 'Backend', 90, 'code', 6),
('Arduino/PyFirmata', 'IoT', 87, 'microchip', 7),
('Blender 3D', '3D Modeling', 83, 'cube', 8),
('MySQL', 'Database', 86, 'database', 9),
('Git & GitHub', 'DevOps', 89, 'git', 10);

-- Certificates Table
CREATE TABLE IF NOT EXISTS `certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `issuer` varchar(150) NOT NULL,
  `issue_date` date NOT NULL,
  `credential_id` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT 'General',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Certificates Data
INSERT INTO `certificates` (`title`, `issuer`, `issue_date`, `credential_id`, `category`) VALUES
('Certified Ethical Hacker (CEH)', 'EC-Council', '2024-01-15', 'CEH-2024-001', 'Cybersecurity'),
('Red Team Professional', 'INE Security', '2023-11-20', 'RTP-2023-456', 'Cybersecurity'),
('Laravel Advanced Development', 'Udemy', '2023-08-10', 'UC-LARAVEL-789', 'Backend'),
('React Expert Certification', 'Frontend Masters', '2024-03-05', 'FEM-REACT-321', 'Frontend'),
('IoT Security Specialist', 'Coursera', '2023-06-12', 'IOTSEC-654', 'IoT');

-- Messages/Contact Table
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `found_via` varchar(50) DEFAULT NULL,
  `status` enum('unread','read','archived') DEFAULT 'unread',
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Projects Table
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `technologies` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `demo_url` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `order_position` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Projects Data
INSERT INTO `projects` (`title`, `description`, `technologies`, `github_url`, `featured`, `order_position`) VALUES
('TheZero - Kali Linux Distribution', 'Custom Kali Linux distribution optimized for advanced penetration testing and red team operations. Features custom tools and automated workflows.', 'Kali Linux, Bash, Python, Security Tools', 'https://github.com/b1l4l/thezero', 1, 1),
('IoT Security Scanner', 'Automated vulnerability scanner for IoT devices using Arduino and PyFirmata. Detects common security flaws in smart home devices.', 'Python, Arduino, PyFirmata, Security', 'https://github.com/b1l4l/iot-scanner', 1, 2),
('3D Asset Library', 'Professional 3D model library created with Blender. Includes game-ready assets and architectural visualizations.', 'Blender 3D, UV Mapping, PBR Texturing', NULL, 0, 3);

-- Sessions Table (for security)
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `payload` text,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

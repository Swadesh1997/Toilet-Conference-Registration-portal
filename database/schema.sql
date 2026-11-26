-- =====================================================================
-- Toilet Conference 2025: registration and attendee management system
-- Database schema (MySQL / MariaDB)
--
-- `schedule` and `tasks` are taken from the original database export.
-- The other tables are reconstructed from the queries in the PHP code,
-- so column types are best estimates. No real attendee data is included.
-- =====================================================================

SET NAMES utf8mb4;

-- Delegate accounts (login for the registration site)
CREATE TABLE `users` (
  `user_id`      INT AUTO_INCREMENT PRIMARY KEY,
  `email`        VARCHAR(255) NOT NULL UNIQUE,
  `password`     VARCHAR(255) NOT NULL,          -- password_hash()
  `unique_id`    VARCHAR(64)  NOT NULL UNIQUE,   -- used in QR codes and email links
  `email_status` TINYINT      NOT NULL DEFAULT 0,-- 1 = email verified
  `inserted_at`  DATETIME     NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Delegate profile collected in the multi-step registration form
CREATE TABLE `ticket_data` (
  `ticket_id`       INT AUTO_INCREMENT PRIMARY KEY,
  `user_id`         INT NOT NULL,
  `unique_id`       VARCHAR(64),
  `title`           VARCHAR(20),
  `first_name`      VARCHAR(150),
  `surname`         VARCHAR(150),
  `official_email`  VARCHAR(255),
  `phone`           VARCHAR(50),
  `gender`          VARCHAR(30),
  `birth_year`      VARCHAR(10),
  `city`            VARCHAR(150),
  `nationality`     VARCHAR(100),
  `organization`    VARCHAR(255),
  `designation`     VARCHAR(255),
  `language`        VARCHAR(100),
  `dietary`         VARCHAR(255),
  `accessibility`   VARCHAR(255),
  `tours`           VARCHAR(255),
  `notification`    VARCHAR(50),
  `student`         TINYINT DEFAULT 0,
  `student_file`    VARCHAR(255),   -- path to uploaded student ID
  `passport_no`     VARCHAR(50),
  `issue_date`      VARCHAR(20),
  `expire_date`     VARCHAR(20),
  `passport_file`   VARCHAR(255),   -- path to uploaded passport scan
  `visa_invitation` TINYINT DEFAULT 0,
  `payment_status`  TINYINT DEFAULT 0,
  `status`          TINYINT DEFAULT 0,
  `inserted_at`     DATETIME,
  `updated_at`      DATETIME,
  KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Invoices for registration fees and optional tours
CREATE TABLE `invoice_data` (
  `invoice_id`        INT AUTO_INCREMENT PRIMARY KEY,
  `invoice_no`        VARCHAR(50) NOT NULL,
  `user_id`           INT NOT NULL,
  `items`             TEXT,
  `price`             DECIMAL(10,2),
  `registratio_promo` VARCHAR(50),
  `tour_promo`        VARCHAR(50),
  `discount`          DECIMAL(10,2) DEFAULT 0,
  `tour_discount`     DECIMAL(10,2) DEFAULT 0,
  `grand_total`       DECIMAL(10,2),
  `payment_status`    TINYINT DEFAULT 0,  -- 0 pending, 1 paid
  `proof`             VARCHAR(255),       -- uploaded bank transfer proof
  `account_number`    VARCHAR(100),
  `visa_invitation`   TINYINT DEFAULT 0,
  `inserted_at`       DATETIME,
  `updated_at`        DATETIME,
  KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Online card / mobile payments returned by the SSLCommerz gateway
CREATE TABLE `transactions` (
  `id`                  INT AUTO_INCREMENT PRIMARY KEY,
  `transaction_id`      VARCHAR(100),
  `invoice_id`          INT,
  `paid_amount`         DECIMAL(10,2),
  `store_amount`        DECIMAL(10,2),
  `bank_transaction_id` VARCHAR(100),
  `card_type`           VARCHAR(100),
  `transaction_date`    DATETIME,
  `inserted_at`         DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `promo_code` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `code`        VARCHAR(50) NOT NULL,
  `discount`    DECIMAL(10,2) NOT NULL,
  `status`      TINYINT DEFAULT 1,
  `inserted_at` DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tour_code` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `code`        VARCHAR(50) NOT NULL,
  `discount`    DECIMAL(10,2) NOT NULL,
  `status`      TINYINT DEFAULT 1,
  `inserted_at` DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- QR code issued to each paid delegate
CREATE TABLE `user_qr` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `user_id`     INT NOT NULL,
  `unique_id`   VARCHAR(64) NOT NULL,
  `file`        VARCHAR(255),
  `inserted_at` DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Admin and volunteer accounts. type 0 = admin, other values = volunteer
CREATE TABLE `admin_login` (
  `admin_id`       INT AUTO_INCREMENT PRIMARY KEY,
  `admin_name`     VARCHAR(150),
  `admin_email`    VARCHAR(255) NOT NULL UNIQUE,
  `admin_password` VARCHAR(255) NOT NULL,
  `type`           TINYINT NOT NULL DEFAULT 1,
  `hall_id`        INT NULL,
  `allocated_hall` VARCHAR(150) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Zone access passes per delegate (VIP lounge, dining room, secretariat, halls)
CREATE TABLE `access_table` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `user_id`      INT NOT NULL UNIQUE,
  `status_one`   TINYINT DEFAULT 0,  -- VIP premium lounge
  `status_two`   TINYINT DEFAULT 0,  -- Amber dining room
  `status_three` TINYINT DEFAULT 0,  -- Conference secretariat room
  `status_four`  TINYINT DEFAULT 0,  -- Turag meeting hall
  `status_five`  TINYINT DEFAULT 0,  -- Extra zone 1
  `status_six`   TINYINT DEFAULT 0   -- Extra zone 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Conference sessions (from the original export)
CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `session_name` varchar(500) NOT NULL,
  `host_organization` varchar(500) NOT NULL,
  `modality` varchar(200) NOT NULL,
  `theme` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `capacity` varchar(500) NOT NULL,
  `date` varchar(500) NOT NULL,
  `time` varchar(500) NOT NULL,
  `title` varchar(500) NOT NULL,
  `venue` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `inserted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- QR scan log: entry ("in"), exit ("out") and meal/service use ("availed")
CREATE TABLE `attendent` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `schedule_id`   INT NOT NULL,
  `user_id`       INT NOT NULL,
  `volunteer_id`  INT NOT NULL,
  `schedule_type` VARCHAR(20) NOT NULL,
  `inserted_at`   DATETIME NOT NULL,
  KEY (`schedule_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volunteer tasks (from the original export)
CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `volunteer_id` int(11) NOT NULL,
  `task` text NOT NULL,
  `date` varchar(500) NOT NULL,
  `time` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `inserted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Push-style notices shown in the delegate and volunteer apps
CREATE TABLE `notifications` (
  `notification_id` INT AUTO_INCREMENT PRIMARY KEY,
  `notification`    TEXT NOT NULL,
  `noti_type`       TINYINT NOT NULL,  -- 1 delegates, 2 volunteers, 3 everyone
  `inserted_at`     DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `countries` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `country_name` VARCHAR(150) NOT NULL,
  `nationality` VARCHAR(150) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

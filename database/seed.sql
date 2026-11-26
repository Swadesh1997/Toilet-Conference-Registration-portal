-- Demo data only. Every name, email and code below is made up.

-- Admin login: admin@example.org / ChangeMe123!  (change it after first login)
INSERT INTO `admin_login` (`admin_name`, `admin_email`, `admin_password`, `type`)
VALUES ('Demo Admin', 'admin@example.org', '$2y$10$OW0ttjp2iIstTRU5vcrWCe3Evx5a.Zv3nlMkxuQNofDUnhjLjoExC', 0);

INSERT INTO `countries` (`country_name`, `nationality`) VALUES
('Bangladesh', 'Bangladeshi'),
('India', 'Indian'),
('Nepal', 'Nepalese'),
('United Kingdom', 'British');

INSERT INTO `promo_code` (`code`, `discount`, `status`, `inserted_at`) VALUES
('DEMO10', 10, 1, NOW());

INSERT INTO `schedule` (`session_name`, `host_organization`, `modality`, `theme`, `description`, `capacity`, `date`, `time`, `title`, `venue`, `status`, `inserted_at`, `updated_at`) VALUES
('Opening plenary', 'Demo Organisation', 'In person', 'Sanitation for all', 'Sample session for local testing.', '300', '2025-02-24', '09:00', 'Opening plenary', 'Main hall', 1, NOW(), NOW());

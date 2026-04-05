-- Fictional Seed Data for SafeTickets
-- All data is completely demonstration-only

-- Using $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi for 'password'

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `active`) VALUES
(1, 'Admin User', 'admin@safetickets.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1),
(2, 'Technician One', 'tech1@safetickets.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tecnico', 1),
(3, 'Corporate SubAdmin', 'subadmin@safetickets.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'subadmin', 1);

INSERT INTO `technicians` (`user_id`, `full_name`, `specialty`) VALUES
(2, 'John Doe Technician', 'Hardware & Network');

INSERT INTO `tickets` (`id`, `user_id`, `title`, `location`, `phone`, `remote_tool_id`, `description`, `technician_id`, `status`) VALUES
(1, 1, 'System Setup Support', 'HQ Office', '555-0100', '12345678', 'Need help configuring the new ticket system on all terminals.', 1, 'Em Atendimento'),
(2, 3, 'Network Printer Offline', 'Branch A', '555-0200', NULL, 'The main printer in the reception area is not responding to network requests.', NULL, 'Aberto');

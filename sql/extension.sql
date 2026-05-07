-- Add is_admin column to users table
ALTER TABLE `users` ADD `is_admin` TINYINT(1) DEFAULT 0;

-- Promote Super User to Admin
UPDATE `users` SET `is_admin` = 1 WHERE email = 'bjrajafju@gmail.com';

CREATE TABLE `reviews` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `product_id` INT(11) NOT NULL,
    `user_id` INT(11) DEFAULT NULL,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `rating` INT(1) NOT NULL,
    `comment` TEXT NOT NULL,
    `is_approved` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY (`id`),
    KEY `product_id` (`product_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
    CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `traduz` (`lang_code`, `code`, `text`) VALUES
('gb', 'detail.product.reviews_count_label', 'Reviews'),
('pt', 'detail.product.reviews_count_label', 'Avaliações'),
('gb', 'detail.reviews.reviews_for_title', 'reviews for'),
('pt', 'detail.reviews.reviews_for_title', 'avaliações para'),
('gb', 'detail.reviews.no_reviews', 'No reviews yet. Be the first to review this product!'),
('pt', 'detail.reviews.no_reviews', 'Ainda não há avaliações. Seja o primeiro a avaliar este produto!'),
('gb', 'detail.reviews.success_message', 'Your review has been submitted and is awaiting approval.'),
('pt', 'detail.reviews.success_message', 'A sua avaliação foi submetida e aguarda aprovação.'),
('gb', 'detail.reviews.error_missing_fields', 'Please fill all required fields and select a rating.'),
('pt', 'detail.reviews.error_missing_fields', 'Por favor, preencha todos os campos obrigatórios e selecione uma classificação.'),
('gb', 'detail.reviews.error_db_error', 'An error occurred while saving your review. Please try again.'),
('pt', 'detail.reviews.error_db_error', 'Ocorreu um erro ao guardar a sua avaliação. Por favor, tente novamente.'),
('gb', 'detail.reviews.logged_as', 'Logged in as'),
('pt', 'detail.reviews.logged_as', 'Sessão iniciada como');

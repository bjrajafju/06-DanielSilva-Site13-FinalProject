USE pi_db;

-- ========================
-- CATEGORIES
-- ========================
INSERT INTO categories (id, image) VALUES (1, 'img/cat-1.jpg'), (2, 'img/cat-2.jpg'), (3, 'img/cat-3.jpg'), (4, 'img/cat-4.jpg'), (5, 'img/cat-5.jpg'), (6, 'img/cat-6.jpg');

INSERT INTO category_translations (category_id, lang_code, name) VALUES
(1, 'gb', 'Men''s Clothes'),
(1, 'pt', 'Roupa de Homem'),
(2, 'gb', 'Womens'' Clothes'),
(2, 'pt', 'Roupa de Mulher'),
(3, 'gb', 'Child''s Clothes'),
(3, 'pt', 'Roupa de Criança'),
(4, 'gb', 'Accessories'),
(4, 'pt', 'Acessórios'),
(5, 'gb', 'Bags'),
(5, 'pt', 'Malas'),
(6, 'gb', 'Shoes'),
(6, 'pt', 'Sapatos');


-- ========================
-- PRODUCTS
-- ========================
INSERT INTO products (id, codProd, category_id, price, image) VALUES
(1, 'P001', 1, 29.99, 'img/product-1.jpg'),
(2, 'P002', 1, 34.99, 'img/product-2.jpg'),
(3, 'P003', 2, 59.99, 'img/product-3.jpg'),
(4, 'P004', 2, 79.99, 'img/product-4.jpg'),
(5, 'P005', 3, 19.99, 'img/product-5.jpg'),
(6, 'P006', 3, 14.99, 'img/product-6.jpg');


INSERT INTO product_translations 
(product_id, lang_code, title, slug, short_description, description, additional_info)
VALUES
(1, 'gb', 'Blue Casual Shirt', 'blue-casual-shirt', 'Casual blue shirt', 'Full description...', 'Cotton'),
(1, 'pt', 'Camisa Azul Casual', 'camisa-azul-casual', 'Camisa azul casual', 'Descrição completa...', 'Algodão'),

(2, 'gb', 'White Elegant Shirt', 'white-elegant-shirt', 'Elegant white shirt', 'Full description...', 'Slim fit'),
(2, 'pt', 'Camisa Branca Elegante', 'camisa-branca-elegante', 'Camisa branca elegante', 'Descrição completa...', 'Slim fit'),

(3, 'gb', 'Running Shoes', 'running-shoes', 'Lightweight shoes', 'Full description...', 'Sport'),
(3, 'pt', 'Ténis de Corrida', 'tenis-corrida', 'Ténis leves', 'Descrição completa...', 'Desporto'),

(4, 'gb', 'Leather Shoes', 'leather-shoes', 'Premium leather shoes', 'Full description...', 'Leather'),
(4, 'pt', 'Sapatos de Couro', 'sapatos-couro', 'Sapatos premium', 'Descrição completa...', 'Couro'),

(5, 'gb', 'Classic Watch', 'classic-watch', 'Minimal watch', 'Full description...', 'Water resistant'),
(5, 'pt', 'Relógio Clássico', 'relogio-classico', 'Relógio minimalista', 'Descrição completa...', 'Resistente à água'),

(6, 'gb', 'Sunglasses', 'sunglasses', 'Stylish sunglasses', 'Full description...', 'UV Protection'),
(6, 'pt', 'Óculos de Sol', 'oculos-sol', 'Óculos elegantes', 'Descrição completa...', 'Proteção UV');


-- ========================
-- SIZES
-- ========================
INSERT INTO sizes (id, name) VALUES
(1, 'XS'),
(2, 'S'),
(3, 'M'),
(4, 'L'),
(5, 'XL');


-- ========================
-- COLORS
-- ========================
INSERT INTO colors (id, hex) VALUES
(1, '#000000'),
(2, '#FFFFFF'),
(3, '#FF0000'),
(4, '#0000FF'),
(5, '#00FF00');

INSERT INTO color_translations (color_id, lang_code, name) VALUES
(1, 'gb', 'Black'),
(1, 'pt', 'Preto'),
(2, 'gb', 'White'),
(2, 'pt', 'Branco'),
(3, 'gb', 'Red'),
(3, 'pt', 'Vermelho'),
(4, 'gb', 'Blue'),
(4, 'pt', 'Azul'),
(5, 'gb', 'Green'),
(5, 'pt', 'Verde');


-- ========================
-- PRODUCT VARIANTS
-- ========================
INSERT INTO product_variants (product_id, size_id, color_id) VALUES
(1, 2, 4),
(1, 3, 4),
(2, 3, 2),
(3, 4, 1),
(4, 4, 1),
(5, 1, 3),
(6, 2, 5);


-- ========================
-- USERS
-- ========================
INSERT INTO users (id, first_name, last_name, email, password, mobile) VALUES
(1, 'John', 'Doe', 'john@example.com', '$2y$10$hash1', '912345678'),
(2, 'Maria', 'Silva', 'maria@example.com', '$2y$10$hash2', '934567890');


-- ========================
-- CARTS + ITEMS
-- ========================
INSERT INTO carts (id, user_id, session_id) VALUES
(1, 1, NULL),
(2, NULL, 'sess_abc123');

INSERT INTO cart_items (cart_id, variant_id, quantity) VALUES
(1, 8, 2),
(1, 9, 1),
(2, 8, 1);


-- ========================
-- COUNTRIES
-- ========================
INSERT INTO countries (id, code) VALUES
(1, 'PT'),
(2, 'GB'),
(3, 'ES');

INSERT INTO country_translations (country_id, lang_code, name) VALUES
(1, 'gb', 'Portugal'),
(1, 'pt', 'Portugal'),
(2, 'gb', 'United Kingdom'),
(2, 'pt', 'Reino Unido'),
(3, 'gb', 'Spain'),
(3, 'pt', 'Espanha');


-- ========================
-- ADDRESSES
-- ========================
INSERT INTO addresses 
(user_id, first_name, last_name, mobile, address_line1, address_line2, city, state, postal_code, country_id, type)
VALUES
(1, 'John', 'Doe', '912345678', 'Rua A 123', 'N123', 'Porto', 'Porto', '4000-000', 1, 'shipping'),
(1, 'John', 'Doe', '912345678', 'Rua A 123', 'N123', 'Porto', 'Porto', '4000-000', 1, 'billing');


-- ========================
-- PAYMENT METHODS
-- ========================
INSERT INTO payment_methods (id, code) VALUES
(1, 'mbway'),
(2, 'paypal'),
(3, 'card');

INSERT INTO payment_method_translations (payment_method_id, lang_code, name) VALUES
(1, 'gb', 'MB Way'),
(1, 'pt', 'MB Way'),
(2, 'gb', 'PayPal'),
(2, 'pt', 'PayPal'),
(3, 'gb', 'Credit Card'),
(3, 'pt', 'Cartão de Crédito');


-- ========================
-- ORDERS
-- ========================
INSERT INTO orders (id, user_id, payment_method_id, subtotal, shipping, total, status) VALUES
(1, 1, 1, 59.98, 5.00, 64.98, 'paid');


INSERT INTO order_items 
(order_id, product_id, variant_id, product_title, price, quantity)
VALUES
(1, 1, 1, 'Blue Casual Shirt', 29.99, 2);


INSERT INTO order_addresses
(order_id, type, first_name, last_name, mobile, address_line1, adress_line2, city, state, postal_code, country_name)
VALUES
(1, 'shipping', 'John', 'Doe', '912345678', 'Rua A 123', 'N123', 'Porto', 'Porto', '4000-000', 'Portugal'),
(1, 'billing', 'John', 'Doe', '912345678', 'Rua A 123', 'N123', 'Porto', 'Porto', '4000-000', 'Portugal');
-- 1. DROP PAGES TABLES
DROP TABLE IF EXISTS `page_translations`;

DROP TABLE IF EXISTS `pages`;

-- 2. Create News Table (KEEP)
CREATE TABLE
  IF NOT EXISTS `news` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `image` varchar(255) DEFAULT NULL,
    `is_active` tinyint (1) DEFAULT 1,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 3. Create News Translations Table (KEEP)
CREATE TABLE
  IF NOT EXISTS `news_translations` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `news_id` int (11) NOT NULL,
    `lang_code` varchar(5) NOT NULL,
    `title` varchar(255) NOT NULL,
    `slug` varchar(255) NOT NULL,
    `short_description` text NOT NULL,
    `content` text NOT NULL,
    PRIMARY KEY (`id`),
    KEY `news_id` (`news_id`),
    CONSTRAINT `news_translations_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 4. Add Translation Keys to traduz
-- News Keys
INSERT IGNORE INTO `traduz` (`lang_code`, `code`, `text`)
VALUES
  ('pt', 'menu.news', 'Notícias'),
  ('gb', 'menu.news', 'News'),
  ('pt', 'news.read_more', 'Ler Mais'),
  ('gb', 'news.read_more', 'Read More'),
  ('pt', 'news.latest', 'Últimas Notícias'),
  ('gb', 'news.latest', 'Latest News'),
  ('pt', 'news.back_to_list', 'Voltar à lista'),
  ('gb', 'news.back_to_list', 'Back to list'),
  (
    'pt',
    'news.empty_list',
    'Nenhuma notícia encontrada.'
  ),
  ('gb', 'news.empty_list', 'No news found.');

-- About Page Keys
INSERT IGNORE INTO `traduz` (`lang_code`, `code`, `text`)
VALUES
  ('pt', 'menu.about', 'Sobre Nós'),
  ('gb', 'menu.about', 'About Us'),
  ('pt', 'about.title', 'Sobre Nós'),
  ('gb', 'about.title', 'About Us'),
  ('pt', 'about.subtitle', 'A Nossa História'),
  ('gb', 'about.subtitle', 'Our Story'),
  (
    'pt',
    'about.text_1',
    'Bem-vindo à Danishopper. Começámos com uma pequena ideia e crescemos para nos tornarmos uma referência no mercado e-commerce.'
  ),
  (
    'gb',
    'about.text_1',
    'Welcome to Danishopper. We started with a small idea and grew to become a reference in the e-commerce market.'
  ),
  (
    'pt',
    'about.text_2',
    'O nosso compromisso é com a qualidade e a satisfação do cliente. Trabalhamos todos os dias para lhe trazer as últimas tendências.'
  ),
  (
    'gb',
    'about.text_2',
    'Our commitment is to quality and customer satisfaction. We work every day to bring you the latest trends.'
  );
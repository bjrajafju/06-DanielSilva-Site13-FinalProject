CREATE DATABASE IF NOT EXISTS `pi_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `pi_db`;

-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: pi_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!50503 SET NAMES utf8 */;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;

/*!40103 SET TIME_ZONE='+00:00' */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresses`
--
DROP TABLE IF EXISTS `addresses`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `addresses` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) DEFAULT NULL,
    `first_name` varchar(100) DEFAULT NULL,
    `last_name` varchar(100) DEFAULT NULL,
    `mobile` varchar(30) DEFAULT NULL,
    `address_line1` varchar(255) DEFAULT NULL,
    `address_line2` varchar(255) DEFAULT NULL,
    `city` varchar(100) DEFAULT NULL,
    `state` varchar(100) DEFAULT NULL,
    `postal_code` varchar(20) DEFAULT NULL,
    `country_id` int (11) DEFAULT NULL,
    `type` enum ('billing', 'shipping') DEFAULT 'shipping',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `country_id` (`country_id`),
    CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    CONSTRAINT `addresses_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 19 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--
LOCK TABLES `addresses` WRITE;

/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;

INSERT INTO
  `addresses`
VALUES
  (
    3,
    1,
    'John',
    'Doe',
    '912345678',
    'Rua A 123',
    'N123',
    'Porto',
    'Porto',
    '4000-000',
    1,
    'shipping',
    '2026-05-02 16:55:10'
  ),
  (
    4,
    1,
    'John',
    'Doe',
    '912345678',
    'Rua A 123',
    'N123',
    'Porto',
    'Porto',
    '4000-000',
    1,
    'billing',
    '2026-05-02 16:55:10'
  ),
  (
    5,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'billing',
    '2026-05-04 11:13:52'
  ),
  (
    6,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'shipping',
    '2026-05-04 11:13:52'
  ),
  (
    8,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'shipping',
    '2026-05-04 11:14:41'
  ),
  (
    9,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'billing',
    '2026-05-05 11:17:31'
  ),
  (
    10,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'shipping',
    '2026-05-05 11:17:31'
  ),
  (
    11,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'billing',
    '2026-05-07 19:08:24'
  ),
  (
    12,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'shipping',
    '2026-05-07 19:08:24'
  ),
  (
    13,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'billing',
    '2026-05-08 09:27:06'
  ),
  (
    14,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'shipping',
    '2026-05-08 09:27:06'
  ),
  (
    15,
    3,
    'Daniel',
    'Silva',
    '03203030320',
    'Rua 123',
    'Rau 123',
    'qwqaee',
    'qwe',
    '1234',
    3,
    'billing',
    '2026-05-11 11:01:28'
  ),
  (
    16,
    3,
    'Daniel',
    'Silva',
    '03203030320',
    'Rua 123',
    'Rau 123',
    'qwqaee',
    'qwe',
    '1234',
    3,
    'shipping',
    '2026-05-11 11:01:28'
  ),
  (
    17,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'billing',
    '2026-05-12 11:16:52'
  ),
  (
    18,
    4,
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    1,
    'shipping',
    '2026-05-12 11:16:52'
  );

/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--
DROP TABLE IF EXISTS `cart_items`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `cart_items` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `cart_id` int (11) DEFAULT NULL,
    `variant_id` int (11) DEFAULT NULL,
    `quantity` int (11) DEFAULT 1,
    PRIMARY KEY (`id`),
    UNIQUE KEY `cart_id` (`cart_id`, `variant_id`),
    KEY `variant_id` (`variant_id`),
    CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
    CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 36 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--
LOCK TABLES `cart_items` WRITE;

/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;

INSERT INTO
  `cart_items`
VALUES
  (10, 1, 8, 2),
  (11, 1, 9, 1);

/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `carts`
--
DROP TABLE IF EXISTS `carts`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `carts` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) DEFAULT NULL,
    `session_id` varchar(255) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 10 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--
LOCK TABLES `carts` WRITE;

/*!40000 ALTER TABLE `carts` DISABLE KEYS */;

INSERT INTO
  `carts`
VALUES
  (1, 1, NULL, '2026-05-02 16:52:58'),
  (3, 3, NULL, '2026-05-02 23:04:24'),
  (7, 4, NULL, '2026-05-04 10:31:01');

/*!40000 ALTER TABLE `carts` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `categories`
--
DROP TABLE IF EXISTS `categories`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `categories` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `image` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 7 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--
LOCK TABLES `categories` WRITE;

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO
  `categories`
VALUES
  (1, 'img/cat-1.jpg'),
  (2, 'img/cat-2.jpg'),
  (3, 'img/cat-3.jpg'),
  (4, 'img/cat-4.jpg'),
  (5, 'img/cat-5.jpg'),
  (6, 'img/cat-6.jpg');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `category_translations`
--
DROP TABLE IF EXISTS `category_translations`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `category_translations` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `category_id` int (11) DEFAULT NULL,
    `lang_code` varchar(5) DEFAULT NULL,
    `name` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `category_id` (`category_id`, `lang_code`),
    KEY `lang_code` (`lang_code`),
    CONSTRAINT `category_translations_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
    CONSTRAINT `category_translations_ibfk_2` FOREIGN KEY (`lang_code`) REFERENCES `lang` (`code`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 19 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_translations`
--
LOCK TABLES `category_translations` WRITE;

/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;

INSERT INTO
  `category_translations`
VALUES
  (7, 1, 'gb', 'Men\'s Clothes'),
  (8, 1, 'pt', 'Roupa de Homem'),
  (9, 2, 'gb', 'Womens\' Clothes'),
  (10, 2, 'pt', 'Roupa de Mulher'),
  (11, 3, 'gb', 'Child\'s Clothes'),
  (12, 3, 'pt', 'Roupa de Criança'),
  (13, 4, 'gb', 'Accessories'),
  (14, 4, 'pt', 'Acessórios'),
  (15, 5, 'gb', 'Bags'),
  (16, 5, 'pt', 'Malas'),
  (17, 6, 'gb', 'Shoes'),
  (18, 6, 'pt', 'Sapatos');

/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `color_translations`
--
DROP TABLE IF EXISTS `color_translations`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `color_translations` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `color_id` int (11) DEFAULT NULL,
    `lang_code` varchar(5) DEFAULT NULL,
    `name` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `color_id` (`color_id`, `lang_code`),
    KEY `lang_code` (`lang_code`),
    CONSTRAINT `color_translations_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`),
    CONSTRAINT `color_translations_ibfk_2` FOREIGN KEY (`lang_code`) REFERENCES `lang` (`code`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 21 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `color_translations`
--
LOCK TABLES `color_translations` WRITE;

/*!40000 ALTER TABLE `color_translations` DISABLE KEYS */;

INSERT INTO
  `color_translations`
VALUES
  (11, 1, 'gb', 'Black'),
  (12, 1, 'pt', 'Preto'),
  (13, 2, 'gb', 'White'),
  (14, 2, 'pt', 'Branco'),
  (15, 3, 'gb', 'Red'),
  (16, 3, 'pt', 'Vermelho'),
  (17, 4, 'gb', 'Blue'),
  (18, 4, 'pt', 'Azul'),
  (19, 5, 'gb', 'Green'),
  (20, 5, 'pt', 'Verde');

/*!40000 ALTER TABLE `color_translations` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `colors`
--
DROP TABLE IF EXISTS `colors`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `colors` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `hex` varchar(7) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colors`
--
LOCK TABLES `colors` WRITE;

/*!40000 ALTER TABLE `colors` DISABLE KEYS */;

INSERT INTO
  `colors`
VALUES
  (1, '#000000'),
  (2, '#ffffff'),
  (3, '#FF0000'),
  (4, '#0000FF'),
  (5, '#00FF00');

/*!40000 ALTER TABLE `colors` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `countries`
--
DROP TABLE IF EXISTS `countries`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `countries` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `code` varchar(5) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--
LOCK TABLES `countries` WRITE;

/*!40000 ALTER TABLE `countries` DISABLE KEYS */;

INSERT INTO
  `countries`
VALUES
  (3, 'ES'),
  (2, 'GB'),
  (1, 'PT');

/*!40000 ALTER TABLE `countries` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `country_translations`
--
DROP TABLE IF EXISTS `country_translations`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `country_translations` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `country_id` int (11) DEFAULT NULL,
    `lang_code` varchar(5) DEFAULT NULL,
    `name` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `country_id` (`country_id`, `lang_code`),
    KEY `lang_code` (`lang_code`),
    CONSTRAINT `country_translations_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
    CONSTRAINT `country_translations_ibfk_2` FOREIGN KEY (`lang_code`) REFERENCES `lang` (`code`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 11 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country_translations`
--
LOCK TABLES `country_translations` WRITE;

/*!40000 ALTER TABLE `country_translations` DISABLE KEYS */;

INSERT INTO
  `country_translations`
VALUES
  (5, 1, 'gb', 'Portugal'),
  (6, 1, 'pt', 'Portugal'),
  (7, 2, 'gb', 'United Kingdom'),
  (8, 2, 'pt', 'Reino Unido'),
  (9, 3, 'gb', 'Spain'),
  (10, 3, 'pt', 'Espanha');

/*!40000 ALTER TABLE `country_translations` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `lang`
--
DROP TABLE IF EXISTS `lang`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `lang` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `code` varchar(5) NOT NULL,
    `emoji` varchar(10) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lang`
--
LOCK TABLES `lang` WRITE;

/*!40000 ALTER TABLE `lang` DISABLE KEYS */;

INSERT INTO
  `lang`
VALUES
  (1, 'pt', '??'),
  (2, 'gb', '??');

/*!40000 ALTER TABLE `lang` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `messages`
--
DROP TABLE IF EXISTS `messages`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `messages` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `subject` varchar(255) NOT NULL,
    `message` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `is_read` tinyint (1) DEFAULT 0,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--
LOCK TABLES `messages` WRITE;

/*!40000 ALTER TABLE `messages` DISABLE KEYS */;

INSERT INTO
  `messages`
VALUES
  (
    1,
    'awd',
    'awqd@gmail.com',
    'swdf',
    'sadf',
    '2026-05-05 19:28:29',
    0
  ),
  (
    2,
    'Daniel Silva',
    'bjrajafju@gmail.com',
    'ewfew',
    'r',
    '2026-05-05 19:29:38',
    1
  );

/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `news`
--
DROP TABLE IF EXISTS `news`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `news` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `image` varchar(255) DEFAULT NULL,
    `is_active` tinyint (1) DEFAULT 1,
    `created_at` datetime DEFAULT current_timestamp(),
    `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--
LOCK TABLES `news` WRITE;

/*!40000 ALTER TABLE `news` DISABLE KEYS */;

INSERT INTO
  `news`
VALUES
  (
    1,
    'img/img_69fb6f733cb9e9.21219221.png',
    1,
    '2026-05-06 18:15:32',
    '2026-05-12 12:48:15'
  );

/*!40000 ALTER TABLE `news` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `news_translations`
--
DROP TABLE IF EXISTS `news_translations`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `news_translations` (
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
  ) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_translations`
--
LOCK TABLES `news_translations` WRITE;

/*!40000 ALTER TABLE `news_translations` DISABLE KEYS */;

INSERT INTO
  `news_translations`
VALUES
  (
    1,
    1,
    'pt',
    'Primeira noticia',
    'primeira-noticia',
    'Descrição pequena da noticia',
    'Conteudo todo da noticia'
  ),
  (
    2,
    1,
    'gb',
    'Fist news',
    'fist-news',
    'Short Description of first news',
    'Full content of first news'
  );

/*!40000 ALTER TABLE `news_translations` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `order_addresses`
--
DROP TABLE IF EXISTS `order_addresses`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `order_addresses` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `order_id` int (11) DEFAULT NULL,
    `type` enum ('billing', 'shipping') DEFAULT NULL,
    `first_name` varchar(100) DEFAULT NULL,
    `last_name` varchar(100) DEFAULT NULL,
    `mobile` varchar(30) DEFAULT NULL,
    `address_line1` varchar(255) DEFAULT NULL,
    `address_line2` varchar(255) DEFAULT NULL,
    `city` varchar(100) DEFAULT NULL,
    `state` varchar(100) DEFAULT NULL,
    `postal_code` varchar(20) DEFAULT NULL,
    `country_name` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `order_id` (`order_id`),
    CONSTRAINT `order_addresses_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 23 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_addresses`
--
LOCK TABLES `order_addresses` WRITE;

/*!40000 ALTER TABLE `order_addresses` DISABLE KEYS */;

INSERT INTO
  `order_addresses`
VALUES
  (
    3,
    1,
    'shipping',
    'John',
    'Doe',
    '912345678',
    'Rua A 123',
    'N123',
    'Porto',
    'Porto',
    '4000-000',
    'Portugal'
  ),
  (
    4,
    1,
    'billing',
    'John',
    'Doe',
    '912345678',
    'Rua A 123',
    'N123',
    'Porto',
    'Porto',
    '4000-000',
    'Portugal'
  ),
  (
    7,
    6,
    'billing',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    8,
    6,
    'shipping',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    9,
    7,
    'billing',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    10,
    7,
    'shipping',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    11,
    8,
    'billing',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    12,
    8,
    'shipping',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    13,
    9,
    'billing',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    14,
    9,
    'shipping',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    15,
    10,
    'billing',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    16,
    10,
    'shipping',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    17,
    11,
    'billing',
    'Daniel',
    'Silva',
    '03203030320',
    'Rua 123',
    'Rau 123',
    'qwqaee',
    'qwe',
    '1234',
    'Espanha'
  ),
  (
    18,
    11,
    'shipping',
    'Daniel',
    'Silva',
    '03203030320',
    'Rua 123',
    'Rau 123',
    'qwqaee',
    'qwe',
    '1234',
    'Espanha'
  ),
  (
    19,
    12,
    'billing',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    20,
    12,
    'shipping',
    'Super',
    'User',
    '999999999',
    'Rua 123',
    '123',
    'Porto',
    'Porto',
    '4000',
    'Portugal'
  ),
  (
    21,
    13,
    'billing',
    'Daniel',
    'Silva',
    '+351912985203',
    '20 Praceta de Irene de Castro',
    '8 hab 4',
    'Porto',
    'dv',
    '4350-198',
    'Portugal'
  ),
  (
    22,
    13,
    'shipping',
    'Daniel',
    'Silva',
    '+351912985203',
    '20 Praceta de Irene de Castro',
    '8 hab 4',
    'Porto',
    'dv',
    '4350-198',
    'Portugal'
  );

/*!40000 ALTER TABLE `order_addresses` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `order_items`
--
DROP TABLE IF EXISTS `order_items`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `order_items` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `order_id` int (11) DEFAULT NULL,
    `product_id` int (11) DEFAULT NULL,
    `variant_id` int (11) DEFAULT NULL,
    `product_title` varchar(255) DEFAULT NULL,
    `price` decimal(10, 2) DEFAULT NULL,
    `quantity` int (11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `order_id` (`order_id`),
    CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 19 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--
LOCK TABLES `order_items` WRITE;

/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;

INSERT INTO
  `order_items`
VALUES
  (2, 1, 1, 1, 'Blue Casual Shirt', 29.99, 2),
  (3, 3, 1, 9, 'Camisa Azul Casual', 29.99, 1),
  (4, 4, 1, 9, 'Camisa Azul Casual', 29.99, 1),
  (6, 6, 1, 8, 'Blue Casual Shirt', 29.99, 2),
  (7, 7, 5, 13, 'Classic Watch', 19.99, 3),
  (8, 8, 5, 13, 'Relógio Clássico', 19.99, 1),
  (9, 9, 6, 14, 'Sunglasses', 14.99, 4),
  (10, 10, 6, 14, 'Sunglasses', 14.99, 6),
  (11, 11, 5, 13, 'Relógio Clássico', 19.99, 4),
  (12, 11, 1, 9, 'Camisa Azul Casual', 29.99, 1),
  (13, 11, 6, 14, 'Óculos de Sol', 14.99, 3),
  (14, 11, 2, 10, 'Camisa Branca Elegante', 34.99, 3),
  (15, 12, 6, 14, 'Sunglasses', 14.99, 1),
  (16, 12, 4, 12, 'Leather Shoes', 79.99, 3),
  (17, 12, 3, 11, 'Running Shoes', 59.99, 5),
  (18, 13, 6, 14, 'Óculos de Sol', 14.99, 3);

/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `orders`
--
DROP TABLE IF EXISTS `orders`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `orders` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) DEFAULT NULL,
    `payment_method_id` int (11) DEFAULT NULL,
    `subtotal` decimal(10, 2) DEFAULT NULL,
    `shipping` decimal(10, 2) DEFAULT NULL,
    `total` decimal(10, 2) DEFAULT NULL,
    `status` enum (
      'pending',
      'paid',
      'shipped',
      'completed',
      'cancelled'
    ) DEFAULT 'pending',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    KEY `payment_method_id` (`payment_method_id`),
    CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--
LOCK TABLES `orders` WRITE;

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;

INSERT INTO
  `orders`
VALUES
  (
    1,
    1,
    1,
    59.98,
    5.00,
    64.98,
    'paid',
    '2026-05-02 16:55:10'
  ),
  (
    3,
    NULL,
    2,
    29.99,
    10.00,
    39.99,
    'shipped',
    '2026-05-04 07:35:49'
  ),
  (
    4,
    NULL,
    1,
    29.99,
    10.00,
    39.99,
    'completed',
    '2026-05-04 07:37:57'
  ),
  (
    6,
    4,
    1,
    59.98,
    10.00,
    69.98,
    'pending',
    '2026-05-04 11:13:52'
  ),
  (
    7,
    4,
    1,
    59.97,
    10.00,
    69.97,
    'completed',
    '2026-05-04 11:14:41'
  ),
  (
    8,
    4,
    1,
    19.99,
    10.00,
    29.99,
    'completed',
    '2026-05-05 11:17:31'
  ),
  (
    9,
    4,
    1,
    59.96,
    10.00,
    69.96,
    'completed',
    '2026-05-07 19:08:24'
  ),
  (
    10,
    4,
    1,
    89.94,
    10.00,
    99.94,
    'completed',
    '2026-05-08 09:27:06'
  ),
  (
    11,
    3,
    1,
    259.89,
    10.00,
    269.89,
    'paid',
    '2026-05-11 11:01:28'
  ),
  (
    12,
    4,
    1,
    554.91,
    10.00,
    564.91,
    'pending',
    '2026-05-12 11:16:52'
  ),
  (
    13,
    NULL,
    1,
    44.97,
    10.00,
    54.97,
    'pending',
    '2026-05-13 08:09:35'
  );

/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--
DROP TABLE IF EXISTS `password_resets`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `password_resets` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) NOT NULL,
    `token_hash` varchar(255) NOT NULL,
    `expires_at` datetime NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `ip_address` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `token_hash` (`token_hash`),
    KEY `user_id` (`user_id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--
LOCK TABLES `password_resets` WRITE;

/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;

INSERT INTO
  `password_resets`
VALUES
  (
    1,
    4,
    '00802e48dcf3a51f855361b343dcff8b08645ff2da2c83838d01c238fd1dd5ca',
    '2026-05-11 13:31:30',
    '2026-05-11 10:31:30',
    '::1'
  );

/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `payment_method_translations`
--
DROP TABLE IF EXISTS `payment_method_translations`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `payment_method_translations` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `payment_method_id` int (11) DEFAULT NULL,
    `lang_code` varchar(5) DEFAULT NULL,
    `name` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `payment_method_id` (`payment_method_id`, `lang_code`),
    KEY `lang_code` (`lang_code`),
    CONSTRAINT `payment_method_translations_ibfk_1` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
    CONSTRAINT `payment_method_translations_ibfk_2` FOREIGN KEY (`lang_code`) REFERENCES `lang` (`code`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 13 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_method_translations`
--
LOCK TABLES `payment_method_translations` WRITE;

/*!40000 ALTER TABLE `payment_method_translations` DISABLE KEYS */;

INSERT INTO
  `payment_method_translations`
VALUES
  (7, 1, 'gb', 'MB Way'),
  (8, 1, 'pt', 'MB Way'),
  (9, 2, 'gb', 'PayPal'),
  (10, 2, 'pt', 'PayPal'),
  (11, 3, 'gb', 'Credit Card'),
  (12, 3, 'pt', 'Cartão de Crédito');

/*!40000 ALTER TABLE `payment_method_translations` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--
DROP TABLE IF EXISTS `payment_methods`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `payment_methods` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `code` varchar(50) DEFAULT NULL,
    `is_active` tinyint (1) DEFAULT 1,
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--
LOCK TABLES `payment_methods` WRITE;

/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;

INSERT INTO
  `payment_methods`
VALUES
  (1, 'mbway', 1),
  (2, 'paypal', 0),
  (3, 'card', 1);

/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `product_translations`
--
DROP TABLE IF EXISTS `product_translations`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `product_translations` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `product_id` int (11) DEFAULT NULL,
    `lang_code` varchar(5) DEFAULT NULL,
    `title` varchar(255) NOT NULL,
    `slug` varchar(255) DEFAULT NULL,
    `short_description` text DEFAULT NULL,
    `description` text DEFAULT NULL,
    `additional_info` text DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_id` (`product_id`, `lang_code`),
    UNIQUE KEY `slug` (`slug`),
    KEY `lang_code` (`lang_code`),
    CONSTRAINT `product_translations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
    CONSTRAINT `product_translations_ibfk_2` FOREIGN KEY (`lang_code`) REFERENCES `lang` (`code`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 25 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_translations`
--
LOCK TABLES `product_translations` WRITE;

/*!40000 ALTER TABLE `product_translations` DISABLE KEYS */;

INSERT INTO
  `product_translations`
VALUES
  (
    13,
    1,
    'gb',
    'Blue Casual Shirt',
    'blue-casual-shirt',
    'Casual blue shirt',
    'Full description...',
    'Cotton'
  ),
  (
    14,
    1,
    'pt',
    'Camisa Azul Casual',
    'camisa-azul-casual',
    'Camisa azul casual',
    'Descrição completa...',
    'Algodão'
  ),
  (
    15,
    2,
    'gb',
    'White Elegant Shirt',
    'white-elegant-shirt',
    'Elegant white shirt',
    'Full description...',
    'Slim fit'
  ),
  (
    16,
    2,
    'pt',
    'Camisa Branca Elegante',
    'camisa-branca-elegante',
    'Camisa branca elegante',
    'Descrição completa...',
    'Slim fit'
  ),
  (
    17,
    3,
    'gb',
    'Running Shoes',
    'running-shoes',
    'Lightweight shoes',
    'Full description...',
    'Sport'
  ),
  (
    18,
    3,
    'pt',
    'Ténis de Corrida',
    'tenis-corrida',
    'Ténis leves',
    'Descrição completa...',
    'Desporto'
  ),
  (
    19,
    4,
    'gb',
    'Leather Shoes',
    'leather-shoes',
    'Premium leather shoes',
    'Full description...',
    'Leather'
  ),
  (
    20,
    4,
    'pt',
    'Sapatos de Couro',
    'sapatos-couro',
    'Sapatos premium',
    'Descrição completa...',
    'Couro'
  ),
  (
    21,
    5,
    'gb',
    'Classic Watch',
    'classic-watch',
    'Minimal watch',
    'Full description...',
    'Water resistant'
  ),
  (
    22,
    5,
    'pt',
    'Relógio Clássico',
    'rel-gio-cl-ssico',
    'Relógio minimalista',
    'Descrição completa...',
    'Resistente à água'
  ),
  (
    23,
    6,
    'gb',
    'Elegant suit',
    'elegant-suit',
    'Elegant suit and tie',
    'Full description...',
    'Elegant and high class'
  ),
  (
    24,
    6,
    'pt',
    'Fato elegante',
    'fato-elegante',
    'Fato e gravata elegantes',
    'Descrição completa...',
    'Elegante e alta classe'
  );

/*!40000 ALTER TABLE `product_translations` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `product_variants`
--
DROP TABLE IF EXISTS `product_variants`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `product_variants` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `product_id` int (11) DEFAULT NULL,
    `size_id` int (11) DEFAULT NULL,
    `color_id` int (11) DEFAULT NULL,
    `is_available` tinyint (1) DEFAULT 1,
    `stock` int (11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_id` (`product_id`, `size_id`, `color_id`),
    KEY `size_id` (`size_id`),
    KEY `color_id` (`color_id`),
    CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
    CONSTRAINT `product_variants_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`),
    CONSTRAINT `product_variants_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 15 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variants`
--
LOCK TABLES `product_variants` WRITE;

/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;

INSERT INTO
  `product_variants`
VALUES
  (8, 1, 2, 4, 1, 10),
  (9, 1, 3, 4, 1, 9),
  (10, 2, 3, 2, 1, 7),
  (11, 3, 4, 1, 1, 5),
  (12, 4, 4, 1, 1, 7),
  (13, 5, 1, 3, 1, 6),
  (14, 6, 2, 5, 1, 3);

/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `products`
--
DROP TABLE IF EXISTS `products`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `products` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `codProd` varchar(50) DEFAULT NULL,
    `category_id` int (11) DEFAULT NULL,
    `price` decimal(10, 2) NOT NULL,
    `image` varchar(255) DEFAULT NULL,
    `is_active` tinyint (1) DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `codProd` (`codProd`),
    KEY `category_id` (`category_id`),
    CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 7 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--
LOCK TABLES `products` WRITE;

/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO
  `products`
VALUES
  (
    1,
    'P001',
    1,
    29.99,
    'img/product-3.jpg',
    1,
    '2026-05-02 16:52:58',
    '2026-05-14 07:24:22'
  ),
  (
    2,
    'P002',
    1,
    34.99,
    'img/product-1.jpg',
    1,
    '2026-05-02 16:52:58',
    '2026-05-14 07:24:22'
  ),
  (
    3,
    'P003',
    6,
    59.99,
    'img/img_6a0579b3533de8.52506234.jpg',
    1,
    '2026-05-02 16:52:58',
    '2026-05-14 08:28:51'
  ),
  (
    4,
    'P004',
    6,
    79.99,
    'img/img_6a0579f3ed0d71.88006496.jpg',
    1,
    '2026-05-02 16:52:58',
    '2026-05-14 08:29:55'
  ),
  (
    5,
    'P005',
    4,
    19.99,
    'img/img_6a05791b8dedd7.23447228.jpg',
    1,
    '2026-05-02 16:52:58',
    '2026-05-14 08:27:04'
  ),
  (
    6,
    'P006',
    1,
    14.99,
    'img/product-6.jpg',
    1,
    '2026-05-02 16:52:58',
    '2026-05-14 08:21:07'
  );

/*!40000 ALTER TABLE `products` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `reviews`
--
DROP TABLE IF EXISTS `reviews`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `reviews` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `product_id` int (11) NOT NULL,
    `user_id` int (11) DEFAULT NULL,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `rating` int (1) NOT NULL,
    `comment` text NOT NULL,
    `is_approved` tinyint (1) DEFAULT 0,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `product_id` (`product_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
    CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
  ) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--
LOCK TABLES `reviews` WRITE;

/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;

INSERT INTO
  `reviews`
VALUES
  (
    2,
    6,
    4,
    'Super User',
    'bjrajafju@gmail.com',
    3,
    'adfsad',
    1,
    '2026-05-06 19:08:32'
  ),
  (
    3,
    6,
    4,
    'Super User',
    'bjrajafju@gmail.com',
    4,
    'bem bom',
    1,
    '2026-05-06 19:12:02'
  ),
  (
    4,
    6,
    4,
    'Super User',
    'bjrajafju@gmail.com',
    4,
    'sedef',
    1,
    '2026-05-06 19:12:34'
  );

/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `settings`
--
DROP TABLE IF EXISTS `settings`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `settings` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `settings_key` varchar(100) NOT NULL,
    `settings_value` text DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `settings_key` (`settings_key`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 13 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--
LOCK TABLES `settings` WRITE;

/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO
  `settings`
VALUES
  (
    1,
    'smtp_host',
    'smtp.gmail.com',
    '2026-05-11 10:23:58',
    '2026-05-11 10:57:27'
  ),
  (
    2,
    'smtp_port',
    '587',
    '2026-05-11 10:23:58',
    '2026-05-11 10:23:58'
  ),
  (
    3,
    'smtp_user',
    'danielbateeria@gmail.com',
    '2026-05-11 10:23:58',
    '2026-05-11 10:57:27'
  ),
  (
    4,
    'smtp_pass',
    'umryqhucjtlsdzfh',
    '2026-05-11 10:23:58',
    '2026-05-11 10:57:27'
  ),
  (
    5,
    'smtp_encryption',
    'tls',
    '2026-05-11 10:23:58',
    '2026-05-11 10:23:58'
  ),
  (
    6,
    'smtp_from_email',
    'danielbateeria@gmail.com',
    '2026-05-11 10:23:58',
    '2026-05-11 10:57:27'
  ),
  (
    7,
    'smtp_from_name',
    'Dani Shopper',
    '2026-05-11 10:23:58',
    '2026-05-11 10:57:27'
  ),
  (
    8,
    'meta_title',
    'DaniShopper - A Tua Loja Online',
    '2026-05-13 07:41:29',
    '2026-05-13 07:41:29'
  ),
  (
    9,
    'meta_description',
    'Encontra os melhores produtos aos melhores preços na DaniShopper.',
    '2026-05-13 07:41:29',
    '2026-05-13 07:41:29'
  ),
  (
    10,
    'meta_keywords',
    'ecommerce, shop, online, fashion',
    '2026-05-13 07:41:29',
    '2026-05-13 07:41:29'
  ),
  (
    11,
    'og_image',
    'img/og-default.jpg',
    '2026-05-13 07:41:29',
    '2026-05-13 07:41:29'
  ),
  (
    12,
    'favicon',
    'img/favicon.ico',
    '2026-05-13 07:41:29',
    '2026-05-13 07:41:29'
  );

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `sizes`
--
DROP TABLE IF EXISTS `sizes`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `sizes` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sizes`
--
LOCK TABLES `sizes` WRITE;

/*!40000 ALTER TABLE `sizes` DISABLE KEYS */;

INSERT INTO
  `sizes`
VALUES
  (1, 'XS'),
  (2, 'S'),
  (3, 'M'),
  (4, 'L'),
  (5, 'XL');

/*!40000 ALTER TABLE `sizes` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `social_links`
--
DROP TABLE IF EXISTS `social_links`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `social_links` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `platform` varchar(50) NOT NULL,
    `url` varchar(255) NOT NULL,
    `icon` varchar(50) NOT NULL,
    `is_active` tinyint (1) DEFAULT 1,
    `sort_order` int (11) DEFAULT 0,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_links`
--
LOCK TABLES `social_links` WRITE;

/*!40000 ALTER TABLE `social_links` DISABLE KEYS */;

INSERT INTO
  `social_links`
VALUES
  (
    1,
    'Facebook',
    'https://facebook.com',
    'fab fa-facebook-f',
    1,
    1,
    '2026-05-14 07:40:51'
  ),
  (
    2,
    'Twitter',
    'https://twitter.com',
    'fab fa-twitter',
    1,
    3,
    '2026-05-14 07:40:51'
  ),
  (
    3,
    'LinkedIn',
    'https://linkedin.com',
    'fab fa-linkedin-in',
    0,
    2,
    '2026-05-14 07:40:51'
  ),
  (
    4,
    'Instagram',
    'https://instagram.com',
    'fab fa-instagram',
    1,
    4,
    '2026-05-14 07:40:51'
  ),
  (
    5,
    'YouTube',
    'https://youtube.com',
    'fab fa-youtube',
    1,
    5,
    '2026-05-14 07:40:51'
  );

/*!40000 ALTER TABLE `social_links` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `store_translations`
--
DROP TABLE IF EXISTS `store_translations`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `store_translations` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `store_id` int (11) DEFAULT NULL,
    `lang_code` varchar(5) DEFAULT NULL,
    `name` varchar(255) DEFAULT NULL,
    `address` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `store_id` (`store_id`),
    CONSTRAINT `store_translations_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
  ) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_translations`
--
LOCK TABLES `store_translations` WRITE;

/*!40000 ALTER TABLE `store_translations` DISABLE KEYS */;

INSERT INTO
  `store_translations`
VALUES
  (1, 1, 'pt', 'Lojinha', 'Aqui e ali'),
  (2, 1, 'gb', 'Storezinha', 'Here and there');

/*!40000 ALTER TABLE `store_translations` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `stores`
--
DROP TABLE IF EXISTS `stores`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `stores` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `email` varchar(255) DEFAULT NULL,
    `phone` varchar(50) DEFAULT NULL,
    `is_active` tinyint (1) DEFAULT 1,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--
LOCK TABLES `stores` WRITE;

/*!40000 ALTER TABLE `stores` DISABLE KEYS */;

INSERT INTO
  `stores`
VALUES
  (
    1,
    'store@gmail.com',
    '919191919',
    1,
    '2026-05-06 14:48:13'
  );

/*!40000 ALTER TABLE `stores` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `traduz`
--
DROP TABLE IF EXISTS `traduz`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `traduz` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `lang_code` varchar(5) NOT NULL,
    `code` varchar(100) NOT NULL,
    `text` text NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `lang_code` (`lang_code`, `code`),
    CONSTRAINT `traduz_ibfk_1` FOREIGN KEY (`lang_code`) REFERENCES `lang` (`code`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 675 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traduz`
--
LOCK TABLES `traduz` WRITE;

/*!40000 ALTER TABLE `traduz` DISABLE KEYS */;

INSERT INTO
  `traduz`
VALUES
  (
    87,
    'gb',
    'home.featured.quality_product',
    'Quality Product'
  ),
  (
    88,
    'pt',
    'home.featured.quality_product',
    'Produto de Qualidade'
  ),
  (
    89,
    'gb',
    'home.featured.free_shipping',
    'Free Shipping'
  ),
  (
    90,
    'pt',
    'home.featured.free_shipping',
    'Envio Grátis'
  ),
  (
    91,
    'gb',
    'home.featured.return_policy',
    '14-Day Return'
  ),
  (
    92,
    'pt',
    'home.featured.return_policy',
    'Devolução em 14 Dias'
  ),
  (93, 'gb', 'home.featured.support', '24/7 Support'),
  (94, 'pt', 'home.featured.support', 'Suporte 24/7'),
  (
    95,
    'gb',
    'home.trending_products.title',
    'Trendy Products'
  ),
  (
    96,
    'pt',
    'home.trending_products.title',
    'Produtos em Tendência'
  ),
  (97, 'gb', 'home.subscribe.title', 'Stay Updated'),
  (
    98,
    'pt',
    'home.subscribe.title',
    'Mantenha-se Atualizado'
  ),
  (
    99,
    'gb',
    'home.subscribe.description',
    'Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.'
  ),
  (
    100,
    'pt',
    'home.subscribe.description',
    'Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.'
  ),
  (
    101,
    'gb',
    'home.subscribe.placeholder',
    'Email Goes Here'
  ),
  (
    102,
    'pt',
    'home.subscribe.placeholder',
    'Insira o seu Email'
  ),
  (103, 'gb', 'home.subscribe.button', 'Subscribe'),
  (104, 'pt', 'home.subscribe.button', 'Subscrever'),
  (
    105,
    'gb',
    'home.just_arrived.title',
    'Just Arrived'
  ),
  (
    106,
    'pt',
    'home.just_arrived.title',
    'Acabados de Chegar'
  ),
  (
    107,
    'gb',
    'home.vendors.vendor1_image',
    'img/vendor-1.jpg'
  ),
  (
    108,
    'pt',
    'home.vendors.vendor1_image',
    'img/vendor-1.jpg'
  ),
  (
    109,
    'gb',
    'home.vendors.vendor2_image',
    'img/vendor-2.jpg'
  ),
  (
    110,
    'pt',
    'home.vendors.vendor2_image',
    'img/vendor-2.jpg'
  ),
  (
    111,
    'gb',
    'home.vendors.vendor3_image',
    'img/vendor-3.jpg'
  ),
  (
    112,
    'pt',
    'home.vendors.vendor3_image',
    'img/vendor-3.jpg'
  ),
  (
    113,
    'gb',
    'home.vendors.vendor4_image',
    'img/vendor-4.jpg'
  ),
  (
    114,
    'pt',
    'home.vendors.vendor4_image',
    'img/vendor-4.jpg'
  ),
  (
    115,
    'gb',
    'home.vendors.vendor5_image',
    'img/vendor-5.jpg'
  ),
  (
    116,
    'pt',
    'home.vendors.vendor5_image',
    'img/vendor-5.jpg'
  ),
  (
    117,
    'gb',
    'home.vendors.vendor6_image',
    'img/vendor-6.jpg'
  ),
  (
    118,
    'pt',
    'home.vendors.vendor6_image',
    'img/vendor-6.jpg'
  ),
  (
    119,
    'gb',
    'home.vendors.vendor7_image',
    'img/vendor-7.jpg'
  ),
  (
    120,
    'pt',
    'home.vendors.vendor7_image',
    'img/vendor-7.jpg'
  ),
  (
    121,
    'gb',
    'home.vendors.vendor8_image',
    'img/vendor-8.jpg'
  ),
  (
    122,
    'pt',
    'home.vendors.vendor8_image',
    'img/vendor-8.jpg'
  ),
  (123, 'gb', 'shop.header.title', 'Our Shop'),
  (124, 'pt', 'shop.header.title', 'A Nossa Loja'),
  (125, 'gb', 'shop.header.breadcrumb_home', 'Home'),
  (
    126,
    'pt',
    'shop.header.breadcrumb_home',
    'Início'
  ),
  (127, 'gb', 'shop.header.breadcrumb_shop', 'Shop'),
  (128, 'pt', 'shop.header.breadcrumb_shop', 'Loja'),
  (
    129,
    'gb',
    'shop.sidebar.filter_price_title',
    'Filter by price'
  ),
  (
    130,
    'pt',
    'shop.sidebar.filter_price_title',
    'Filtrar por preço'
  ),
  (
    131,
    'gb',
    'shop.sidebar.filter_price_all',
    'All Price'
  ),
  (
    132,
    'pt',
    'shop.sidebar.filter_price_all',
    'Todos os Preços'
  ),
  (
    133,
    'gb',
    'shop.sidebar.filter_color_title',
    'Filter by color'
  ),
  (
    134,
    'pt',
    'shop.sidebar.filter_color_title',
    'Filtrar por cor'
  ),
  (
    135,
    'gb',
    'shop.sidebar.filter_color_all',
    'All Color'
  ),
  (
    136,
    'pt',
    'shop.sidebar.filter_color_all',
    'Todas as Cores'
  ),
  (
    137,
    'gb',
    'shop.sidebar.filter_size_title',
    'Filter by size'
  ),
  (
    138,
    'pt',
    'shop.sidebar.filter_size_title',
    'Filtrar por tamanho'
  ),
  (
    139,
    'gb',
    'shop.sidebar.filter_size_all',
    'All Size'
  ),
  (
    140,
    'pt',
    'shop.sidebar.filter_size_all',
    'Todos os Tamanhos'
  ),
  (
    141,
    'gb',
    'shop.products.search_placeholder',
    'Search by name'
  ),
  (
    142,
    'pt',
    'shop.products.search_placeholder',
    'Pesquisar por nome'
  ),
  (143, 'gb', 'shop.products.sort_button', 'Sort by'),
  (
    144,
    'pt',
    'shop.products.sort_button',
    'Ordenar por'
  ),
  (
    145,
    'gb',
    'shop.products.sort_nameAZ',
    'Name (A-Z)'
  ),
  (
    146,
    'pt',
    'shop.products.sort_nameAZ',
    'Nome (A-Z)'
  ),
  (
    147,
    'gb',
    'shop.products.sort_nameZA',
    'Name (Z-A)'
  ),
  (
    148,
    'pt',
    'shop.products.sort_nameZA',
    'Nome (Z-A)'
  ),
  (
    149,
    'gb',
    'shop.products.sort_price_asc',
    'Price Low to High'
  ),
  (
    150,
    'pt',
    'shop.products.sort_price_asc',
    'Preço Ascendente'
  ),
  (151, 'gb', 'shop.pagination.previous', 'Previous'),
  (152, 'pt', 'shop.pagination.previous', 'Anterior'),
  (153, 'gb', 'shop.pagination.next', 'Next'),
  (154, 'pt', 'shop.pagination.next', 'Seguinte'),
  (
    155,
    'gb',
    'detail.header.title',
    'Product Detail'
  ),
  (
    156,
    'pt',
    'detail.header.title',
    'Detalhes do Produto'
  ),
  (
    157,
    'gb',
    'detail.header.breadcrumb_home',
    'Home'
  ),
  (
    158,
    'pt',
    'detail.header.breadcrumb_home',
    'Início'
  ),
  (
    159,
    'gb',
    'detail.header.breadcrumb_detail',
    'Product Detail'
  ),
  (
    160,
    'pt',
    'detail.header.breadcrumb_detail',
    'Detalhes do Produto'
  ),
  (161, 'gb', 'detail.product.sizes_label', 'Sizes:'),
  (
    162,
    'pt',
    'detail.product.sizes_label',
    'Tamanhos:'
  ),
  (
    163,
    'gb',
    'detail.product.colors_label',
    'Colors:'
  ),
  (
    164,
    'pt',
    'detail.product.colors_label',
    'Cores:'
  ),
  (
    165,
    'gb',
    'detail.product.add_to_cart',
    'Add To Cart'
  ),
  (
    166,
    'pt',
    'detail.product.add_to_cart',
    'Adicionar ao Carrinho'
  ),
  (
    169,
    'gb',
    'detail.tabs.description',
    'Description'
  ),
  (170, 'pt', 'detail.tabs.description', 'Descrição'),
  (
    171,
    'gb',
    'detail.tabs.information',
    'Information'
  ),
  (
    172,
    'pt',
    'detail.tabs.information',
    'Informação'
  ),
  (173, 'gb', 'detail.tabs.reviews', 'Reviews'),
  (174, 'pt', 'detail.tabs.reviews', 'Avaliações'),
  (
    175,
    'gb',
    'detail.tabs.product_description_title',
    'Product Description'
  ),
  (
    176,
    'pt',
    'detail.tabs.product_description_title',
    'Descrição do Produto'
  ),
  (
    177,
    'gb',
    'detail.tabs.additional_information_title',
    'Additional Information'
  ),
  (
    178,
    'pt',
    'detail.tabs.additional_information_title',
    'Informação Adicional'
  ),
  (
    179,
    'gb',
    'detail.reviews.leave_review_title',
    'Leave a review'
  ),
  (
    180,
    'pt',
    'detail.reviews.leave_review_title',
    'Deixar uma avaliação'
  ),
  (
    181,
    'gb',
    'detail.reviews.email_notice',
    'Your email address will not be published. Required fields are marked *'
  ),
  (
    182,
    'pt',
    'detail.reviews.email_notice',
    'O seu endereço de email não será publicado. Os campos obrigatórios estão marcados com *'
  ),
  (
    183,
    'gb',
    'detail.reviews.your_rating_label',
    'Your Rating * :'
  ),
  (
    184,
    'pt',
    'detail.reviews.your_rating_label',
    'A sua Classificação * :'
  ),
  (
    185,
    'gb',
    'detail.reviews.your_review_label',
    'Your Review *'
  ),
  (
    186,
    'pt',
    'detail.reviews.your_review_label',
    'A sua Avaliação *'
  ),
  (
    187,
    'gb',
    'detail.reviews.your_name_label',
    'Your Name *'
  ),
  (
    188,
    'pt',
    'detail.reviews.your_name_label',
    'O seu Nome *'
  ),
  (
    189,
    'gb',
    'detail.reviews.your_email_label',
    'Your Email *'
  ),
  (
    190,
    'pt',
    'detail.reviews.your_email_label',
    'O seu Email *'
  ),
  (
    191,
    'gb',
    'detail.reviews.submit_button',
    'Leave Your Review'
  ),
  (
    192,
    'pt',
    'detail.reviews.submit_button',
    'Enviar a sua Avaliação'
  ),
  (
    193,
    'gb',
    'detail.related_products.title',
    'You May Also Like'
  ),
  (
    194,
    'pt',
    'detail.related_products.title',
    'Também Pode Gostar'
  ),
  (195, 'gb', 'contact.header.title', 'Contact Us'),
  (196, 'pt', 'contact.header.title', 'Contacte-nos'),
  (
    197,
    'gb',
    'contact.header.breadcrumb_home',
    'Home'
  ),
  (
    198,
    'pt',
    'contact.header.breadcrumb_home',
    'Início'
  ),
  (
    199,
    'gb',
    'contact.header.breadcrumb_contact',
    'Contact'
  ),
  (
    200,
    'pt',
    'contact.header.breadcrumb_contact',
    'Contacto'
  ),
  (
    201,
    'gb',
    'contact.form.title',
    'Contact For Any Queries'
  ),
  (
    202,
    'pt',
    'contact.form.title',
    'Contacte para Qualquer Dúvida'
  ),
  (
    203,
    'gb',
    'contact.form.name_placeholder',
    'Your Name'
  ),
  (
    204,
    'pt',
    'contact.form.name_placeholder',
    'O seu Nome'
  ),
  (
    205,
    'gb',
    'contact.form.email_placeholder',
    'Your Email'
  ),
  (
    206,
    'pt',
    'contact.form.email_placeholder',
    'O seu Email'
  ),
  (
    207,
    'gb',
    'contact.form.subject_placeholder',
    'Subject'
  ),
  (
    208,
    'pt',
    'contact.form.subject_placeholder',
    'Assunto'
  ),
  (
    209,
    'gb',
    'contact.form.message_placeholder',
    'Message'
  ),
  (
    210,
    'pt',
    'contact.form.message_placeholder',
    'Mensagem'
  ),
  (
    211,
    'gb',
    'contact.form.send_button',
    'Send Message'
  ),
  (
    212,
    'pt',
    'contact.form.send_button',
    'Enviar Mensagem'
  ),
  (213, 'gb', 'contact.info.title', 'Get In Touch'),
  (
    214,
    'pt',
    'contact.info.title',
    'Entre em Contacto'
  ),
  (
    215,
    'gb',
    'contact.info.description',
    'Justo sed diam ut sed amet duo amet lorem amet stet sea ipsum, sed duo amet et. Est elitr dolor elitr erat sit sit. Dolor diam et erat clita ipsum justo sed.'
  ),
  (
    216,
    'pt',
    'contact.info.description',
    'Justo sed diam ut sed amet duo amet lorem amet stet sea ipsum, sed duo amet et. Est elitr dolor elitr erat sit sit. Dolor diam et erat clita ipsum justo sed.'
  ),
  (219, 'gb', 'cart.header.title', 'Shopping Cart'),
  (
    220,
    'pt',
    'cart.header.title',
    'Carrinho de Compras'
  ),
  (221, 'gb', 'cart.header.breadcrumb_home', 'Home'),
  (
    222,
    'pt',
    'cart.header.breadcrumb_home',
    'Início'
  ),
  (
    223,
    'gb',
    'cart.header.breadcrumb_cart',
    'Shopping Cart'
  ),
  (
    224,
    'pt',
    'cart.header.breadcrumb_cart',
    'Carrinho de Compras'
  ),
  (225, 'gb', 'cart.table.products', 'Products'),
  (226, 'pt', 'cart.table.products', 'Produtos'),
  (227, 'gb', 'cart.table.price', 'Price'),
  (228, 'pt', 'cart.table.price', 'Preço'),
  (229, 'gb', 'cart.table.quantity', 'Quantity'),
  (230, 'pt', 'cart.table.quantity', 'Quantidade'),
  (231, 'gb', 'cart.table.total', 'Total'),
  (232, 'pt', 'cart.table.total', 'Total'),
  (233, 'gb', 'cart.table.remove', 'Remove'),
  (234, 'pt', 'cart.table.remove', 'Remover'),
  (
    235,
    'gb',
    'cart.coupon.placeholder',
    'Coupon Code'
  ),
  (
    236,
    'pt',
    'cart.coupon.placeholder',
    'Código de Cupão'
  ),
  (237, 'gb', 'cart.coupon.button', 'Apply Coupon'),
  (238, 'pt', 'cart.coupon.button', 'Aplicar Cupão'),
  (239, 'gb', 'cart.summary.title', 'Cart Summary'),
  (
    240,
    'pt',
    'cart.summary.title',
    'Resumo do Carrinho'
  ),
  (241, 'gb', 'cart.summary.subtotal', 'Subtotal'),
  (242, 'pt', 'cart.summary.subtotal', 'Subtotal'),
  (243, 'gb', 'cart.summary.shipping', 'Shipping'),
  (244, 'pt', 'cart.summary.shipping', 'Envio'),
  (245, 'gb', 'cart.summary.total', 'Total'),
  (246, 'pt', 'cart.summary.total', 'Total'),
  (
    247,
    'gb',
    'cart.checkout.button',
    'Proceed To Checkout'
  ),
  (
    248,
    'pt',
    'cart.checkout.button',
    'Prosseguir para o Pagamento'
  ),
  (249, 'gb', 'checkout.header.title', 'Checkout'),
  (
    250,
    'pt',
    'checkout.header.title',
    'Finalizar Compra'
  ),
  (251, 'gb', 'checkout.breadcrumb.home', 'Home'),
  (252, 'pt', 'checkout.breadcrumb.home', 'Início'),
  (
    253,
    'gb',
    'checkout.breadcrumb.checkout',
    'Checkout'
  ),
  (
    254,
    'pt',
    'checkout.breadcrumb.checkout',
    'Finalizar Compra'
  ),
  (
    255,
    'gb',
    'checkout.form.billing.title',
    'Billing Address'
  ),
  (
    256,
    'pt',
    'checkout.form.billing.title',
    'Morada de Faturação'
  ),
  (
    257,
    'gb',
    'checkout.form.firstname.label',
    'First Name'
  ),
  (
    258,
    'pt',
    'checkout.form.firstname.label',
    'Nome'
  ),
  (
    259,
    'gb',
    'checkout.form.lastname.label',
    'Last Name'
  ),
  (
    260,
    'pt',
    'checkout.form.lastname.label',
    'Apelido'
  ),
  (261, 'gb', 'checkout.form.email.label', 'E-mail'),
  (262, 'pt', 'checkout.form.email.label', 'E-mail'),
  (
    263,
    'gb',
    'checkout.form.mobile.label',
    'Mobile No'
  ),
  (
    264,
    'pt',
    'checkout.form.mobile.label',
    'Número de telemóvel'
  ),
  (
    265,
    'gb',
    'checkout.form.address1.label',
    'Address Line 1'
  ),
  (
    266,
    'pt',
    'checkout.form.address1.label',
    'Morada Linha 1'
  ),
  (
    267,
    'gb',
    'checkout.form.address2.label',
    'Address Line 2'
  ),
  (
    268,
    'pt',
    'checkout.form.address2.label',
    'Morada Linha 2'
  ),
  (
    269,
    'gb',
    'checkout.form.country.label',
    'Country'
  ),
  (270, 'pt', 'checkout.form.country.label', 'País'),
  (271, 'gb', 'checkout.form.city.label', 'City'),
  (272, 'pt', 'checkout.form.city.label', 'Cidade'),
  (273, 'gb', 'checkout.form.state.label', 'State'),
  (
    274,
    'pt',
    'checkout.form.state.label',
    'Distrito'
  ),
  (275, 'gb', 'checkout.form.zip.label', 'ZIP Code'),
  (
    276,
    'pt',
    'checkout.form.zip.label',
    'Código Postal'
  ),
  (
    277,
    'gb',
    'checkout.form.shipping_toggle.label',
    'Ship to different address'
  ),
  (
    278,
    'pt',
    'checkout.form.shipping_toggle.label',
    'Enviar para morada diferente'
  ),
  (
    279,
    'gb',
    'checkout.form.shipping.title',
    'Shipping Address'
  ),
  (
    280,
    'pt',
    'checkout.form.shipping.title',
    'Morada de Envio'
  ),
  (
    281,
    'gb',
    'checkout.summary.title',
    'Order Total'
  ),
  (
    282,
    'pt',
    'checkout.summary.title',
    'Total da Encomenda'
  ),
  (
    283,
    'gb',
    'checkout.summary.products.title',
    'Products'
  ),
  (
    284,
    'pt',
    'checkout.summary.products.title',
    'Produtos'
  ),
  (
    285,
    'gb',
    'checkout.summary.subtotal',
    'Subtotal'
  ),
  (
    286,
    'pt',
    'checkout.summary.subtotal',
    'Subtotal'
  ),
  (
    287,
    'gb',
    'checkout.summary.shipping',
    'Shipping'
  ),
  (288, 'pt', 'checkout.summary.shipping', 'Envio'),
  (289, 'gb', 'checkout.summary.total', 'Total'),
  (290, 'pt', 'checkout.summary.total', 'Total'),
  (291, 'gb', 'checkout.payment.title', 'Payment'),
  (292, 'pt', 'checkout.payment.title', 'Pagamento'),
  (
    293,
    'gb',
    'checkout.payment.place_order',
    'Place Order'
  ),
  (
    294,
    'pt',
    'checkout.payment.place_order',
    'Efetuar Pedido'
  ),
  (
    295,
    'gb',
    'checkout.form.firstname.placeholder',
    'John'
  ),
  (
    296,
    'pt',
    'checkout.form.firstname.placeholder',
    'John'
  ),
  (
    297,
    'gb',
    'checkout.form.lastname.placeholder',
    'Doe'
  ),
  (
    298,
    'pt',
    'checkout.form.lastname.placeholder',
    'Doe'
  ),
  (
    299,
    'gb',
    'checkout.form.email.placeholder',
    'example@email.com'
  ),
  (
    300,
    'pt',
    'checkout.form.email.placeholder',
    'exemplo@email.com'
  ),
  (
    301,
    'gb',
    'checkout.form.mobile.placeholder',
    '+123 456 789'
  ),
  (
    302,
    'pt',
    'checkout.form.mobile.placeholder',
    '+123 456 789'
  ),
  (
    303,
    'gb',
    'checkout.form.address1.placeholder',
    '123 Street'
  ),
  (
    304,
    'pt',
    'checkout.form.address1.placeholder',
    'Rua 123'
  ),
  (
    305,
    'gb',
    'checkout.form.address2.placeholder',
    '123 Street'
  ),
  (
    306,
    'pt',
    'checkout.form.address2.placeholder',
    'Rua 123'
  ),
  (
    307,
    'gb',
    'checkout.form.city.placeholder',
    'New York'
  ),
  (
    308,
    'pt',
    'checkout.form.city.placeholder',
    'Lisboa'
  ),
  (
    309,
    'gb',
    'checkout.form.state.placeholder',
    'New York'
  ),
  (
    310,
    'pt',
    'checkout.form.state.placeholder',
    'Lisboa'
  ),
  (311, 'gb', 'checkout.form.zip.placeholder', '123'),
  (312, 'pt', 'checkout.form.zip.placeholder', '123'),
  (335, 'gb', 'header.topbar.faqs', 'FAQs'),
  (336, 'pt', 'header.topbar.faqs', 'FAQs'),
  (337, 'gb', 'header.topbar.help', 'Help'),
  (338, 'pt', 'header.topbar.help', 'Ajuda'),
  (339, 'gb', 'header.topbar.support', 'Support'),
  (340, 'pt', 'header.topbar.support', 'Suporte'),
  (341, 'gb', 'header.lang.pt', 'PT'),
  (342, 'pt', 'header.lang.pt', 'PT'),
  (343, 'gb', 'header.lang.en', 'EN'),
  (344, 'pt', 'header.lang.en', 'EN'),
  (345, 'gb', 'header.brand.name', 'DaniShopper'),
  (346, 'pt', 'header.brand.name', 'DaniShopper'),
  (
    347,
    'gb',
    'header.search.placeholder',
    'Search for products'
  ),
  (
    348,
    'pt',
    'header.search.placeholder',
    'Pesquisar produtos'
  ),
  (349, 'gb', 'header.nav.home', 'Home'),
  (350, 'pt', 'header.nav.home', 'Início'),
  (351, 'gb', 'header.nav.shop', 'Shop'),
  (352, 'pt', 'header.nav.shop', 'Loja'),
  (353, 'gb', 'header.nav.contact', 'Contact'),
  (354, 'pt', 'header.nav.contact', 'Contacto'),
  (355, 'gb', 'header.nav.login', 'Login'),
  (356, 'pt', 'header.nav.login', 'Iniciar sessão'),
  (357, 'gb', 'header.nav.register', 'Register'),
  (358, 'pt', 'header.nav.register', 'Registar'),
  (
    359,
    'gb',
    'header.categories.title',
    'Categories'
  ),
  (
    360,
    'pt',
    'header.categories.title',
    'Categorias'
  ),
  (361, 'gb', 'footer.brand.name', 'DaniShopper'),
  (362, 'pt', 'footer.brand.name', 'DaniShopper'),
  (
    363,
    'gb',
    'footer.description',
    'Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.'
  ),
  (
    364,
    'pt',
    'footer.description',
    'Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.'
  ),
  (
    365,
    'gb',
    'footer.quick_links.title',
    'Quick Links'
  ),
  (
    366,
    'pt',
    'footer.quick_links.title',
    'Links Rápidos'
  ),
  (367, 'gb', 'footer.quick_links.home', 'Home'),
  (368, 'pt', 'footer.quick_links.home', 'Início'),
  (369, 'gb', 'footer.quick_links.shop', 'Our Shop'),
  (
    370,
    'pt',
    'footer.quick_links.shop',
    'A Nossa Loja'
  ),
  (
    371,
    'gb',
    'footer.quick_links.cart',
    'Shopping Cart'
  ),
  (
    372,
    'pt',
    'footer.quick_links.cart',
    'Carrinho de Compras'
  ),
  (
    373,
    'gb',
    'footer.quick_links.contact',
    'Contact Us'
  ),
  (
    374,
    'pt',
    'footer.quick_links.contact',
    'Contacte-nos'
  ),
  (
    375,
    'gb',
    'footer.newsletter.title',
    'Newsletter'
  ),
  (
    376,
    'pt',
    'footer.newsletter.title',
    'Newsletter'
  ),
  (
    377,
    'gb',
    'footer.newsletter.name_placeholder',
    'Your Name'
  ),
  (
    378,
    'pt',
    'footer.newsletter.name_placeholder',
    'O seu Nome'
  ),
  (
    379,
    'gb',
    'footer.newsletter.email_placeholder',
    'Your Email'
  ),
  (
    380,
    'pt',
    'footer.newsletter.email_placeholder',
    'O seu Email'
  ),
  (
    381,
    'gb',
    'footer.newsletter.button',
    'Subscribe Now'
  ),
  (
    382,
    'pt',
    'footer.newsletter.button',
    'Subscrever Agora'
  ),
  (
    383,
    'gb',
    'footer.copyright.site_name',
    'DaniShopper'
  ),
  (
    384,
    'pt',
    'footer.copyright.site_name',
    'DaniShopper'
  ),
  (
    385,
    'gb',
    'footer.copyright.rights',
    'All Rights Reserved.'
  ),
  (
    386,
    'pt',
    'footer.copyright.rights',
    'Todos os Direitos Reservados.'
  ),
  (
    387,
    'gb',
    'footer.copyright.designed_by',
    'Designed by'
  ),
  (
    388,
    'pt',
    'footer.copyright.designed_by',
    'Desenhado por'
  ),
  (
    389,
    'gb',
    'footer.copyright.distributed_by',
    'Distributed By'
  ),
  (
    390,
    'pt',
    'footer.copyright.distributed_by',
    'Distribuído por'
  ),
  (
    391,
    'gb',
    'footer.payments_image',
    'img/payments.png'
  ),
  (
    392,
    'pt',
    'footer.payments_image',
    'img/payments.png'
  ),
  (393, 'gb', 'home.categories.products', 'Products'),
  (394, 'pt', 'home.categories.products', 'Produtos'),
  (
    395,
    'gb',
    'products.buttons.detail',
    'View Detail'
  ),
  (
    396,
    'pt',
    'products.buttons.detail',
    'Ver Detalhe'
  ),
  (
    397,
    'gb',
    'products.buttons.add_to_cart',
    'Add To Cart'
  ),
  (
    398,
    'pt',
    'products.buttons.add_to_cart',
    'Pôr No Carrinho'
  ),
  (399, 'gb', 'login.header.title', 'Login'),
  (400, 'pt', 'login.header.title', 'Iniciar Sessão'),
  (401, 'gb', 'login.header.breadcrumb_home', 'Home'),
  (
    402,
    'pt',
    'login.header.breadcrumb_home',
    'Início'
  ),
  (
    403,
    'gb',
    'login.header.breadcrumb_login',
    'Login'
  ),
  (
    404,
    'pt',
    'login.header.breadcrumb_login',
    'Iniciar Sessão'
  ),
  (405, 'gb', 'login.card.title', 'Login'),
  (406, 'pt', 'login.card.title', 'Entrar'),
  (
    407,
    'gb',
    'login.error.empty_fields',
    'Please fill in all fields'
  ),
  (
    408,
    'pt',
    'login.error.empty_fields',
    'Por favor preencha todos os campos'
  ),
  (
    409,
    'gb',
    'login.error.invalid_credentials',
    'Invalid email or password'
  ),
  (
    410,
    'pt',
    'login.error.invalid_credentials',
    'Email ou password inválidos'
  ),
  (411, 'gb', 'login.form.email_label', 'Email'),
  (412, 'pt', 'login.form.email_label', 'Email'),
  (
    413,
    'gb',
    'login.form.password_label',
    'Password'
  ),
  (
    414,
    'pt',
    'login.form.password_label',
    'Palavra-passe'
  ),
  (
    415,
    'gb',
    'login.form.email_placeholder',
    'Enter your email'
  ),
  (
    416,
    'pt',
    'login.form.email_placeholder',
    'Introduza o seu email'
  ),
  (
    417,
    'gb',
    'login.form.password_placeholder',
    'Enter your password'
  ),
  (
    418,
    'pt',
    'login.form.password_placeholder',
    'Introduza a sua palavra-passe'
  ),
  (419, 'gb', 'login.form.submit_button', 'Login'),
  (420, 'pt', 'login.form.submit_button', 'Entrar'),
  (
    421,
    'gb',
    'login.footer.no_account',
    'Don\'t have an account?'
  ),
  (
    422,
    'pt',
    'login.footer.no_account',
    'Não tem conta?'
  ),
  (
    423,
    'gb',
    'login.footer.register_link',
    'Register here'
  ),
  (
    424,
    'pt',
    'login.footer.register_link',
    'Registe-se aqui'
  ),
  (425, 'gb', 'register.header.title', 'Register'),
  (426, 'pt', 'register.header.title', 'Registar'),
  (
    427,
    'gb',
    'register.header.breadcrumb_home',
    'Home'
  ),
  (
    428,
    'pt',
    'register.header.breadcrumb_home',
    'Início'
  ),
  (
    429,
    'gb',
    'register.header.breadcrumb_register',
    'Register'
  ),
  (
    430,
    'pt',
    'register.header.breadcrumb_register',
    'Registar'
  ),
  (
    431,
    'gb',
    'register.card.title',
    'Create Account'
  ),
  (432, 'pt', 'register.card.title', 'Criar Conta'),
  (
    433,
    'gb',
    'register.error.empty_fields',
    'Please fill in all required fields'
  ),
  (
    434,
    'pt',
    'register.error.empty_fields',
    'Por favor preencha todos os campos obrigatórios'
  ),
  (
    435,
    'gb',
    'register.error.invalid_email',
    'Invalid email address'
  ),
  (
    436,
    'pt',
    'register.error.invalid_email',
    'Email inválido'
  ),
  (
    437,
    'gb',
    'register.error.email_exists',
    'This email is already registered'
  ),
  (
    438,
    'pt',
    'register.error.email_exists',
    'Este email já está registado'
  ),
  (
    439,
    'gb',
    'register.error.generic',
    'An error occurred. Please try again'
  ),
  (
    440,
    'pt',
    'register.error.generic',
    'Ocorreu um erro. Por favor tente novamente'
  ),
  (
    441,
    'gb',
    'register.form.first_name_label',
    'First Name'
  ),
  (
    442,
    'pt',
    'register.form.first_name_label',
    'Nome'
  ),
  (
    443,
    'gb',
    'register.form.last_name_label',
    'Last Name'
  ),
  (
    444,
    'pt',
    'register.form.last_name_label',
    'Apelido'
  ),
  (445, 'gb', 'register.form.email_label', 'Email'),
  (446, 'pt', 'register.form.email_label', 'Email'),
  (447, 'gb', 'register.form.mobile_label', 'Mobile'),
  (
    448,
    'pt',
    'register.form.mobile_label',
    'Telemóvel'
  ),
  (
    449,
    'gb',
    'register.form.password_label',
    'Password'
  ),
  (
    450,
    'pt',
    'register.form.password_label',
    'Palavra-passe'
  ),
  (
    451,
    'gb',
    'register.form.first_name_placeholder',
    'Enter your first name'
  ),
  (
    452,
    'pt',
    'register.form.first_name_placeholder',
    'Introduza o seu nome'
  ),
  (
    453,
    'gb',
    'register.form.last_name_placeholder',
    'Enter your last name'
  ),
  (
    454,
    'pt',
    'register.form.last_name_placeholder',
    'Introduza o seu apelido'
  ),
  (
    455,
    'gb',
    'register.form.email_placeholder',
    'Enter your email'
  ),
  (
    456,
    'pt',
    'register.form.email_placeholder',
    'Introduza o seu email'
  ),
  (
    457,
    'gb',
    'register.form.mobile_placeholder',
    'Enter your phone number'
  ),
  (
    458,
    'pt',
    'register.form.mobile_placeholder',
    'Introduza o seu número de telemóvel'
  ),
  (
    459,
    'gb',
    'register.form.password_placeholder',
    'Create a password'
  ),
  (
    460,
    'pt',
    'register.form.password_placeholder',
    'Crie uma palavra-passe'
  ),
  (
    461,
    'gb',
    'register.form.submit_button',
    'Register'
  ),
  (
    462,
    'pt',
    'register.form.submit_button',
    'Registar'
  ),
  (
    463,
    'gb',
    'register.footer.has_account',
    'Already have an account?'
  ),
  (
    464,
    'pt',
    'register.footer.has_account',
    'Já tem conta?'
  ),
  (
    465,
    'gb',
    'register.footer.login_link',
    'Login here'
  ),
  (
    466,
    'pt',
    'register.footer.login_link',
    'Entre aqui'
  ),
  (467, 'gb', 'header.nav.logout', 'Logout'),
  (468, 'pt', 'header.nav.logout', 'Terminar Sessão'),
  (469, 'gb', 'cart.table.empty', 'Cart is empty'),
  (470, 'pt', 'cart.table.empty', 'Carrinho vazio'),
  (
    471,
    'gb',
    'cart.merge.modal_title',
    'Merge carts?'
  ),
  (
    472,
    'pt',
    'cart.merge.modal_title',
    'Juntar os carrinhos?'
  ),
  (
    473,
    'gb',
    'cart.merge.modal_body',
    'You have items in your cart, would you like to keep them?'
  ),
  (
    474,
    'pt',
    'cart.merge.modal_body',
    'Tem items no seu carrinho, deseja mantê-los?'
  ),
  (475, 'gb', 'cart.merge.btn_merge', 'Merge'),
  (476, 'pt', 'cart.merge.btn_merge', 'Juntar'),
  (477, 'gb', 'cart.merge.btn_discard', 'Discard'),
  (478, 'pt', 'cart.merge.btn_discard', 'Descartar'),
  (
    479,
    'pt',
    'order_success.header.title',
    'Encomenda Concluída'
  ),
  (
    480,
    'gb',
    'order_success.header.title',
    'Order Completed'
  ),
  (
    481,
    'pt',
    'order_success.header.breadcrumb_home',
    'Início'
  ),
  (
    482,
    'gb',
    'order_success.header.breadcrumb_home',
    'Home'
  ),
  (
    483,
    'pt',
    'order_success.header.breadcrumb_success',
    'Sucesso'
  ),
  (
    484,
    'gb',
    'order_success.header.breadcrumb_success',
    'Success'
  ),
  (
    485,
    'pt',
    'order_success.thank_you',
    'Obrigado pela sua encomenda!'
  ),
  (
    486,
    'gb',
    'order_success.thank_you',
    'Thank you for your order!'
  ),
  (
    487,
    'pt',
    'order_success.confirmation_message',
    'A sua encomenda foi registada com sucesso. Iremos processá-la em breve.'
  ),
  (
    488,
    'gb',
    'order_success.confirmation_message',
    'Your order has been successfully placed. We will process it shortly.'
  ),
  (
    489,
    'pt',
    'order_success.order_number',
    'Número da encomenda'
  ),
  (
    490,
    'gb',
    'order_success.order_number',
    'Order number'
  ),
  (
    491,
    'pt',
    'order_success.continue_shopping',
    'Continuar a comprar'
  ),
  (
    492,
    'gb',
    'order_success.continue_shopping',
    'Continue shopping'
  ),
  (
    493,
    'gb',
    'checkout.form.country.select',
    'Select a country'
  ),
  (
    494,
    'pt',
    'checkout.form.country.select',
    'Selecione um país'
  ),
  (495, 'gb', 'shop.filters.apply', 'Apply Filters'),
  (
    496,
    'pt',
    'shop.filters.apply',
    'Aplicar Filtros'
  ),
  (
    497,
    'gb',
    'contact.info.no_stores',
    'There are no stores available'
  ),
  (
    498,
    'pt',
    'contact.info.no_stores',
    'Não há lojas disponíveis'
  ),
  (
    499,
    'gb',
    'contact.form.success',
    'Message sent with success'
  ),
  (
    500,
    'pt',
    'contact.form.success',
    'Mensagem enviada com sucesso'
  ),
  (501, 'pt', 'menu.about', 'Sobre Nós'),
  (502, 'gb', 'menu.about', 'About Us'),
  (503, 'pt', 'menu.news', 'Notícias'),
  (504, 'gb', 'menu.news', 'News'),
  (505, 'pt', 'news.read_more', 'Ler Mais'),
  (506, 'gb', 'news.read_more', 'Read More'),
  (507, 'pt', 'news.latest', 'Últimas Notícias'),
  (508, 'gb', 'news.latest', 'Latest News'),
  (509, 'pt', 'news.back_to_list', 'Voltar à lista'),
  (510, 'gb', 'news.back_to_list', 'Back to list'),
  (
    511,
    'pt',
    'news.empty_list',
    'Nenhuma notícia encontrada.'
  ),
  (512, 'gb', 'news.empty_list', 'No news found.'),
  (533, 'pt', 'about.title', 'Sobre Nós'),
  (534, 'gb', 'about.title', 'About Us'),
  (535, 'pt', 'about.subtitle', 'A Nossa História'),
  (536, 'gb', 'about.subtitle', 'Our Story'),
  (
    537,
    'pt',
    'about.text_1',
    'Bem-vindo à Danishopper. Começámos com uma pequena ideia e crescemos para nos tornarmos uma referência no mercado e-commerce.'
  ),
  (
    538,
    'gb',
    'about.text_1',
    'Welcome to Danishopper. We started with a small idea and grew to become a reference in the e-commerce market.'
  ),
  (
    539,
    'pt',
    'about.text_2',
    'O nosso compromisso é com a qualidade e a satisfação do cliente. Trabalhamos todos os dias para lhe trazer as últimas tendências.'
  ),
  (
    540,
    'gb',
    'about.text_2',
    'Our commitment is to quality and customer satisfaction. We work every day to bring you the latest trends.'
  ),
  (
    541,
    'gb',
    'detail.product.reviews_count_label',
    'Reviews'
  ),
  (
    542,
    'pt',
    'detail.product.reviews_count_label',
    'Avaliações'
  ),
  (
    543,
    'gb',
    'detail.reviews.reviews_for_title',
    'reviews for'
  ),
  (
    544,
    'pt',
    'detail.reviews.reviews_for_title',
    'avaliações para'
  ),
  (
    545,
    'gb',
    'detail.reviews.no_reviews',
    'No reviews yet. Be the first to review this product!'
  ),
  (
    546,
    'pt',
    'detail.reviews.no_reviews',
    'Ainda não há avaliações. Seja o primeiro a avaliar este produto!'
  ),
  (
    547,
    'gb',
    'detail.reviews.success_message',
    'Your review has been submitted and is awaiting approval.'
  ),
  (
    548,
    'pt',
    'detail.reviews.success_message',
    'A sua avaliação foi submetida e aguarda aprovação.'
  ),
  (
    549,
    'gb',
    'detail.reviews.error_missing_fields',
    'Please fill all required fields and select a rating.'
  ),
  (
    550,
    'pt',
    'detail.reviews.error_missing_fields',
    'Por favor, preencha todos os campos obrigatórios e selecione uma classificação.'
  ),
  (
    551,
    'gb',
    'detail.reviews.error_db_error',
    'An error occurred while saving your review. Please try again.'
  ),
  (
    552,
    'pt',
    'detail.reviews.error_db_error',
    'Ocorreu um erro ao guardar a sua avaliação. Por favor, tente novamente.'
  ),
  (
    553,
    'gb',
    'detail.reviews.logged_as',
    'Logged in as'
  ),
  (
    554,
    'pt',
    'detail.reviews.logged_as',
    'Sessão iniciada como'
  ),
  (
    555,
    'gb',
    'shop.sidebar.filter_category_title',
    'Filter by category'
  ),
  (
    556,
    'pt',
    'shop.sidebar.filter_category_title',
    'Filtrar por categoria'
  ),
  (
    557,
    'gb',
    'shop.products.sort_price_desc',
    'Price High to Low'
  ),
  (
    558,
    'pt',
    'shop.products.sort_price_desc',
    'Preço Descendente'
  ),
  (
    559,
    'gb',
    'login.error.access_denied',
    'Access Denied: You do not have permission to access the backoffice.'
  ),
  (
    560,
    'pt',
    'login.error.access_denied',
    'Acesso negado: Não tem permissão para aceder ao backoffice.'
  ),
  (
    573,
    'pt',
    'detail.product.add_to_wishlist',
    'Adicionar aos Favoritos'
  ),
  (
    574,
    'gb',
    'detail.product.add_to_wishlist',
    'Add to Wishlist'
  ),
  (
    575,
    'pt',
    'detail.product.remove_from_wishlist',
    'Remover dos Favoritos'
  ),
  (
    576,
    'gb',
    'detail.product.remove_from_wishlist',
    'Remove from Wishlist'
  ),
  (577, 'pt', 'wishlist.title', 'Os Meus Favoritos'),
  (578, 'gb', 'wishlist.title', 'My Wishlist'),
  (
    579,
    'pt',
    'wishlist.empty',
    'A sua lista de favoritos está vazia.'
  ),
  (
    580,
    'gb',
    'wishlist.empty',
    'Your wishlist is empty.'
  ),
  (
    581,
    'pt',
    'wishlist.header.breadcrumb_home',
    'Início'
  ),
  (
    582,
    'gb',
    'wishlist.header.breadcrumb_home',
    'Home'
  ),
  (
    583,
    'pt',
    'wishlist.header.breadcrumb_wishlist',
    'Favoritos'
  ),
  (
    584,
    'gb',
    'wishlist.header.breadcrumb_wishlist',
    'Wishlist'
  ),
  (
    585,
    'pt',
    'error.out_of_stock',
    'Desculpe, não temos stock suficiente para este produto.'
  ),
  (
    586,
    'gb',
    'error.out_of_stock',
    'Sorry, we do not have enough stock for this product.'
  ),
  (
    587,
    'pt',
    'error.out_of_stock_max',
    'Stock insuficiente. O máximo disponível é: '
  ),
  (
    588,
    'gb',
    'error.out_of_stock_max',
    'Insufficient stock. The maximum available is: '
  ),
  (589, 'gb', 'header.nav.profile', 'My Profile'),
  (590, 'pt', 'header.nav.profile', 'O Meu Perfil'),
  (591, 'gb', 'header.nav.orders', 'My Orders'),
  (
    592,
    'pt',
    'header.nav.orders',
    'As Minhas Encomendas'
  ),
  (593, 'gb', 'header.nav.wishlist', 'Wishlist'),
  (
    594,
    'pt',
    'header.nav.wishlist',
    'Lista de Desejos'
  ),
  (595, 'gb', 'profile.header.title', 'My Account'),
  (
    596,
    'pt',
    'profile.header.title',
    'A Minha Conta'
  ),
  (597, 'gb', 'profile.menu.dashboard', 'Dashboard'),
  (598, 'pt', 'profile.menu.dashboard', 'Painel'),
  (599, 'gb', 'profile.menu.orders', 'Orders'),
  (600, 'pt', 'profile.menu.orders', 'Encomendas'),
  (601, 'gb', 'profile.menu.settings', 'Settings'),
  (602, 'pt', 'profile.menu.settings', 'Definições'),
  (
    603,
    'gb',
    'profile.stats.total_orders',
    'Total Orders'
  ),
  (
    604,
    'pt',
    'profile.stats.total_orders',
    'Total Encomendas'
  ),
  (
    605,
    'gb',
    'profile.stats.total_spent',
    'Total Spent'
  ),
  (
    606,
    'pt',
    'profile.stats.total_spent',
    'Total Gasto'
  ),
  (
    607,
    'gb',
    'profile.settings.personal_info',
    'Personal Information'
  ),
  (
    608,
    'pt',
    'profile.settings.personal_info',
    'Informação Pessoal'
  ),
  (
    609,
    'gb',
    'profile.settings.security',
    'Security & Password'
  ),
  (
    610,
    'pt',
    'profile.settings.security',
    'Segurança e Password'
  ),
  (
    611,
    'gb',
    'profile.settings.first_name',
    'First Name'
  ),
  (612, 'pt', 'profile.settings.first_name', 'Nome'),
  (
    613,
    'gb',
    'profile.settings.last_name',
    'Last Name'
  ),
  (
    614,
    'pt',
    'profile.settings.last_name',
    'Apelido'
  ),
  (
    615,
    'gb',
    'profile.settings.email',
    'Email Address'
  ),
  (
    616,
    'pt',
    'profile.settings.email',
    'Endereþo de Email'
  ),
  (
    617,
    'gb',
    'profile.settings.current_password',
    'Current Password'
  ),
  (
    618,
    'pt',
    'profile.settings.current_password',
    'Password Atual'
  ),
  (
    619,
    'gb',
    'profile.settings.new_password',
    'New Password'
  ),
  (
    620,
    'pt',
    'profile.settings.new_password',
    'Nova Password'
  ),
  (
    621,
    'gb',
    'profile.settings.confirm_password',
    'Confirm New Password'
  ),
  (
    622,
    'pt',
    'profile.settings.confirm_password',
    'Confirmar Nova Password'
  ),
  (
    623,
    'gb',
    'profile.settings.btn_save',
    'Save Changes'
  ),
  (
    624,
    'pt',
    'profile.settings.btn_save',
    'Guardar Alterações'
  ),
  (625, 'gb', 'profile.orders.table.id', 'Order #'),
  (
    626,
    'pt',
    'profile.orders.table.id',
    'Encomenda #'
  ),
  (627, 'gb', 'profile.orders.table.date', 'Date'),
  (628, 'pt', 'profile.orders.table.date', 'Data'),
  (629, 'gb', 'profile.orders.table.total', 'Total'),
  (630, 'pt', 'profile.orders.table.total', 'Total'),
  (
    631,
    'gb',
    'profile.orders.table.status',
    'Status'
  ),
  (
    632,
    'pt',
    'profile.orders.table.status',
    'Estado'
  ),
  (
    633,
    'gb',
    'profile.orders.table.actions',
    'Actions'
  ),
  (
    634,
    'pt',
    'profile.orders.table.actions',
    'Ações'
  ),
  (
    635,
    'gb',
    'profile.orders.view_details',
    'View Details'
  ),
  (
    636,
    'pt',
    'profile.orders.view_details',
    'Ver Detalhes'
  ),
  (
    637,
    'gb',
    'profile.orders.empty',
    'You haven\'t placed any orders yet.'
  ),
  (
    638,
    'pt',
    'profile.orders.empty',
    'Ainda não realizou nenhuma encomenda.'
  ),
  (639, 'gb', 'profile.dashboard.greeting', 'Hello'),
  (640, 'pt', 'profile.dashboard.greeting', 'Olá'),
  (
    641,
    'gb',
    'profile.dashboard.member_since',
    'Member since'
  ),
  (
    642,
    'pt',
    'profile.dashboard.member_since',
    'Membro desde'
  ),
  (
    643,
    'gb',
    'profile.dashboard.recent_orders',
    'Recent Orders'
  ),
  (
    644,
    'pt',
    'profile.dashboard.recent_orders',
    'Encomendas Recentes'
  ),
  (
    645,
    'gb',
    'profile.orders.shipping_address',
    'Shipping Address'
  ),
  (
    646,
    'pt',
    'profile.orders.shipping_address',
    'Morada de Envio'
  ),
  (
    647,
    'gb',
    'profile.orders.btn_shop',
    'Start Shopping'
  ),
  (
    648,
    'pt',
    'profile.orders.btn_shop',
    'Começar a Comprar'
  ),
  (
    649,
    'gb',
    'profile.settings.mobile',
    'Mobile Number'
  ),
  (650, 'pt', 'profile.settings.mobile', 'Telemóvel'),
  (651, 'gb', 'profile.orders.items', 'Items'),
  (652, 'pt', 'profile.orders.items', 'Itens'),
  (
    653,
    'gb',
    'forgot_password.title',
    'Forgot Password'
  ),
  (
    654,
    'pt',
    'forgot_password.title',
    'Recuperar Palavra-passe'
  ),
  (
    655,
    'gb',
    'forgot_password.instruction',
    'Enter your email address and we will send you a link to reset your password.'
  ),
  (
    656,
    'pt',
    'forgot_password.instruction',
    'Introduza o seu e-mail e enviaremos um link para redefinir a sua palavra-passe.'
  ),
  (
    657,
    'gb',
    'forgot_password.success',
    'If an account exists with this email, a recovery link has been sent.'
  ),
  (
    658,
    'pt',
    'forgot_password.success',
    'Se existir uma conta com este e-mail, foi enviado um link de recuperaþÒo.'
  ),
  (
    659,
    'gb',
    'forgot_password.link',
    'Forgot Password?'
  ),
  (
    660,
    'pt',
    'forgot_password.link',
    'Esqueceu-se da palavra-passe?'
  ),
  (
    661,
    'gb',
    'reset_password.title',
    'Reset Password'
  ),
  (
    662,
    'pt',
    'reset_password.title',
    'Redefinir Palavra-passe'
  ),
  (
    663,
    'gb',
    'reset_password.new_password',
    'New Password'
  ),
  (
    664,
    'pt',
    'reset_password.new_password',
    'Nova Palavra-passe'
  ),
  (
    665,
    'gb',
    'reset_password.confirm_password',
    'Confirm New Password'
  ),
  (
    666,
    'pt',
    'reset_password.confirm_password',
    'Confirmar Nova Palavra-passe'
  ),
  (
    667,
    'gb',
    'reset_password.success',
    'Your password has been reset successfully. You can now login.'
  ),
  (
    668,
    'pt',
    'reset_password.success',
    'A sua palavra-passe foi redefinida com sucesso. Jß pode iniciar sessÒo.'
  ),
  (
    669,
    'gb',
    'reset_password.error.invalid_token',
    'Invalid or expired token.'
  ),
  (
    670,
    'pt',
    'reset_password.error.invalid_token',
    'Link invßlido ou expirado.'
  ),
  (
    671,
    'gb',
    'reset_password.error.mismatch',
    'Passwords do not match.'
  ),
  (
    672,
    'pt',
    'reset_password.error.mismatch',
    'As palavras-passe nÒo coincidem.'
  ),
  (
    673,
    'gb',
    'forgot_password.rate_limited',
    'Too many requests. Please try again later.'
  ),
  (
    674,
    'pt',
    'forgot_password.rate_limited',
    'Demasiados pedidos. Por favor, tente mais tarde.'
  );

/*!40000 ALTER TABLE `traduz` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `users` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `first_name` varchar(100) DEFAULT NULL,
    `last_name` varchar(100) DEFAULT NULL,
    `email` varchar(150) NOT NULL,
    `password` varchar(255) NOT NULL,
    `mobile` varchar(30) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `is_admin` tinyint (1) DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--
LOCK TABLES `users` WRITE;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO
  `users`
VALUES
  (
    1,
    'John',
    'Doe',
    'john@example.com',
    '$2y$10$hash1',
    '912345678',
    '2026-05-02 16:52:58',
    0
  ),
  (
    2,
    'Maria',
    'Silva',
    'maria@example.com',
    '$2y$10$hash2',
    '934567890',
    '2026-05-02 16:52:58',
    0
  ),
  (
    3,
    'Daniel',
    'Silva',
    'daniel.school.37@gmail.com',
    '$2y$10$QblM/RXqCAbqhdfNC5kn7O6hMABvbXA5rNAxRmN4YCaBvIJDZ4UOq',
    '',
    '2026-05-02 19:43:35',
    0
  ),
  (
    4,
    'Super',
    'User',
    'bjrajafju@gmail.com',
    '$2y$10$EIksbewMF/.5/QFNIHKet.tjUD2fiX2SMgNmL4DTJi0osRONUxxaG',
    '932329389',
    '2026-05-04 10:28:13',
    1
  ),
  (
    5,
    'Admin',
    'User',
    'admin@gmail.com',
    '$2y$10$jOybPtAkqVLyV0c/T15yy.8CaOSo63ghgjngmuIWTFsWu0R2O0TF6',
    '123456789',
    '2026-05-14 08:58:32',
    1
  );

/*!40000 ALTER TABLE `users` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Table structure for table `wishlist`
--
DROP TABLE IF EXISTS `wishlist`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;

/*!50503 SET character_set_client = utf8mb4 */;

CREATE TABLE
  `wishlist` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `user_id` int (11) NOT NULL,
    `product_id` int (11) NOT NULL,
    `created_at` datetime DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_id` (`user_id`, `product_id`),
    KEY `product_id` (`product_id`),
    CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
  ) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--
LOCK TABLES `wishlist` WRITE;

/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;

INSERT INTO
  `wishlist`
VALUES
  (2, 4, 6, '2026-05-07 19:34:28'),
  (3, 4, 5, '2026-05-07 19:34:48'),
  (4, 4, 3, '2026-05-12 12:16:41');

/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;

UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-14  9:33:56
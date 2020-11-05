-- MySQL dump 10.13  Distrib 5.7.31, for Linux (x86_64)
--
-- Host: localhost    Database: taskforce
-- ------------------------------------------------------
-- Server version	5.7.31-0ubuntu0.18.04.1

DROP DATABASE `taskforce`;
CREATE DATABASE /*!32312 IF NOT EXISTS*/ `taskforce` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `taskforce`;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `icon` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `lattitude` float DEFAULT NULL,
  `longtitude` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `task_chats`;
CREATE TABLE `task_chats` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `message` text,
  PRIMARY KEY (`id`),
  KEY `fk_task_messages_tasks_idx` (`task_id`),
  KEY `fk_task_messages_users_idx` (`user_id`),
  CONSTRAINT `fk_task_messages_tasks` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_task_messages_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `task_responses`;
CREATE TABLE `task_responses` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL,
  `amount` decimal(12,4) DEFAULT NULL,
  `comment` text,
  `evaluation` tinyint(1) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_task_requests_task_idx` (`task_id`),
  KEY `fk_task_requests_user_idx` (`user_id`),
  CONSTRAINT `fk_task_requests_tasks` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_task_requests_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int unsigned NOT NULL,
  `customer_user_id` int unsigned NOT NULL,
  `performer_user_id` int unsigned NULL,
  `category_id` int unsigned NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` text NOT NULL,
  `additional_info` text,
  `address` text,
  `status` enum('NEW','CANCELED','INPROGRESS','COMPLETE','FAIL') NOT NULL DEFAULT 'NEW',
  `budget` decimal(12,4) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `start_date` date DEFAULT NULL,
  `lattitude` float DEFAULT NULL,
  `longtitude` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_start_date` (`start_date`),
  KEY `fk_tasks_categories_idx` (`category_id`),
  KEY `fk_tasks_cities_idx` (`city_id`),
  KEY `fk_tasks_customer_idx` (`customer_user_id`),
  KEY `fk_tasks_performer_idx` (`performer_user_id`),
  CONSTRAINT `fk_tasks_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_tasks_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_tasks_users_customer` FOREIGN KEY (`customer_user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_tasks_users_performer` FOREIGN KEY (`performer_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user_attachments`;
CREATE TABLE `user_attachments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `task_id` int unsigned DEFAULT NULL,
  `display_name` varchar(256) NOT NULL,
  `file_name` text NOT NULL,
  `file_path` text,
  `file_meta` longtext,
  `thumb_path` text,
  PRIMARY KEY (`id`),
  KEY `fk_user_attachments_users_idx` (`user_id`),
  KEY `fk_user_attachments_tasks_idx` (`task_id`),
  CONSTRAINT `fk_attachments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_user_attachments_tasks` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user_categories`;
CREATE TABLE `user_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `category_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`,`user_id`,`category_id`),
  KEY `fk_user_categories_category_idx` (`category_id`),
  KEY `fk_user_categories_user_idx` (`user_id`),
  CONSTRAINT `fk_user_categories_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_user_categories_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user_favorites`;
CREATE TABLE `user_favorites` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `favorite_user_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_favorite_id` (`favorite_user_id`),
  CONSTRAINT `fk_user_favorites_user` FOREIGN KEY (`favorite_user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user_notifications`;
CREATE TABLE `user_notifications` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `new_message` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `new_respond` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `task_actions` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_user_notify_users_idx` (`user_id`),
  CONSTRAINT `fk_user_notify_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE `user_profile` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `about` text DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `gender` enum('MALE','FEMALE') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `phone` varchar(90) DEFAULT NULL,
  `skype` varchar(90) DEFAULT NULL,
  `telegramm` varchar(90) DEFAULT NULL,
  `avatar` varchar(45) DEFAULT NULL,
  `views` INT unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int unsigned NOT NULL,
  `profile_id` int unsigned DEFAULT NULL,
  `email` varchar(245) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `token` varchar(256) DEFAULT NULL,
  `is_profile_public` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_contact_public` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_logined_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uidx_email` (`email`),
  KEY `fk_users_cities_idx` (`city_id`),
  KEY `fk_users_profile_idx` (`profile_id`),
  CONSTRAINT `fk_users_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_profile` FOREIGN KEY (`profile_id`) REFERENCES `user_profile` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS=1;
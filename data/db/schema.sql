-- Host: localhost    Database: taskforce
-- ------------------------------------------------------
-- Ver 14.14 Distrib 5.7.32, for Linux (x86_64) using  EditLine wrapper

DROP DATABASE `taskforce`;
CREATE DATABASE /*!32312 IF NOT EXISTS*/ `taskforce` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `taskforce`;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `icon` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `lattitude` float DEFAULT NULL,
  `longtitude` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `task_chats`;
CREATE TABLE `task_chats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `message` text,
  PRIMARY KEY (`id`),
  KEY `fk_task_messages_tasks_idx` (`task_id`),
  KEY `fk_task_messages_users_idx` (`user_id`),
  CONSTRAINT `fk_task_messages_tasks` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_task_messages_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Отклики на заданя
DROP TABLE IF EXISTS `task_responses`;
CREATE TABLE `task_responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned DEFAULT NULL,
  `performer_user_id` int(10) unsigned DEFAULT NULL COMMENT 'Испольнитель',
  `amount` decimal(12,4) DEFAULT NULL,
  `comment` text,
  `rate` tinyint(1) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_task_requests_task_idx` (`task_id`),
  KEY `fk_task_requests_performer_idx` (`performer_user_id`),
  CONSTRAINT `fk_task_requests_performer`
    FOREIGN KEY (`performer_user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_task_requests_tasks`
    FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Отклики на задания';

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `performer_user_id` int(10) unsigned DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `description` text NOT NULL,
  `additional_info` text,
  `address` text,
  `status` enum('NEW','CANCELED','INPROGRESS','COMPLETE','FAIL') NOT NULL DEFAULT 'NEW',
  `budget` decimal(12,4) unsigned DEFAULT NULL,
  `expire` date DEFAULT NULL,
  `lattitude` decimal(11,7) DEFAULT NULL,
  `longtitude` decimal(11,7) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `fk_tasks_categories_idx` (`category_id`),
  KEY `idx_expire` (`expire`),
  KEY `fk_tasks_customer_idx` (`user_id`),
  KEY `fk_tasks_performer_idx` (`performer_user_id`),
  CONSTRAINT `fk_tasks_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_tasks_customer` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tasks_performer` FOREIGN KEY (`performer_user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user_attachments`;
CREATE TABLE `user_attachments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `task_id` int(10) unsigned DEFAULT NULL,
  `display_name` varchar(256) NOT NULL,
  `file_name` text NOT NULL,
  `file_path` text,
  `file_meta` longtext,
  `thumb_path` text,
  PRIMARY KEY (`id`),
  KEY `fk_user_attachments_users_idx` (`user_id`),
  KEY `fk_user_attachments_tasks_idx` (`task_id`),
  CONSTRAINT `fk_attachments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_attachments_tasks` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user_categories`;
CREATE TABLE `user_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`user_id`,`category_id`),
  KEY `fk_user_categories_category_idx` (`category_id`),
  KEY `fk_user_categories_user_idx` (`user_id`),
  CONSTRAINT `fk_user_categories_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_user_categories_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user_favorites`;
CREATE TABLE `user_favorites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `favorite_user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_favorite_id` (`favorite_user_id`),
  CONSTRAINT `fk_user_favorites_user` FOREIGN KEY (`favorite_user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user_notifications`;
CREATE TABLE `user_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `new_message` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `new_respond` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `task_actions` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_user_notify_users_idx` (`user_id`),
  CONSTRAINT `fk_user_notify_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE `user_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `about` text,
  `gender` enum('MALE','FEMALE') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `phone` varchar(90) DEFAULT NULL,
  `skype` varchar(90) DEFAULT NULL,
  `telegramm` varchar(90) DEFAULT NULL,
  `avatar` varchar(45) DEFAULT NULL,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `address` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned DEFAULT NULL COMMENT 'Город',
  `profile_id` int(10) unsigned NOT NULL COMMENT 'Профиль',
  `name` varchar(45) DEFAULT NULL COMMENT 'Имя',
  `password` varchar(64) DEFAULT NULL COMMENT 'Пароль',
  `email` varchar(245) NOT NULL,
  `is_profile_public` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_contact_public` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_logined_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uidx_email` (`email`),
  KEY `fk_users_city_idx` (`city_id`),
  KEY `fk_users_profile_idx` (`profile_id`),
  CONSTRAINT `fk_users_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_profile` FOREIGN KEY (`profile_id`) REFERENCES `user_profile` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user_reviews`;
CREATE TABLE `user_reviews` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL COMMENT 'Customer',
  `related_task_id` int unsigned NOT NULL COMMENT 'Task',
  `rate` tinyint NOT NULL COMMENT 'Rating',
  `comment` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created',
  PRIMARY KEY (`id`),
  KEY `fk_user_reviews_users_id_idx` (`user_id`),
  KEY `fk_user_reviews_tasks_id_idx` (`task_id`),
  CONSTRAINT `fk_user_reviews_tasks` FOREIGN KEY (`related_task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `fk_user_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `fk_user_role_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS=1;
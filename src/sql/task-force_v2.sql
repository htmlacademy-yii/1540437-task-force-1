-- MySQL Workbench Synchronization
-- Generated: 2020-07-27 21:55
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Леха

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE TABLE IF NOT EXISTS `taskforce`.`users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `location_id` INT(10) UNSIGNED NOT NULL,
  `about` TEXT NULL DEFAULT NULL,
  `role` ENUM('CUSTOMER', 'PERFORMER') NOT NULL,
  `name` VARCHAR(245) NOT NULL,
  `email` VARCHAR(245) NOT NULL,
  `birt_date` DATE NULL DEFAULT NULL,
  `password_hash` VARCHAR(256) NOT NULL,
  `token` VARCHAR(256) NULL DEFAULT NULL,
  `rating` FLOAT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `location_id`),
  UNIQUE INDEX `idx_email` (`email` ASC),
  INDEX `idx_role` (`role` ASC),
  INDEX `fk_users_locations1_idx` (`location_id` ASC),
  CONSTRAINT `fk_users_locations1`
    FOREIGN KEY (`location_id`)
    REFERENCES `taskforce`.`locations` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`attachments` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NOT NULL,
  `type` ENUM('CHAT','TASK','OTHER') NOT NULL DEFAULT 'OTHER',
  `type_target_id` INT(10) UNSIGNED NOT NULL,
  `file_name` TEXT NOT NULL,
  `file_path` TEXT NULL DEFAULT NULL,
  `file_meta` LONGTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_type` (`type` ASC, `type_target_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`chats` (
  `id` INT(10) UNSIGNED NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `task_id` INT(10) UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE current_timestamp,
  `message` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_chat_task_idx` (`task_id` ASC),
  INDEX `fk_chat_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_chat_task`
    FOREIGN KEY (`task_id`)
    REFERENCES `taskforce`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_chat_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`locations` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_name` VARCHAR(256) NULL DEFAULT NULL,
  `city_region` VARCHAR(256) NULL DEFAULT NULL,
  `lattitude` FLOAT(11) NULL DEFAULT NULL,
  `longtitude` FLOAT(11) NULL DEFAULT NULL,
  `param` JSON NULL DEFAULT NULL COMMENT 'Параметры кординат в JSON формате',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`tasks` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` INT(10) UNSIGNED NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `user_location_id` INT(10) UNSIGNED NOT NULL,
  `title` VARCHAR(256) NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `addit_info` TEXT NULL DEFAULT NULL,
  `address` TEXT NULL DEFAULT NULL,
  `status` ENUM('NEW', 'CANCELED', 'INPROGRESS', 'COMPLETE', 'FAIL') NULL DEFAULT NULL,
  `budget` DECIMAL(13,4) UNSIGNED NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE current_timestamp,
  `start_before` TIMESTAMP NULL DEFAULT NULL,
  `done_before` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `category_id`, `user_id`, `user_location_id`),
  INDEX `fk_task_categories_idx` (`category_id` ASC),
  INDEX `fk_task_users_idx` (`user_id` ASC, `user_location_id` ASC),
  CONSTRAINT `fk_tasks_categories1`
    FOREIGN KEY (`category_id`)
    REFERENCES `taskforce`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tasks_users1`
    FOREIGN KEY (`user_id` , `user_location_id`)
    REFERENCES `taskforce`.`users` (`id` , `location_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`task_requests` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` INT(10) UNSIGNED NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `price` DECIMAL(12,4) NULL DEFAULT NULL,
  `content` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `rating` FLOAT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `task_id`, `user_id`),
  INDEX `fk_task_requests_task_idx` (`task_id` ASC),
  INDEX `fk_task_requests_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_task_requests_task`
    FOREIGN KEY (`task_id`)
    REFERENCES `taskforce`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_requests_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`user_contacts` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_id` INT(10) UNSIGNED NOT NULL,
  `type` TINYINT(2) UNSIGNED NOT NULL,
  `name` VARCHAR(128) NOT NULL,
  `value` TEXT NOT NULL,
  PRIMARY KEY (`id`, `users_id`),
  INDEX `fk_user_contacts_user_idx` (`users_id` ASC),
  CONSTRAINT `fk_user_contacts_user`
    FOREIGN KEY (`users_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`categories` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NOT NULL,
  `rating` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`user_categories` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `category_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`, `category_id`),
  INDEX `fk_user_categories_category_idx` (`category_id` ASC),
  INDEX `fk_user_categories_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_categories_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_categories_category`
    FOREIGN KEY (`category_id`)
    REFERENCES `taskforce`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- SET SQL_MODE=@OLD_SQL_MODE;
-- SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
-- SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
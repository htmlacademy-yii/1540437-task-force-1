-- MySQL Workbench Synchronization
-- Generated: 2020-07-21 23:13
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Леха

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE TABLE IF NOT EXISTS `taskforce`.`user` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` ENUM('CUSTOMER', 'PERFORMER') NOT NULL,
  `name` VARCHAR(245) NOT NULL,
  `email` VARCHAR(245) NOT NULL,
  `birt_date` DATE NULL DEFAULT NULL,
  `password_hash` VARCHAR(256) NOT NULL,
  `rating` FLOAT(11) NULL DEFAULT NULL,
  `skils` JSON NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `idx_email` (`email` ASC),
  INDEX `idx_role` (`role` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`task` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `location_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL COMMENT 'Customer',
  `title` VARCHAR(256) NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `status` ENUM('NEW', 'CANCELED', 'INPROGRESS', 'COMPLETE', 'FAIL') NULL DEFAULT NULL,
  `category` VARCHAR(256) NULL DEFAULT NULL,
  `amount` DECIMAL(13,4) UNSIGNED NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `start_before` TIMESTAMP NULL DEFAULT NULL,
  `done_before` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `user_id`),
  INDEX `fk_task_user_idx` (`user_id` ASC),
  INDEX `fk_task_task_location_idx` (`location_id` ASC),
  CONSTRAINT `fk_task_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task_task_location`
    FOREIGN KEY (`location_id`)
    REFERENCES `taskforce`.`location` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`location` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `param` JSON NULL DEFAULT NULL COMMENT 'Параметры кординат в JSON формате',
  `city_name` VARCHAR(256) NULL DEFAULT NULL,
  `region` VARCHAR(256) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_location_location1_idx` (`parent_id` ASC),
  CONSTRAINT `fk_location_location1`
    FOREIGN KEY (`parent_id`)
    REFERENCES `taskforce`.`location` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`chat` (
  `id` INT(10) UNSIGNED NOT NULL,
  `task_id` INT(10) UNSIGNED NOT NULL,
  `owner_id` INT(10) UNSIGNED NOT NULL,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `state` TINYINT(4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_chat_task1_idx` (`task_id` ASC),
  INDEX `fk_chat_user1_idx` (`owner_id` ASC),
  CONSTRAINT `fk_chat_task1`
    FOREIGN KEY (`task_id`)
    REFERENCES `taskforce`.`task` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_chat_user1`
    FOREIGN KEY (`owner_id`)
    REFERENCES `taskforce`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`chat_message` (
  `chat_id` INT(10) UNSIGNED NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `message` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX `fk_chat_message_chat_idx` (`chat_id` ASC),
  INDEX `fk_chat_message_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_chat_message_chat`
    FOREIGN KEY (`chat_id`)
    REFERENCES `taskforce`.`chat` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_chat_message_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`attachments` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NULL DEFAULT NULL,
  `type` ENUM('CHAT', 'TASK', 'OTHER') NOT NULL DEFAULT 'OTHER',
  `type_target_id` INT(10) UNSIGNED NOT NULL,
  `file_name` TEXT NOT NULL,
  `file_path` TEXT NULL DEFAULT NULL,
  `file_meta` JSON NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_type` (`type` ASC, `type_target_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
-- MySQL Workbench
-- Version: 1.4
-- Author: Alexey Pozhidaev

DROP DATABASE `taskforce`;
CREATE SCHEMA `taskforce`;

CREATE TABLE IF NOT EXISTS `taskforce`.`cities` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NULL DEFAULT NULL,
  `region` VARCHAR(256) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`categories` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(256) NOT NULL,
  `icon` VARCHAR(128) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `city_id` INT(10) UNSIGNED NOT NULL,
  `about` TEXT NULL DEFAULT NULL,
  `role` TINYINT(3) UNSIGNED NOT NULL,
  `first_name` VARCHAR(245) NOT NULL,
  `last_name` VARCHAR(245) NULL DEFAULT NULL,
  `email` VARCHAR(245) NOT NULL,
  `birth_date` DATE NULL DEFAULT NULL,
  `password_hash` VARCHAR(256) NOT NULL,
  `token` VARCHAR(256) NULL DEFAULT NULL,
  `phone` VARCHAR(128) NULL DEFAULT NULL,
  `skype` VARCHAR(128) NULL DEFAULT NULL,
  `telegramm` VARCHAR(128) NULL DEFAULT NULL,
  `failed_task_count` INT(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_profile_public` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
  `is_contact_public` TINYINT(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_logined_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uidx_email` (`email` ASC),
  INDEX `idx_role` (`role` ASC),
  INDEX `fk_users_cities_idx` (`city_id` ASC),
  CONSTRAINT `fk_users_cities`
    FOREIGN KEY (`city_id`)
    REFERENCES `taskforce`.`cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`tasks` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `performer_user_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `category_id` INT(10) UNSIGNED NOT NULL,
  `city_id` INT(10) UNSIGNED NOT NULL,
  `title` VARCHAR(256) NULL DEFAULT NULL,
  `additional_info` TEXT NULL DEFAULT NULL,
  `address` TEXT NULL DEFAULT NULL,
  `status` TINYINT(3) UNSIGNED NOT NULL,
  `budget` DECIMAL(12,4) UNSIGNED NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `start_date` DATE NULL DEFAULT NULL,
  `lattitude` FLOAT(11) NULL DEFAULT NULL,
  `longtitude` FLOAT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_status` (`status` ASC),
  INDEX `idx_start_date` (`start_date` ASC),
  INDEX `fk_tasks_categories_idx` (`category_id` ASC),
  INDEX `fk_tasks_users_idx` (`user_id` ASC),
  INDEX `fk_tasks_cities_idx` (`city_id` ASC),
  INDEX `fk_tasks_performer_idx` (`performer_user_id` ASC),
  CONSTRAINT `fk_tasks_categories`
    FOREIGN KEY (`category_id`)
    REFERENCES `taskforce`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tasks_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tasks_cities`
    FOREIGN KEY (`city_id`)
    REFERENCES `taskforce`.`cities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tasks_user_performer`
    FOREIGN KEY (`performer_user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`task_responses` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` INT(10) UNSIGNED NOT NULL,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `price` DECIMAL(12,4) NULL DEFAULT NULL,
  `comment` TEXT NULL DEFAULT NULL,
  `evaluation` TINYINT(1) UNSIGNED NULL DEFAULT NULL,
  `is_success` TINYINT(1) UNSIGNED NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`, `task_id`, `user_id`),
  INDEX `fk_task_requests_task_idx` (`task_id` ASC),
  INDEX `fk_task_requests_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_task_requests_tasks`
    FOREIGN KEY (`task_id`)
    REFERENCES `taskforce`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_task_requests_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`task_messages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `message` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_task_messages_tasks_idx` (`task_id` ASC),
  INDEX `fk_task_messages_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_task_messages_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_task_messages_tasks`
    FOREIGN KEY (`task_id`)
    REFERENCES `taskforce`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
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
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_categories_category`
    FOREIGN KEY (`category_id`)
    REFERENCES `taskforce`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`user_favorites` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `favorite_user_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_favorites_users_idx` (`user_id` ASC),
  INDEX `fk_user_favorites_favorite_idx` (`favorite_user_id` ASC),
  CONSTRAINT `fk_user_favorites_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_favorites_favorite`
    FOREIGN KEY (`favorite_user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`user_notifications` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `new_message` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  `new_respond` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  `task_actions` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `fk_user_notify_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_notify_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `taskforce`.`user_attachments` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL,
  `task_id` INT(10) UNSIGNED NULL DEFAULT NULL,
  `display_name` VARCHAR(256) NOT NULL,
  `file_name` TEXT NOT NULL,
  `file_path` TEXT NULL DEFAULT NULL,
  `file_meta` LONGTEXT NULL DEFAULT NULL,
  `thumb_path` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_attachments_users_idx` (`user_id` ASC),
  INDEX `fk_user_attachments_tasks_idx` (`task_id` ASC),
  CONSTRAINT `fk_attachments_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `taskforce`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_user_attachments_tasks`
    FOREIGN KEY (`task_id`)
    REFERENCES `taskforce`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
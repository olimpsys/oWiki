SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `owiki` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `owiki` ;

-- -----------------------------------------------------
-- Table `owiki`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `owiki`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `parent` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `owiki`.`page`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `owiki`.`page` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `content` TEXT NULL,
  `category_id` INT NOT NULL,
  `created_by` INT NOT NULL,
  `created_date` DATETIME NOT NULL,
  `updated_by` INT NULL,
  `updated_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `owiki`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `owiki`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `is_admin` TINYINT(1) NOT NULL,
  `is_active` TINYINT(1) NOT NULL,
  `access_token` VARCHAR(45) NULL,
  `access_token_expiration` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

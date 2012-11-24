SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `uwyn` DEFAULT CHARACTER SET utf8 ;
USE `uwyn` ;

-- -----------------------------------------------------
-- Table `uwyn`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uwyn`.`users` ;

CREATE  TABLE IF NOT EXISTS `uwyn`.`users` (
  `ID` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` CHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `user_password` VARCHAR(100) NOT NULL ,
  `user_nickname` VARCHAR(50) NOT NULL ,
  `user_registertime` DATETIME NOT NULL ,
  `user_status` INT(11) NOT NULL ,
  `users_ID` INT(11) NULL DEFAULT NULL ,
  `isAdmin` TINYINT NOT NULL ,
  PRIMARY KEY (`ID`) ,
  UNIQUE INDEX `myus_user_UNIQUE` (`username` ASC) ,
  UNIQUE INDEX `user_nickname_UNIQUE` (`user_nickname` ASC) ,
  INDEX `use_cre_nx` (`users_ID` ASC) ,
  CONSTRAINT `use_cre_fk`
    FOREIGN KEY (`users_ID` )
    REFERENCES `uwyn`.`users` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `uwyn`.`news`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uwyn`.`news` ;

CREATE  TABLE IF NOT EXISTS `uwyn`.`news` (
  `news_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `news_author` INT(11) NOT NULL ,
  `news_title` VARCHAR(255) NOT NULL ,
  `news_url` VARCHAR(255) NOT NULL ,
  `news_content` TEXT NULL DEFAULT NULL ,
  `news_date` DATETIME NOT NULL ,
  `news_modified` DATETIME NOT NULL ,
  `news_description` TEXT NULL DEFAULT NULL ,
  `news_status` INT(11) NOT NULL ,
  `url_image` TINYTEXT NULL DEFAULT NULL ,
  `news_usermodified` INT(11) NOT NULL ,
  PRIMARY KEY (`news_id`) ,
  UNIQUE INDEX `news_name_UNIQUE` (`news_url` ASC) ,
  INDEX `fk_news_author` (`news_author` ASC) ,
  INDEX `fk_news_modf` (`news_usermodified` ASC) ,
  CONSTRAINT `fk_news_author`
    FOREIGN KEY (`news_author` )
    REFERENCES `uwyn`.`users` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_news_modf`
    FOREIGN KEY (`news_usermodified` )
    REFERENCES `uwyn`.`users` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `uwyn`.`pages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uwyn`.`pages` ;

CREATE  TABLE IF NOT EXISTS `uwyn`.`pages` (
  `page_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `page_category` INT(11) NULL ,
  `user_mod` INT(11) NOT NULL ,
  `page_author` INT(11) NOT NULL ,
  `page_title` VARCHAR(255) NULL ,
  `page_url` VARCHAR(255) NOT NULL ,
  `page_date` DATETIME NOT NULL ,
  `page_modified` DATETIME NOT NULL ,
  `html_title` VARCHAR(70) NULL ,
  `html_description` VARCHAR(170) NULL ,
  `html_keywords` TEXT NULL ,
  `html_content` TEXT NULL ,
  PRIMARY KEY (`page_id`) ,
  UNIQUE INDEX `pages_url_UNIQUE` (`page_url` ASC) ,
  INDEX `page_indx1` (`page_author` ASC) ,
  INDEX `page_inx2` (`user_mod` ASC) ,
  INDEX `page_category_fk` (`page_category` ASC) ,
  CONSTRAINT `page_author_fk`
    FOREIGN KEY (`page_author` )
    REFERENCES `uwyn`.`users` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `page_mod_fk`
    FOREIGN KEY (`user_mod` )
    REFERENCES `uwyn`.`users` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `page_category_fk`
    FOREIGN KEY (`page_category` )
    REFERENCES `uwyn`.`pages` (`page_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `uwyn`.`users_privileges`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `uwyn`.`users_privileges` ;

CREATE  TABLE IF NOT EXISTS `uwyn`.`users_privileges` (
  `user_ID` INT(11) NOT NULL ,
  `privilege` VARCHAR(10) NOT NULL ,
  `object` VARCHAR(6) NOT NULL ,
  PRIMARY KEY (`user_ID`, `privilege`, `object`) ,
  INDEX `fk_users_has_privileges_users1` (`user_ID` ASC) ,
  CONSTRAINT `fk_users_has_privileges_users1`
    FOREIGN KEY (`user_ID` )
    REFERENCES `uwyn`.`users` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

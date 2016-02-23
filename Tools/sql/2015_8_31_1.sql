SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`personal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`personal` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`personal` (
  `personal_id` INT NOT NULL AUTO_INCREMENT ,
  `personal_name` VARCHAR(45) NOT NULL ,
  `personal_sex` TINYINT(1) NOT NULL ,
  `personal_date` INT NULL ,
  `personal_nation` VARCHAR(45) NULL ,
  `personal_origin` VARCHAR(45) NULL ,
  `personal_country` VARCHAR(45) NULL ,
  `personal_province` VARCHAR(45) NULL ,
  `personal_city` VARCHAR(45) NULL ,
  `personal_address` VARCHAR(45) NULL ,
  `personal_phone_num` VARCHAR(45) NOT NULL ,
  `personal_email` VARCHAR(45) NULL ,
  `personal_fax` VARCHAR(45) NULL ,
  `personal_zipcode` INT(6) NULL ,
  `personal_remarks` TEXT NULL ,
  PRIMARY KEY (`personal_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`company` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`company` (
  `company_id` INT NOT NULL AUTO_INCREMENT ,
  `company_name` VARCHAR(45) NOT NULL ,
  `company_address` VARCHAR(45) NOT NULL ,
  `company_zipcode` VARCHAR(45) NOT NULL ,
  `company_phone_num` VARCHAR(45) NOT NULL ,
  `company_email` VARCHAR(45) NOT NULL ,
  `company_fax` VARCHAR(45) NULL ,
  `company_remarks` TEXT NULL ,
  PRIMARY KEY (`company_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`group` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`group` (
  `group_id` INT NOT NULL AUTO_INCREMENT ,
  `group_name` VARCHAR(45) NOT NULL ,
  `group_remarks` TEXT NULL ,
  PRIMARY KEY (`group_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`donate_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`donate_type` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`donate_type` (
  `donate_type_id` INT NOT NULL AUTO_INCREMENT ,
  `donate_type_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`donate_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`pro_manage_dept`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`pro_manage_dept` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`pro_manage_dept` (
  `pro_manage_dept_id` INT NOT NULL AUTO_INCREMENT ,
  `pro_manage_dept_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`pro_manage_dept_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`fundrise_person`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`fundrise_person` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`fundrise_person` (
  `fundrise_person_id` INT NOT NULL AUTO_INCREMENT ,
  `fundrise_person_name` VARCHAR(45) NOT NULL ,
  `fundrise_person_dept_id` INT NOT NULL ,
  `fundrise_person_landline` VARCHAR(45) NOT NULL ,
  `fundrise_person_cellphone` VARCHAR(45) NULL ,
  `fundrise_person_email` VARCHAR(45) NULL ,
  `fundrise_person_fax` VARCHAR(45) NULL ,
  `fundrise_person_zipcode` VARCHAR(45) NULL ,
  PRIMARY KEY (`fundrise_person_id`) ,
  INDEX `fk_fundrise_person_pro_manage_dept1_idx` (`fundrise_person_dept_id` ASC) ,
  CONSTRAINT `fk_fundrise_person_pro_manage_dept1`
    FOREIGN KEY (`fundrise_person_dept_id` )
    REFERENCES `mydb`.`pro_manage_dept` (`pro_manage_dept_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`project_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`project_type` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`project_type` (
  `project_type_id` INT NOT NULL AUTO_INCREMENT ,
  `project_type_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`project_type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`project_level`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`project_level` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`project_level` (
  `project_level_id` INT NOT NULL AUTO_INCREMENT ,
  `project_level_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`project_level_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`project_state`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`project_state` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`project_state` (
  `project_state_id` INT NOT NULL AUTO_INCREMENT ,
  `project_state_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`project_state_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`project` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`project` (
  `project_id` INT NOT NULL AUTO_INCREMENT ,
  `project_name` VARCHAR(45) NOT NULL ,
  `project_date` INT NOT NULL ,
  `project_recorder_id` VARCHAR(45) NOT NULL ,
  `project_lastedit_id` VARCHAR(45) NOT NULL ,
  `project_lastedit_date` INT NOT NULL ,
  `project_manage_id` INT NOT NULL ,
  `project_fundrise_id` INT NOT NULL ,
  `project_type_id` INT NOT NULL ,
  `project_state_id` INT NOT NULL ,
  `project_level_id` INT NOT NULL ,
  `project_remarks` TEXT NULL ,
  PRIMARY KEY (`project_id`) ,
  INDEX `fk_project_pro_manage_dept1_idx` (`project_manage_id` ASC) ,
  INDEX `fk_project_fundrise_person1_idx` (`project_fundrise_id` ASC) ,
  INDEX `fk_project_project_type1_idx` (`project_type_id` ASC) ,
  INDEX `fk_project_project_level1_idx` (`project_level_id` ASC) ,
  INDEX `fk_project_project_state1_idx` (`project_state_id` ASC) ,
  CONSTRAINT `fk_project_pro_manage_dept1`
    FOREIGN KEY (`project_manage_id` )
    REFERENCES `mydb`.`pro_manage_dept` (`pro_manage_dept_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_project_fundrise_person1`
    FOREIGN KEY (`project_fundrise_id` )
    REFERENCES `mydb`.`fundrise_person` (`fundrise_person_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_project_project_type1`
    FOREIGN KEY (`project_type_id` )
    REFERENCES `mydb`.`project_type` (`project_type_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_project_project_level1`
    FOREIGN KEY (`project_level_id` )
    REFERENCES `mydb`.`project_level` (`project_level_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_project_project_state1`
    FOREIGN KEY (`project_state_id` )
    REFERENCES `mydb`.`project_state` (`project_state_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`donated_funds`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`donated_funds` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`donated_funds` (
  `donated_funds_id` INT NOT NULL AUTO_INCREMENT ,
  `donated_funds_project_id` INT NOT NULL ,
  `donated_funds_amount` DOUBLE NOT NULL ,
  `donated_funds_date` INT NOT NULL ,
  `donated_funds_donatetype_id` INT NOT NULL ,
  `donated_funds_recorder_id` VARCHAR(45) NOT NULL ,
  `donated_funds_lastedit_id` VARCHAR(45) NOT NULL ,
  `donated_funds_lastedit_date` INT NOT NULL ,
  `donated_funds_currency` VARCHAR(45) NOT NULL ,
  `donated_funds_remarks` TEXT NULL ,
  PRIMARY KEY (`donated_funds_id`) ,
  INDEX `fk_donated_funds_donate_type1_idx` (`donated_funds_donatetype_id` ASC) ,
  INDEX `fk_donated_funds_project1_idx` (`donated_funds_project_id` ASC) ,
  CONSTRAINT `fk_donated_funds_donate_type1`
    FOREIGN KEY (`donated_funds_donatetype_id` )
    REFERENCES `mydb`.`donate_type` (`donate_type_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_donated_funds_project1`
    FOREIGN KEY (`donated_funds_project_id` )
    REFERENCES `mydb`.`project` (`project_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`purpose`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`purpose` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`purpose` (
  `purpose_id` INT NOT NULL AUTO_INCREMENT ,
  `purpose_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`purpose_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`approved`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`approved` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`approved` (
  `approved_id` INT NOT NULL AUTO_INCREMENT ,
  `approved_name` VARCHAR(45) NOT NULL ,
  `approved_dept_id` INT NOT NULL ,
  `approved_landline` VARCHAR(45) NOT NULL ,
  `approved_cellphone` VARCHAR(45) NULL ,
  `approved_email` VARCHAR(45) NULL ,
  `approved_fax` VARCHAR(45) NULL ,
  `approved_zipcode` VARCHAR(45) NULL ,
  PRIMARY KEY (`approved_id`) ,
  INDEX `fk_approved_pro_manage_dept1_idx` (`approved_dept_id` ASC) ,
  CONSTRAINT `fk_approved_pro_manage_dept1`
    FOREIGN KEY (`approved_dept_id` )
    REFERENCES `mydb`.`pro_manage_dept` (`pro_manage_dept_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`spend_funds`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`spend_funds` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`spend_funds` (
  `spend_funds_id` INT NOT NULL AUTO_INCREMENT ,
  `spend_funds_project_id` INT NOT NULL ,
  `spend_funds_amount` DOUBLE NOT NULL ,
  `spend_funds_recorder_id` VARCHAR(45) NOT NULL ,
  `spend_funds_lastedit_id` VARCHAR(45) NOT NULL ,
  `spend_funds_lastedit_date` INT NOT NULL ,
  `spend_funds_date` INT NOT NULL ,
  `spend_funds_purpose_id` INT NOT NULL ,
  `spend_funds_remarks` TEXT NULL ,
  `spend_funds_aproved_dept_id` INT NOT NULL ,
  `spend_funds_manage_id` INT NOT NULL ,
  `spend_funds_approved_id` INT NOT NULL ,
  `spend_funds_benefit_dept_id` INT NOT NULL ,
  PRIMARY KEY (`spend_funds_id`) ,
  INDEX `fk_spend_funds_project1_idx` (`spend_funds_project_id` ASC) ,
  INDEX `fk_spend_funds_purpose1_idx` (`spend_funds_purpose_id` ASC) ,
  INDEX `fk_spend_funds_pro_manage_dept1_idx` (`spend_funds_aproved_dept_id` ASC) ,
  INDEX `fk_spend_funds_fundrise_person1_idx` (`spend_funds_manage_id` ASC) ,
  INDEX `fk_spend_funds_approved1_idx` (`spend_funds_approved_id` ASC) ,
  INDEX `fk_spend_funds_pro_manage_dept2_idx` (`spend_funds_benefit_dept_id` ASC) ,
  CONSTRAINT `fk_spend_funds_project1`
    FOREIGN KEY (`spend_funds_project_id` )
    REFERENCES `mydb`.`project` (`project_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_spend_funds_purpose1`
    FOREIGN KEY (`spend_funds_purpose_id` )
    REFERENCES `mydb`.`purpose` (`purpose_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_spend_funds_pro_manage_dept1`
    FOREIGN KEY (`spend_funds_aproved_dept_id` )
    REFERENCES `mydb`.`pro_manage_dept` (`pro_manage_dept_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_spend_funds_fundrise_person1`
    FOREIGN KEY (`spend_funds_manage_id` )
    REFERENCES `mydb`.`fundrise_person` (`fundrise_person_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_spend_funds_approved1`
    FOREIGN KEY (`spend_funds_approved_id` )
    REFERENCES `mydb`.`approved` (`approved_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_spend_funds_pro_manage_dept2`
    FOREIGN KEY (`spend_funds_benefit_dept_id` )
    REFERENCES `mydb`.`pro_manage_dept` (`pro_manage_dept_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`intercourse`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`intercourse` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`intercourse` (
  `intercourse_id` INT NOT NULL AUTO_INCREMENT ,
  `intercourse_theme` VARCHAR(45) NOT NULL ,
  `intercourse_date` INT NOT NULL ,
  `intercourse_recorder_id` VARCHAR(45) NOT NULL ,
  `intercourse_lastedit_id` VARCHAR(45) NOT NULL ,
  `intercourse_lastedit_date` VARCHAR(45) NOT NULL ,
  `intercourse_content` TEXT NOT NULL ,
  PRIMARY KEY (`intercourse_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`donate`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`donate` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`donate` (
  `donate_group_id` INT NULL ,
  `donate_personal_id` INT NULL ,
  `donate_company_id` INT NULL ,
  `donate_donated_funds_id` INT NOT NULL ,
  `donate_customer_type` INT NOT NULL ,
  INDEX `fk_donate_company1_idx` (`donate_company_id` ASC) ,
  INDEX `fk_donate_donated_funds1_idx` (`donate_donated_funds_id` ASC) ,
  UNIQUE INDEX `donate_donated_funds_id_UNIQUE` (`donate_donated_funds_id` ASC) ,
  CONSTRAINT `fk_donate_group`
    FOREIGN KEY (`donate_group_id` )
    REFERENCES `mydb`.`group` (`group_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_donate_personal1`
    FOREIGN KEY (`donate_personal_id` )
    REFERENCES `mydb`.`personal` (`personal_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_donate_company1`
    FOREIGN KEY (`donate_company_id` )
    REFERENCES `mydb`.`company` (`company_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_donate_donated_funds1`
    FOREIGN KEY (`donate_donated_funds_id` )
    REFERENCES `mydb`.`donated_funds` (`donated_funds_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`join_intercourse`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`join_intercourse` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`join_intercourse` (
  `join_intercourse_id` INT NOT NULL AUTO_INCREMENT ,
  `group_group_id` INT NULL ,
  `personal_personal_id` INT NULL ,
  `company_company_id` INT NULL ,
  `intercourse_intercourse_id` INT NOT NULL ,
  INDEX `fk_table1_personal1_idx` (`personal_personal_id` ASC) ,
  INDEX `fk_table1_company1_idx` (`company_company_id` ASC) ,
  INDEX `fk_join_intercourse_intercourse1_idx` (`intercourse_intercourse_id` ASC) ,
  PRIMARY KEY (`join_intercourse_id`) ,
  UNIQUE INDEX `join_intercourse_id_UNIQUE` (`join_intercourse_id` ASC) ,
  CONSTRAINT `fk_table1_group1`
    FOREIGN KEY (`group_group_id` )
    REFERENCES `mydb`.`group` (`group_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_personal1`
    FOREIGN KEY (`personal_personal_id` )
    REFERENCES `mydb`.`personal` (`personal_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_company1`
    FOREIGN KEY (`company_company_id` )
    REFERENCES `mydb`.`company` (`company_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_join_intercourse_intercourse1`
    FOREIGN KEY (`intercourse_intercourse_id` )
    REFERENCES `mydb`.`intercourse` (`intercourse_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`group_have`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`group_have` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`group_have` (
  `group_group_id` INT NOT NULL ,
  `personal_personal_id` INT NOT NULL ,
  INDEX `fk_group_have_personal1_idx` (`personal_personal_id` ASC) ,
  CONSTRAINT `fk_group_have_group1`
    FOREIGN KEY (`group_group_id` )
    REFERENCES `mydb`.`group` (`group_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_group_have_personal1`
    FOREIGN KEY (`personal_personal_id` )
    REFERENCES `mydb`.`personal` (`personal_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`company_have`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`company_have` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`company_have` (
  `company_company_id` INT NOT NULL ,
  `personal_personal_id` INT NOT NULL ,
  INDEX `fk_company_have_personal1_idx` (`personal_personal_id` ASC) ,
  CONSTRAINT `fk_company_have_company1`
    FOREIGN KEY (`company_company_id` )
    REFERENCES `mydb`.`company` (`company_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_company_have_personal1`
    FOREIGN KEY (`personal_personal_id` )
    REFERENCES `mydb`.`personal` (`personal_id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`manage_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`manage_group` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`manage_group` (
  `personal_personal_id` INT NOT NULL ,
  `group_group_id` INT NOT NULL ,
  INDEX `fk_manage_group_personal1_idx` (`personal_personal_id` ASC) ,
  INDEX `fk_manage_group_group1_idx` (`group_group_id` ASC) ,
  UNIQUE INDEX `group_group_id_UNIQUE` (`group_group_id` ASC) ,
  CONSTRAINT `fk_manage_group_personal1`
    FOREIGN KEY (`personal_personal_id` )
    REFERENCES `mydb`.`personal` (`personal_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_manage_group_group1`
    FOREIGN KEY (`group_group_id` )
    REFERENCES `mydb`.`group` (`group_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`manage_company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`manage_company` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`manage_company` (
  `personal_personal_id` INT NOT NULL ,
  `company_company_id` INT NOT NULL ,
  INDEX `fk_manage_company_company1_idx` (`company_company_id` ASC) ,
  UNIQUE INDEX `company_company_id_UNIQUE` (`company_company_id` ASC) ,
  CONSTRAINT `fk_manage_company_personal1`
    FOREIGN KEY (`personal_personal_id` )
    REFERENCES `mydb`.`personal` (`personal_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_manage_company_company1`
    FOREIGN KEY (`company_company_id` )
    REFERENCES `mydb`.`company` (`company_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`news`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`news` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`news` (
  `news_id` INT NOT NULL AUTO_INCREMENT ,
  `news_name` VARCHAR(45) NOT NULL ,
  `news_link` VARCHAR(45) NOT NULL ,
  `news_date` INT NOT NULL ,
  `news_remark` TEXT NULL ,
  PRIMARY KEY (`news_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`pro_have_news`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`pro_have_news` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`pro_have_news` (
  `project_project_id` INT NOT NULL ,
  `news_news_id` INT NOT NULL ,
  INDEX `fk_table1_project1_idx` (`project_project_id` ASC) ,
  INDEX `fk_table1_news1_idx` (`news_news_id` ASC) ,
  CONSTRAINT `fk_table1_project1`
    FOREIGN KEY (`project_project_id` )
    REFERENCES `mydb`.`project` (`project_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_table1_news1`
    FOREIGN KEY (`news_news_id` )
    REFERENCES `mydb`.`news` (`news_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- TO USE THIS FILE IN Cloud9\
-- Run this command inside the MySQL command line client:\
--\
-- source ~/workspace/house-points/db/db-init.sql\
--\
-- Be careful! This file will DROP the existing library database.\
\
-- Drop the existing library database.\

\
-- Create a new, empty library database.\

\
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mrgogor3_PRJX
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mrgogor3_PRJX` ;

-- -----------------------------------------------------
-- Schema mrgogor3_PRJX
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mrgogor3_PRJX` DEFAULT CHARACTER SET utf8 ;
USE `mrgogor3_PRJX` ;

-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`students`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`students` (
  `id` INT NOT NULL,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `grade` INT NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`teacher`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`teacher` (
  `id` INT NOT NULL,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`course`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`course` (
  `id` VARCHAR(45) NOT NULL,
  `name` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`section`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`section` (
  `syst_id` INT NOT NULL,
  `course_id` VARCHAR(45) NOT NULL,
  `section_id` INT NOT NULL,
  `teacher_id` INT NOT NULL,
  `cycle_day` INT NOT NULL,
  `period` INT NOT NULL,
  PRIMARY KEY (`syst_id`),
  INDEX `fk_courses_teacher_idx` (`teacher_id` ASC),
  INDEX `fk_section_course1_idx` (`course_id` ASC),
  CONSTRAINT `fk_courses_teacher`
    FOREIGN KEY (`teacher_id`)
    REFERENCES `mrgogor3_PRJX`.`teacher` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_section_course1`
    FOREIGN KEY (`course_id`)
    REFERENCES `mrgogor3_PRJX`.`course` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`ratings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`ratings` (
  `students_id` INT NOT NULL,
  `understanding` INT NOT NULL,
  `engaging` INT NOT NULL,
  `productive` INT NOT NULL,
  `section_syst_id` INT NOT NULL,
  `date` VARCHAR(12) NOT NULL,
  INDEX `fk_ratings_students1_idx` (`students_id` ASC),
  INDEX `fk_ratings_section1_idx` (`section_syst_id` ASC),
  CONSTRAINT `fk_ratings_students1`
    FOREIGN KEY (`students_id`)
    REFERENCES `mrgogor3_PRJX`.`students` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ratings_section1`
    FOREIGN KEY (`section_syst_id`)
    REFERENCES `mrgogor3_PRJX`.`section` (`syst_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`class`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`class` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `section_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_class_courses1_idx` (`section_id` ASC),
  CONSTRAINT `fk_class_courses1`
    FOREIGN KEY (`section_id`)
    REFERENCES `mrgogor3_PRJX`.`section` (`syst_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`students_has_courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`students_has_courses` (
  `students_id` INT NOT NULL,
  `section_syst_id` INT NOT NULL,
  `true` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`students_id`, `section_syst_id`),
  INDEX `fk_students_has_courses_courses1_idx` (`section_syst_id` ASC),
  INDEX `fk_students_has_courses_students1_idx` (`students_id` ASC),
  CONSTRAINT `fk_students_has_courses_students1`
    FOREIGN KEY (`students_id`)
    REFERENCES `mrgogor3_PRJX`.`students` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_students_has_courses_courses1`
    FOREIGN KEY (`section_syst_id`)
    REFERENCES `mrgogor3_PRJX`.`section` (`syst_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`stu_initial_passwords`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`stu_initial_passwords` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `rand_pass` VARCHAR(100) NOT NULL,
  `students_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_stu_initial_passwords_students1_idx` (`students_id` ASC),
  CONSTRAINT `fk_stu_initial_passwords_students1`
    FOREIGN KEY (`students_id`)
    REFERENCES `mrgogor3_PRJX`.`students` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`teacher_initial_passwords`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`teacher_initial_passwords` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `random_pass` VARCHAR(100) NOT NULL,
  `teacher_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_teacher_initial_passwords_teacher1_idx` (`teacher_id` ASC),
  CONSTRAINT `fk_teacher_initial_passwords_teacher1`
    FOREIGN KEY (`teacher_id`)
    REFERENCES `mrgogor3_PRJX`.`teacher` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

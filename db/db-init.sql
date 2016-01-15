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
  `password` VARCHAR(45) NULL,
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
  `password` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`course`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`course` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `grade` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`section`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`section` (
  `id` INT NOT NULL,
  `teacher_id` INT NOT NULL,
  `course_id` INT NOT NULL,
  `cycle_day` INT NOT NULL,
  PRIMARY KEY (`id`),
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
-- Table `mrgogor3_PRJX`.`class`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`class` (
  `id` INT NOT NULL,
  `date` DATE NOT NULL,
  `section_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_class_courses1_idx` (`section_id` ASC),
  CONSTRAINT `fk_class_courses1`
    FOREIGN KEY (`section_id`)
    REFERENCES `mrgogor3_PRJX`.`section` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`ratings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`ratings` (
  `class_id` INT NOT NULL,
  `students_id` INT NOT NULL,
  INDEX `fk_ratings_class1_idx` (`class_id` ASC),
  INDEX `fk_ratings_students1_idx` (`students_id` ASC),
  CONSTRAINT `fk_ratings_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `mrgogor3_PRJX`.`class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ratings_students1`
    FOREIGN KEY (`students_id`)
    REFERENCES `mrgogor3_PRJX`.`students` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mrgogor3_PRJX`.`students_has_courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mrgogor3_PRJX`.`students_has_courses` (
  `students_id` INT NOT NULL,
  `courses_code` INT NOT NULL,
  PRIMARY KEY (`students_id`, `courses_code`),
  INDEX `fk_students_has_courses_courses1_idx` (`courses_code` ASC),
  INDEX `fk_students_has_courses_students1_idx` (`students_id` ASC),
  CONSTRAINT `fk_students_has_courses_students1`
    FOREIGN KEY (`students_id`)
    REFERENCES `mrgogor3_PRJX`.`students` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_students_has_courses_courses1`
    FOREIGN KEY (`courses_code`)
    REFERENCES `mrgogor3_PRJX`.`section` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

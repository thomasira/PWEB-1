-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema e2395387
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema e2395387
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `e2395387` DEFAULT CHARACTER SET utf8 ;
USE `e2395387` ;

-- -----------------------------------------------------
-- Table `e2395387`.`pweb_condition`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e2395387`.`pweb_condition` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `condition` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `e2395387`.`pweb_privilege`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e2395387`.`pweb_privilege` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `privilege` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `e2395387`.`pweb_membre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e2395387`.`pweb_membre` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom_membre` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `privilege_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_membre_privilege1_idx` (`privilege_id` ASC),
  CONSTRAINT `fk_membre_privilege1`
    FOREIGN KEY (`privilege_id`)
    REFERENCES `e2395387`.`pweb_privilege` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `e2395387`.`pweb_enchere`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e2395387`.`pweb_enchere` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `enchere_nom` VARCHAR(45) NULL,
  `date_debut` DATE NOT NULL,
  `date_fin` DATE NOT NULL,
  `prix_plancher` FLOAT NOT NULL,
  `coups_de_coeur` SMALLINT NOT NULL,
  `membre_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_enchere_membre1_idx` (`membre_id` ASC),
  CONSTRAINT `fk_enchere_membre1`
    FOREIGN KEY (`membre_id`)
    REFERENCES `e2395387`.`pweb_membre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `e2395387`.`pweb_timbre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e2395387`.`pweb_timbre` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NOT NULL,
  `date_creation` DATE NOT NULL,
  `pays_origine` VARCHAR(20) NOT NULL,
  `certifie` SMALLINT NOT NULL,
  `image_principale_link` VARCHAR(45) DEFAULT 'default.svg',
  `tirage` VARCHAR(45) NULL,
  `dimensions` VARCHAR(45) NULL,
  `enchere_id` INT NOT NULL,
  `condition_id` INT NULL,
  `membre_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_timbre_condition_idx` (`condition_id` ASC),
  INDEX `fk_timbre_enchere1_idx` (`enchere_id` ASC),
  INDEX `fk_timbre_membre1_idx` (`membre_id` ASC),
  CONSTRAINT `fk_timbre_condition`
    FOREIGN KEY (`condition_id`)
    REFERENCES `e2395387`.`pweb_condition` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_timbre_enchere1`
    FOREIGN KEY (`enchere_id`)
    REFERENCES `e2395387`.`pweb_enchere` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_timbre_membre1`
    FOREIGN KEY (`membre_id`)
    REFERENCES `e2395387`.`pweb_membre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `e2395387`.`pweb_image_secondaire`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e2395387`.`pweb_image_secondaire` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `image_link` VARCHAR(45) NOT NULL,
  `timbre_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_images_timbre1_idx` (`timbre_id` ASC),
  CONSTRAINT `fk_images_timbre1`
    FOREIGN KEY (`timbre_id`)
    REFERENCES `e2395387`.`pweb_timbre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `e2395387`.`pweb_enchere_favori`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e2395387`.`pweb_enchere_favori` (
  `enchere_id` INT NOT NULL,
  `membre_id` INT NOT NULL,
  PRIMARY KEY (`enchere_id`, `membre_id`),
  INDEX `fk_enchere_has_membre_membre1_idx` (`membre_id` ASC),
  INDEX `fk_enchere_has_membre_enchere1_idx` (`enchere_id` ASC),
  CONSTRAINT `fk_enchere_has_membre_enchere1`
    FOREIGN KEY (`enchere_id`)
    REFERENCES `e2395387`.`pweb_enchere` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_enchere_has_membre_membre1`
    FOREIGN KEY (`membre_id`)
    REFERENCES `e2395387`.`pweb_membre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `e2395387`.`pweb_mise`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `e2395387`.`pweb_mise` (
  `membre_id` INT NOT NULL,
  `enchere_id` INT NOT NULL,
  `montant` FLOAT NOT NULL,
  `date_mise` DATE NOT NULL,
  PRIMARY KEY (`membre_id`, `enchere_id`),
  INDEX `fk_membre_has_enchere_enchere1_idx` (`enchere_id` ASC),
  INDEX `fk_membre_has_enchere_membre1_idx` (`membre_id` ASC),
  CONSTRAINT `fk_membre_has_enchere_membre1`
    FOREIGN KEY (`membre_id`)
    REFERENCES `e2395387`.`pweb_membre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_membre_has_enchere_enchere1`
    FOREIGN KEY (`enchere_id`)
    REFERENCES `e2395387`.`pweb_enchere` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

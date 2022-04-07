-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema BookStore
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema BookStore
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `BookStore` DEFAULT CHARACTER SET utf8mb4 ;
USE `BookStore` ;

-- -----------------------------------------------------
-- Table `BookStore`.`Author`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BookStore`.`Author` ;

CREATE TABLE IF NOT EXISTS `BookStore`.`Author` (
  `idAuthor` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(100) NOT NULL,
  `lastName` VARCHAR(100) NOT NULL,
  `bookCount` INT NOT NULL,
  PRIMARY KEY (`idAuthor`))
ENGINE = InnoDB
AUTO_INCREMENT = 0
DEFAULT CHARACTER SET = utf8mb4;


LOCK TABLES `Author` WRITE;
/*!40000 ALTER TABLE `Author` DISABLE KEYS */;
INSERT INTO `BookStore`.`Author` (`firstName`, `lastName`, `bookCount`) VALUES ('Heidi', 'Williams', '1'),('Alexander', 'Smith', '1'),('Andrew', 'Garfield', '1'),('Mark', 'Otto', '1');
/*!40000 ALTER TABLE `Author` ENABLE KEYS */;
UNLOCK TABLES;

-- -----------------------------------------------------
-- Table `BookStore`.`Book`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `BookStore`.`Book` ;

CREATE TABLE IF NOT EXISTS `BookStore`.`Book` (
  `idBook` INT NOT NULL AUTO_INCREMENT,
  `idAuthor` INT NOT NULL,
  `title` VARCHAR(250) NOT NULL,
  `yearOfRelease` INT NOT NULL,
  PRIMARY KEY (`idBook`))
ENGINE = InnoDB
AUTO_INCREMENT = 0
DEFAULT CHARACTER SET = utf8mb4;


LOCK TABLES `Book` WRITE;
/*!40000 ALTER TABLE `Book` DISABLE KEYS */;
INSERT INTO `BookStore`.`Book` (`idAuthor`, `title`, `yearOfRelease`) VALUES ('0', 'White Fang', '1998'),('1', 'Heidi', '1991'),('2', 'The Selfish Giant', '1961'),('3', 'Little House On The Prairie', '1956');
/*!40000 ALTER TABLE `Book` ENABLE KEYS */;
UNLOCK TABLES;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


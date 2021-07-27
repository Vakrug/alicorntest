-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.17 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for alicorntest
CREATE DATABASE IF NOT EXISTS `alicorntest` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `alicorntest`;

-- Dumping structure for table alicorntest.ingredient
CREATE TABLE IF NOT EXISTS `ingredient` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Price` decimal(20,2) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table alicorntest.ingredient: ~9 rows (approximately)
/*!40000 ALTER TABLE `ingredient` DISABLE KEYS */;
INSERT INTO `ingredient` (`Id`, `Name`, `Price`) VALUES
	(1, 'tomato', 0.50),
	(2, 'sliced mushrooms', 0.50),
	(3, 'feta cheese', 1.00),
	(4, 'sausages', 1.00),
	(5, 'sliced onion', 0.50),
	(6, 'mozzarella cheese', 0.30),
	(7, 'oregano', 2.00),
	(8, 'bacon', 1.00);
/*!40000 ALTER TABLE `ingredient` ENABLE KEYS */;

-- Dumping structure for table alicorntest.pizza
CREATE TABLE IF NOT EXISTS `pizza` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table alicorntest.pizza: ~3 rows (approximately)
/*!40000 ALTER TABLE `pizza` DISABLE KEYS */;
INSERT INTO `pizza` (`Id`, `Name`) VALUES
	(1, 'MacDac Pizza'),
	(2, 'Lovely Mushroom Pizza');
/*!40000 ALTER TABLE `pizza` ENABLE KEYS */;

-- Dumping structure for table alicorntest.pizza_ingredient
CREATE TABLE IF NOT EXISTS `pizza_ingredient` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PizzaId` int(11) NOT NULL,
  `IngredientId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `PizzaId_IngredientId` (`PizzaId`,`IngredientId`),
  KEY `FK_pizza_ingredient_ingredient` (`IngredientId`),
  CONSTRAINT `FK_pizza_ingredient_ingredient` FOREIGN KEY (`IngredientId`) REFERENCES `ingredient` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pizza_ingredient_pizza` FOREIGN KEY (`PizzaId`) REFERENCES `pizza` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table alicorntest.pizza_ingredient: ~15 rows (approximately)
/*!40000 ALTER TABLE `pizza_ingredient` DISABLE KEYS */;
INSERT INTO `pizza_ingredient` (`Id`, `PizzaId`, `IngredientId`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 1, 3),
	(4, 1, 4),
	(5, 1, 5),
	(6, 1, 6),
	(7, 1, 7),
	(30, 2, 1),
	(16, 2, 2),
	(15, 2, 6),
	(17, 2, 7),
	(14, 2, 8);
/*!40000 ALTER TABLE `pizza_ingredient` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

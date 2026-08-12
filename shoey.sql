-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: shoey
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `CustID` tinyint(3) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(18) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `email` varchar(38) NOT NULL,
  `phoneNo` varchar(13) DEFAULT NULL,
  `dateOfBirth` date NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `password` char(60) NOT NULL,
  PRIMARY KEY (`CustID`),
  UNIQUE KEY `password_unique` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (5,'John','Murphy','john.murphy@example.com','0871234567','1998-05-14','12 Oak Drive, Dublin','hashedpass1'),(6,'Sarah','O\'Connor','sarah.oconnor@example.com','0852345678','2000-11-22','45 Maple Avenue, Cork','hashedpass2'),(7,'Liam','Kelly','liam.kelly@example.com','0863456789','1995-02-03','78 River Street, Galway','hashedpass3'),(8,'Aoife','Doyle','aoife.doyle@example.com','0894567890','2001-07-19','23 Hillcrest Park, Limerick','hashedpass4'),(9,'test','test','test@gmail.com','1234567891','1998-02-28','1231234','$2y$10$3ETqrncKsQmbp7gbjnzvYOtS2UscVxhFcQqNFq8h2q/oNDbhsZsNu'),(10,'test','test','test@gmail.com','1234567891','1998-02-28','1231234','$2y$10$nFRLD9ijTvwT1YZTW0LeIeUbREr4Pz/9QjR4VxxBGXTDNDiTk1IRm'),(11,'test','test','test@gmail.com','1234567891','1998-02-28','1231234','$2y$10$HEU3PKjPiZPzGdt55MAiqONxgNQJd3zc9PrEdV0.F0Ts.syuoJiO6');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `orderID` tinyint(3) NOT NULL,
  `productID` tinyint(3) NOT NULL,
  `quantity` smallint(10) NOT NULL,
  `unitPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`orderID`,`productID`),
  KEY `productID` (`productID`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (2,2,1,49.99),(3,2,1,49.99),(4,2,2,49.99);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `orderID` tinyint(3) NOT NULL AUTO_INCREMENT,
  `orderDate` date NOT NULL,
  `status` enum('Pend','Canc','Comp') DEFAULT 'Pend',
  `totalAmt` decimal(10,2) NOT NULL,
  `CustID` tinyint(3) NOT NULL,
  PRIMARY KEY (`orderID`),
  KEY `CustID` (`CustID`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustID`) REFERENCES `customers` (`CustID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (2,'2026-04-30','Pend',49.99,9),(3,'2026-04-30','Pend',49.99,9),(4,'2026-04-30','Pend',99.98,9);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `productID` tinyint(3) NOT NULL AUTO_INCREMENT,
  `productName` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_qty` tinyint(4) NOT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Air Jordans','Air Jordan is a line of basketball and sportswear shoes produced by Nike.',69.99,15),(2,'Nike Zoom Vomero','Combining classic style with all-day comfort, our tests with the Nike Zoom Vomero 5 felt like a bree',49.99,11),(3,'NB 990 v6','We could place our full trust in the New Balance 990 v6 to take care of our tired feet',29.99,9),(4,'ASICSA Gel 1130','Its plush cushioning and pretty stable platform just made loving it a lot easier',69.99,21),(5,'Adidas Astir','',39.99,27),(6,'Shoe','Idk',75.00,18),(7,'','',0.00,0),(8,'Shoe','A good shoe',0.00,0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-01 20:32:40

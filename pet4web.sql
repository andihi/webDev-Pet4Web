-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 01. Sep 2013 um 19:57
-- Server Version: 5.6.11
-- PHP-Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `pet4web`
--
CREATE DATABASE IF NOT EXISTS `pet4web` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pet4web`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `customer_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`customer_ID`,`product_ID`),
  KEY `cart_product` (`product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`ID`, `name`, `description`) VALUES
(1, 'Fische', 'Fische sind toll - sie sind besonders leise!'),
(2, 'Amphibien', 'Die Amphibien oder Lurche (Amphibia) sind die stammesgeschichtlich älteste Klasse der Landwirbeltiere (Tetrapoda). Viele Arten verbringen zunächst ein Larvenstadium im Wasser und gehen nach einer Metamorphose zum Leben an Land über. ');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `customer`
--

INSERT INTO `customer` (`ID`, `email`, `password`, `firstname`, `lastname`, `isAdmin`) VALUES
(1, 'andreas.burger@gmx.at', '8b1a9953c4611296a827abf8c47804d7', 'Andreas', 'Burger', NULL),
(2, 'j.d@pet4web.at', '527bd5b5d689e2c32ae974c6229ff785', 'John', 'Doe', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `picture` blob,
  `price` double NOT NULL,
  `productcode` varchar(50) NOT NULL,
  `category_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `category_ID` (`category_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `product`
--

INSERT INTO `product` (`ID`, `name`, `description`, `picture`, `price`, `productcode`, `category_ID`) VALUES
(1, 'Hammerhai', 'Die Hammerhaie (Sphyrnidae) sind eine Familie der Haie, die besonders durch die starke Verbreiterung ihres Kopfes zu einem sogenannten Cephalofoil gekennzeichnet sind; bei einigen Arten führt diese zur Bildung des namensgebenden „Hammers“. Die Familie umfasst zwei Gattungen mit insgesamt acht Arten, die sich vor allem in ihrer Größe sowie Form und Breite des Kopfes unterscheiden. Die größte Art ist der Große Hammerhai (Sphyrna mokarran) mit einer Maximallänge von 5,50 bis 6,10 Metern, während der Korona-Hammerhai (Sphyrna corona) als kleinste Art nur eine maximale Gesamtlänge von unter einem Meter erreicht.\r\nHammerhaie leben weltweit vor allem in tropischen und subtropischen Küstengebieten. Sie sind in der Regel Einzelgänger, wobei einige Arten jedoch auch Gruppen von mehreren hundert bis mehreren tausend Individuen bilden können. Als Jäger erbeuten sie eine Vielzahl wirbelloser Tiere sowie Knochen- und Knorpelfische. Größere Individuen erbeuten auch andere Haie einschließlich kleinere', NULL, 1500, 'AT0001', 1),
(2, 'Clownfisch', 'Die Anemonenfische (Amphiprion), nach den beiden bekanntesten Arten häufig auch Clownfische genannt, sind eine in den Korallenriffen des tropischen Indopazifik vorkommende Gattung der Riffbarsche (Pomacentridae), die in enger Symbiose mit Seeanemonen lebt. Dabei leben die einzelnen Arten nur mit bestimmten Arten von Symbioseanemonen zusammen. Die Symbioseanemonen bieten den Anemonenfischen, die alle schlechte Schwimmer sind, Schutz vor Raubfischen. Auch die Anemonenfische schützen ihre Symbiosepartner vor Fressfeinden, z. B. Falterfische. Annahmen, die Fische würden ihre Partner füttern, konnten nicht bestätigt werden, dagegen werden Symbioseanemonen, deren Fischpartner weggefangen wurden, bald von Falter- oder Feilenfischen gefressen.', NULL, 20, 'AT0002', 1),
(3, 'Froschlurch', 'Die Froschlurche (Anura; auch: Salientia) sind die bei weitem artenreichste der drei rezenten Ordnungen aus der Wirbeltierklasse der Amphibien. Zu den Froschlurchen zählen unter anderem Kröten und Unken, die meisten Tiere werden aber – ohne näheren verwandtschaftlichen Zusammenhang – als „Frösche“ bezeichnet. Die anderen Ordnungen der Amphibien sind die Schwanzlurche (Caudata, Urodela) und die Schleichenlurche oder Blindwühlen (Gymnophiona).', NULL, 10, 'AT0003', 2),
(4, 'Alligator', 'Die Alligatoren sind eine Familie der Krokodile. In ihr sind die Echten Alligatoren und die Kaimane zusammengefasst. Ihr Leben und ihr Stoffwechsel verlaufen langsamer als bei ihren Verwandten, den Echten Krokodilen, und auch ihre restliche Entwicklung ist im Vergleich zu diesen stark verlangsamt. Durch diese ruhigere Lebensweise werden sie jedoch doppelt so alt wie ihre Verwandten.', NULL, 2000, 'AT0004', 2);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_customer` FOREIGN KEY (`customer_ID`) REFERENCES `customer` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_product` FOREIGN KEY (`product_ID`) REFERENCES `product` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_category` FOREIGN KEY (`category_ID`) REFERENCES `category` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

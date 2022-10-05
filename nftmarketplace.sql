-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-09-2022 a las 01:26:30
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26 

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nftmarketplace`
--
CREATE DATABASE IF NOT EXISTS `nftmarketplace` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nftmarketplace`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `collections`
--

DROP TABLE IF EXISTS `collections`;
CREATE TABLE IF NOT EXISTS `collections` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `IDblockchain` int(10) NOT NULL COMMENT 'Id de blockchain, Pej. BSC: 56',
  `ContractAddress` varchar(100) NOT NULL,
  `Type` varchar(10) NOT NULL COMMENT 'ERC721 ó ERC1155',
  `addtimestamp` timestamp NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Tabla de colecciones de NFTS';

--
-- Volcado de datos para la tabla `collections`
--

INSERT INTO `collections` (`ID`, `Name`, `Description`, `IDblockchain`, `ContractAddress`, `Type`, `addtimestamp`) VALUES
(1, 'Rocky Neko Halloween NFT', 'Halloween NFTs for Rocky NeKo project in Polygon Blockchain with 10,000 unique tickets for the new NFT Lottery.', 137, '0x436231D285Ad1A9E02131C603eC4530b6c4ec6e1', 'ERC1155', '2022-09-30 01:05:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lazynfts`
--

DROP TABLE IF EXISTS `lazynfts`;
CREATE TABLE IF NOT EXISTS `lazynfts` (
  `NFTid` int(11) NOT NULL AUTO_INCREMENT,
  `idcollection` int(11) NOT NULL,
  `NFTDescription` varchar(500) NOT NULL,
  `TicketNumber` int(11) NOT NULL COMMENT '# ticket para sorteo',
  `ImagePreview` varchar(500) NOT NULL COMMENT 'URL de preview',
  `ImageHD` varchar(500) NOT NULL COMMENT 'URL en HD',
  `Attributes` json NOT NULL COMMENT 'Atributos en JSON',
  `Minted` tinyint(1) NOT NULL DEFAULT '0',
  `OwnerAddress` varchar(100) DEFAULT NULL,
  `TxnHash` varchar(100) DEFAULT NULL COMMENT 'Transaction Hash',
  `TimeStampMinted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`NFTid`),
  KEY `collectionFK` (`idcollection`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Tabla para almacenar NFTs potenaicales de minteo';

--
-- Volcado de datos para la tabla `lazynfts`
--

INSERT INTO `lazynfts` (`NFTid`, `idcollection`, `NFTDescription`, `TicketNumber`, `ImagePreview`, `ImageHD`, `Attributes`, `Minted`, `OwnerAddress`, `TxnHash`, `TimeStampMinted`) VALUES
(1, 1, 'Rocky Neko Ticket #500', 500, 'https://rockyneko.rocks/NFTrep/prev/img787j67dsj52gwDyhlm.png', 'https://rockyneko.rocks/NFTrep/HD/imgHDk893rgnb5689RfXz3208l.png', '{\"hat\": \"Pumpkin\", \"Head\": \"Grey\", \"body\": \"Orange\", \"eyes\": \"Green\", \"lenses\": \"No\", \"costume\": \"Dracula\", \"expression\": \"Amazed\"}', 0, NULL, NULL, NULL);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lazynfts`
--
ALTER TABLE `lazynfts`
  ADD CONSTRAINT `collectionFK` FOREIGN KEY (`idcollection`) REFERENCES `collections` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

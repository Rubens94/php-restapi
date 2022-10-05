-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 05-10-2022 a las 20:46:10
-- Versión del servidor: 5.7.36
-- Versión de PHP: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba` 
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lazynfts`
--

CREATE TABLE `lazynfts` (
  `NFTid` int(11) NOT NULL,
  `idcollection` int(11) NOT NULL,
  `NFTDescription` varchar(500) NOT NULL,
  `TicketNumber` int(11) NOT NULL COMMENT '# ticket para sorteo',
  `ImagePreview` varchar(500) NOT NULL COMMENT 'URL de preview',
  `ImageHD` varchar(500) NOT NULL COMMENT 'URL en HD',
  `Attributes` json NOT NULL COMMENT 'Atributos en JSON',
  `Minted` tinyint(1) NOT NULL DEFAULT '0',
  `OwnerAddress` varchar(100) DEFAULT NULL,
  `TxnHash` varchar(100) DEFAULT NULL COMMENT 'Transaction Hash',
  `TimeStampMinted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla para almacenar NFTs potenaicales de minteo';

--
-- Volcado de datos para la tabla `lazynfts`
--

INSERT INTO `lazynfts` (`NFTid`, `idcollection`, `NFTDescription`, `TicketNumber`, `ImagePreview`, `ImageHD`, `Attributes`, `Minted`, `OwnerAddress`, `TxnHash`, `TimeStampMinted`) VALUES
(1, 1, 'Rocky Neko Ticket #500', 500, 'https://rockyneko.rocks/NFTrep/prev/img787j67dsj52gwDyhlm.png', 'https://rockyneko.rocks/NFTrep/HD/imgHDk893rgnb5689RfXz3208l.png', '{\"Eyes\": \"Bored\", \"Hats\": \"Casual\", \"Mouths\": \"Tongue\", \"Others\": \"Tie\", \"Glasses\": \"Oval\", \"Clothing\": \"Vest\"}', 0, NULL, NULL, NULL),
(11, 1, 'Rocky Neko Ticket #500', 500, 'https://rockyneko.rocks/NFTrep/prev/img787j67dsj52gwDyhlm.png', 'https://rockyneko.rocks/NFTrep/HD/imgHDk893rgnb5689RfXz3208l.png', '{\"Eyes\": \"Bored\", \"Hats\": \"Pirate\", \"Mouths\": \"Teeth\", \"Others\": \"Tie\", \"Glasses\": \"Oval\", \"Clothing\": \"Vest\"}', 0, NULL, NULL, NULL),
(12, 1, 'Rocky Neko Ticket #500', 500, 'https://rockyneko.rocks/NFTrep/prev/img787j67dsj52gwDyhlm.png', 'https://rockyneko.rocks/NFTrep/HD/imgHDk893rgnb5689RfXz3208l.png', '{\"Eyes\": \"Bored\", \"Hats\": \"Casual\", \"Mouths\": \"Tongue\", \"Others\": \"Bow\", \"Glasses\": \"Oval\", \"Clothing\": \"Vest\"}', 0, NULL, NULL, NULL),
(13, 1, 'Rocky Neko Ticket #500', 500, 'https://rockyneko.rocks/NFTrep/prev/img787j67dsj52gwDyhlm.png', 'https://rockyneko.rocks/NFTrep/HD/imgHDk893rgnb5689RfXz3208l.png', '{\"Eyes\": \"Bored\", \"Hats\": \"Casual\", \"Mouths\": \"Tongue\", \"Others\": \"Bow\", \"Glasses\": \"Oval\", \"Clothing\": \"Vest\"}', 0, NULL, NULL, NULL),
(14, 1, 'Rocky Neko Ticket #500', 500, 'https://rockyneko.rocks/NFTrep/prev/img787j67dsj52gwDyhlm.png', 'https://rockyneko.rocks/NFTrep/HD/imgHDk893rgnb5689RfXz3208l.png', '{\"Eyes\": \"Bored\", \"Hats\": \"Casual\", \"Mouths\": \"Tongue\", \"Others\": \"Bow\", \"Glasses\": \"Oval\", \"Clothing\": \"Vest\"}', 0, NULL, NULL, NULL),
(15, 1, 'Rocky Neko Ticket #500', 500, 'https://rockyneko.rocks/NFTrep/prev/img787j67dsj52gwDyhlm.png', 'https://rockyneko.rocks/NFTrep/HD/imgHDk893rgnb5689RfXz3208l.png', '{\"Eyes\": \"Bored\", \"Hats\": \"Casual\", \"Mouths\": \"Tongue\", \"Others\": \"Bow\", \"Glasses\": \"Oval\", \"Clothing\": \"Vest\"}', 0, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lazynfts`
--
ALTER TABLE `lazynfts`
  ADD PRIMARY KEY (`NFTid`),
  ADD KEY `collectionFK` (`idcollection`),
  ADD KEY `TicketNumber` (`TicketNumber`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lazynfts`
--
ALTER TABLE `lazynfts`
  MODIFY `NFTid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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

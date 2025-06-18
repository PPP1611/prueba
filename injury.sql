-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-06-2025 a las 16:39:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `injury`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `killer_information`
--

CREATE TABLE `killer_information` (
  `id_asesino` int(11) NOT NULL,
  `name_killer` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `birth_date` varchar(255) NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `period_activity` varchar(255) NOT NULL,
  `victims_number` int(3) NOT NULL,
  `social_context` varchar(255) NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `killer_information`
--

INSERT INTO `killer_information` (`id_asesino`, `name_killer`, `alias`, `birth_date`, `birth_place`, `period_activity`, `victims_number`, `social_context`, `profile_picture`) VALUES
(1, 'Ted Bundy', 'El asesino de estudiantes', '24/11/1946', 'Estados Unidos', '1974-1978', 33, 'Maltratado', 'ted_bundy.png'),
(2, 'Pedro Alonso', 'El monstruo de los Andes', '8/10/1948', 'Colombia', '1969-1980', 300, 'Malo, muy malo', 'pedro_alonso.png'),
(3, 'Niels Hogel', 'El angel de la muerte', '30/12/1976', 'Alemania', '2000-2005', 85, 'Se cree Dios', 'niels_hogel.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `killer_victims`
--

CREATE TABLE `killer_victims` (
  `id_killer_victims` int(11) NOT NULL,
  `id_killer` int(11) NOT NULL,
  `id_victims` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `killer_victims`
--

INSERT INTO `killer_victims` (`id_killer_victims`, `id_killer`, `id_victims`) VALUES
(1, 1, 5),
(2, 1, 4),
(3, 2, 2),
(4, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person`
--

CREATE TABLE `person` (
  `id_persona` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `date_birth` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `person`
--

INSERT INTO `person` (`id_persona`, `name`, `surname`, `date_birth`, `email`) VALUES
(1, 'Paloma', 'Pavía', '16/11/2002', 'paloma.paviaperez76@gmail.com\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `victims`
--

CREATE TABLE `victims` (
  `id_victims` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `crime_place` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `victims`
--

INSERT INTO `victims` (`id_victims`, `name`, `surname`, `age`, `crime_place`) VALUES
(1, 'Carol', 'Valenzuela\r\n', '20', 'Washington'),
(2, 'Lydia ', 'Brandt', '52', 'Alemania'),
(3, 'Herbert', 'Becker', '80', 'Alemania'),
(4, 'Nancy ', 'Wilcox', '16', 'Utah'),
(5, 'Lisa', 'Levy', '20', 'Florida');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `killer_information`
--
ALTER TABLE `killer_information`
  ADD PRIMARY KEY (`id_asesino`);

--
-- Indices de la tabla `killer_victims`
--
ALTER TABLE `killer_victims`
  ADD PRIMARY KEY (`id_killer_victims`),
  ADD KEY `fk_id_killer` (`id_killer`),
  ADD KEY `fk_id_victims` (`id_victims`);

--
-- Indices de la tabla `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `victims`
--
ALTER TABLE `victims`
  ADD PRIMARY KEY (`id_victims`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `killer_information`
--
ALTER TABLE `killer_information`
  MODIFY `id_asesino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `killer_victims`
--
ALTER TABLE `killer_victims`
  MODIFY `id_killer_victims` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `person`
--
ALTER TABLE `person`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `victims`
--
ALTER TABLE `victims`
  MODIFY `id_victims` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `killer_victims`
--
ALTER TABLE `killer_victims`
  ADD CONSTRAINT `fk_id_killer` FOREIGN KEY (`id_killer`) REFERENCES `killer_information` (`id_asesino`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_victims` FOREIGN KEY (`id_victims`) REFERENCES `victims` (`id_victims`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

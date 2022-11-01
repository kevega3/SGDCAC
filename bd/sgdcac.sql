-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-06-2022 a las 15:05:51
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sgdcac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexos`
--

DROP TABLE IF EXISTS `anexos`;
CREATE TABLE IF NOT EXISTS `anexos` (
  `IdAnexo` int(11) NOT NULL AUTO_INCREMENT,
  `numRadicado` varchar(100) NOT NULL,
  `anexadoA` varchar(100) NOT NULL,
  `fechaAnexo` datetime NOT NULL,
  PRIMARY KEY (`IdAnexo`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunicados`
--

DROP TABLE IF EXISTS `comunicados`;
CREATE TABLE IF NOT EXISTS `comunicados` (
  `IdComunicado` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(300) NOT NULL,
  `Numero` varchar(15) NOT NULL,
  `Fecha` date NOT NULL,
  `CuerpoCorreo` varchar(9000) DEFAULT NULL,
  `Asunto` varchar(300) NOT NULL,
  `Texto` varchar(55000) DEFAULT NULL,
  `IdCuenta` int(11) NOT NULL,
  `Enviado` int(11) DEFAULT NULL,
  `FechaCreacion` datetime NOT NULL,
  PRIMARY KEY (`IdComunicado`),
  KEY `IdCuenta` (`IdCuenta`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consecutivos`
--

DROP TABLE IF EXISTS `consecutivos`;
CREATE TABLE IF NOT EXISTS `consecutivos` (
  `IdConsecutivo` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(30) DEFAULT NULL,
  `destinatario` varchar(200) NOT NULL,
  `institucion` varchar(200) NOT NULL,
  `tema` varchar(200) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_tipo_comunicado` int(11) NOT NULL,
  `responsable` varchar(200) NOT NULL,
  `quien_elabora` varchar(200) NOT NULL,
  `reviso` varchar(200) NOT NULL,
  PRIMARY KEY (`IdConsecutivo`),
  KEY `id_tipo_comunicado` (`id_tipo_comunicado`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinaciones`
--

DROP TABLE IF EXISTS `coordinaciones`;
CREATE TABLE IF NOT EXISTS `coordinaciones` (
  `IdCoordinacion` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`IdCoordinacion`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `coordinaciones`
--

INSERT INTO `coordinaciones` (`IdCoordinacion`, `Descripcion`) VALUES
(1, 'Dirección'),
(2, 'Administrativa'),
(3, 'Tecnología'),
(7, 'Conocimiento'),
(9, 'Riesgo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

DROP TABLE IF EXISTS `departamento`;
CREATE TABLE IF NOT EXISTS `departamento` (
  `IdDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`IdDepartamento`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`IdDepartamento`, `Nombre`) VALUES
(5, 'Antioquia'),
(8, 'Atlántico'),
(11, 'Bogotá D.C.'),
(13, 'Bolívar'),
(15, 'Boyacá'),
(17, 'Caldas'),
(18, 'Caquetá'),
(19, 'Cauca'),
(20, 'Cesar'),
(23, 'Córdoba'),
(25, 'Cundinamarca'),
(27, 'Chocó'),
(41, 'Huila'),
(44, 'La Guajira'),
(47, 'Magdalena'),
(50, 'Meta'),
(52, 'Nariño'),
(54, 'Norte de Santander'),
(63, 'Quindío'),
(66, 'Risaralda'),
(68, 'Santander'),
(70, 'Sucre'),
(73, 'Tolima'),
(76, 'Valle del Cauca'),
(81, 'Arauca'),
(85, 'Casanare'),
(86, 'Putumayo'),
(88, 'Archipiélago de San Andrés, Providencia y Santa Catalina'),
(91, 'Amazonas'),
(94, 'Guainía'),
(95, 'Guaviare'),
(97, 'Vaupés'),
(99, 'Vichada'),
(100, 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

DROP TABLE IF EXISTS `devoluciones`;
CREATE TABLE IF NOT EXISTS `devoluciones` (
  `IdDevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `numRadicado` varchar(100) NOT NULL,
  `IdRespuesta` int(11) NOT NULL,
  `fechaDevolucion` datetime NOT NULL,
  `motivo` varchar(5000) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  PRIMARY KEY (`IdDevolucion`),
  KEY `IdRespuesta` (`IdRespuesta`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

DROP TABLE IF EXISTS `envios`;
CREATE TABLE IF NOT EXISTS `envios` (
  `IdDestinatario` int(11) NOT NULL AUTO_INCREMENT,
  `IdComunicado` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `cargo` varchar(200) NOT NULL,
  `trato1` varchar(30) NOT NULL,
  `trato2` varchar(60) NOT NULL,
  `entidad` varchar(200) NOT NULL,
  `regimen` varchar(50) NOT NULL,
  `correo` varchar(1000) NOT NULL,
  `estadoEnvio` int(11) NOT NULL,
  PRIMARY KEY (`IdDestinatario`),
  KEY `IdComunicado` (`IdComunicado`)
) ENGINE=MyISAM AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadopeticion`
--

DROP TABLE IF EXISTS `estadopeticion`;
CREATE TABLE IF NOT EXISTS `estadopeticion` (
  `IdEstado` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`IdEstado`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estadopeticion`
--

INSERT INTO `estadopeticion` (`IdEstado`, `Descripcion`) VALUES
(1, 'Radicado'),
(2, 'Reasignado'),
(3, 'Para aprobar'),
(4, 'Respondido'),
(5, 'No respuesta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadousuario`
--

DROP TABLE IF EXISTS `estadousuario`;
CREATE TABLE IF NOT EXISTS `estadousuario` (
  `IdEstado` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`IdEstado`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estadousuario`
--

INSERT INTO `estadousuario` (`IdEstado`, `Descripcion`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialarchivos`
--

DROP TABLE IF EXISTS `historialarchivos`;
CREATE TABLE IF NOT EXISTS `historialarchivos` (
  `IdArchivo` int(11) NOT NULL AUTO_INCREMENT,
  `IdPeticion` int(11) NOT NULL,
  `numRadico` varchar(100) NOT NULL,
  `nombreArchivo` varchar(200) NOT NULL,
  `anoSubida` varchar(4) NOT NULL,
  `mesSubida` varchar(2) NOT NULL,
  `diaSubida` varchar(2) NOT NULL,
  `rutaArchivo` varchar(200) NOT NULL,
  PRIMARY KEY (`IdArchivo`),
  KEY `IdPeticion` (`IdPeticion`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historialarchivos`
--

INSERT INTO `historialarchivos` (`IdArchivo`, `IdPeticion`, `numRadico`, `nombreArchivo`, `anoSubida`, `mesSubida`, `diaSubida`, `rutaArchivo`) VALUES
(125, 41, 'CR2022062241', 'Preguntas frecuentes en mujeres con hemofilia.pdf', '2022', '06', '22', '../files/2022/06/Preguntas frecuentes en mujeres con hemofilia.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialreasignaciones`
--

DROP TABLE IF EXISTS `historialreasignaciones`;
CREATE TABLE IF NOT EXISTS `historialreasignaciones` (
  `IdReasignacion` int(11) NOT NULL AUTO_INCREMENT,
  `IdPeticion` varchar(200) NOT NULL,
  `IdUsuarioAsignado` int(11) NOT NULL,
  `MotivoReasignacion` varchar(5000) NOT NULL,
  `fechaReasignacion` datetime NOT NULL,
  `IdAsignadoPor` int(11) NOT NULL,
  PRIMARY KEY (`IdReasignacion`),
  KEY `IdUsuarioAsignado` (`IdUsuarioAsignado`),
  KEY `IdAsignadoPor` (`IdAsignadoPor`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialrespuestas`
--

DROP TABLE IF EXISTS `historialrespuestas`;
CREATE TABLE IF NOT EXISTS `historialrespuestas` (
  `IdRespuesta` int(11) NOT NULL AUTO_INCREMENT,
  `numRadicado` varchar(100) NOT NULL,
  `Respuesta` varchar(60000) NOT NULL,
  `FechaRespuesta` date NOT NULL,
  `IdUsuarioAsignado` int(11) NOT NULL,
  `NombreArchivo` varchar(250) NOT NULL,
  `RutaArchivo` varchar(250) NOT NULL,
  `IdEstadoRespuesta` int(11) NOT NULL,
  PRIMARY KEY (`IdRespuesta`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

DROP TABLE IF EXISTS `municipios`;
CREATE TABLE IF NOT EXISTS `municipios` (
  `IdMunicipio` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) NOT NULL,
  `IdDepartamento` int(11) NOT NULL,
  PRIMARY KEY (`IdMunicipio`),
  KEY `IdDepartamento` (`IdDepartamento`)
) ENGINE=MyISAM AUTO_INCREMENT=1125 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`IdMunicipio`, `Descripcion`, `IdDepartamento`) VALUES
(1, 'Medellín', 5),
(2, 'Abejorral', 5),
(3, 'Abriaquí', 5),
(4, 'Alejandría', 5),
(5, 'Amagá', 5),
(6, 'Amalfi', 5),
(7, 'Andes', 5),
(8, 'Angelópolis', 5),
(9, 'Angostura', 5),
(10, 'Anorí', 5),
(11, 'Anza', 5),
(12, 'Apartadó', 5),
(13, 'Arboletes', 5),
(14, 'Argelia', 5),
(15, 'Armenia', 5),
(16, 'Barbosa', 5),
(17, 'Bello', 5),
(18, 'Betania', 5),
(19, 'Betulia', 5),
(20, 'Ciudad Bolívar', 5),
(21, 'Briceño', 5),
(22, 'Buriticá', 5),
(23, 'Cáceres', 5),
(24, 'Caicedo', 5),
(25, 'Caldas', 5),
(26, 'Campamento', 5),
(27, 'Cañasgordas', 5),
(28, 'Caracolí', 5),
(29, 'Caramanta', 5),
(30, 'Carepa', 5),
(31, 'Carolina', 5),
(32, 'Caucasia', 5),
(33, 'Chigorodó', 5),
(34, 'Cisneros', 5),
(35, 'Cocorná', 5),
(36, 'Concepción', 5),
(37, 'Concordia', 5),
(38, 'Copacabana', 5),
(39, 'Dabeiba', 5),
(40, 'Don Matías', 5),
(41, 'Ebéjico', 5),
(42, 'El Bagre', 5),
(43, 'Entrerrios', 5),
(44, 'Envigado', 5),
(45, 'Fredonia', 5),
(46, 'Giraldo', 5),
(47, 'Girardota', 5),
(48, 'Gómez Plata', 5),
(49, 'Guadalupe', 5),
(50, 'Guarne', 5),
(51, 'Guatapé', 5),
(52, 'Heliconia', 5),
(53, 'Hispania', 5),
(54, 'Itagui', 5),
(55, 'Ituango', 5),
(56, 'Belmira', 5),
(57, 'Jericó', 5),
(58, 'La Ceja', 5),
(59, 'La Estrella', 5),
(60, 'La Pintada', 5),
(61, 'La Unión', 5),
(62, 'Liborina', 5),
(63, 'Maceo', 5),
(64, 'Marinilla', 5),
(65, 'Montebello', 5),
(66, 'Murindó', 5),
(67, 'Mutatá', 5),
(68, 'Nariño', 5),
(69, 'Necoclí', 5),
(70, 'Nechí', 5),
(71, 'Olaya', 5),
(72, 'Peñol', 5),
(73, 'Peque', 5),
(74, 'Pueblorrico', 5),
(75, 'Puerto Berrío', 5),
(76, 'Puerto Nare', 5),
(77, 'Puerto Triunfo', 5),
(78, 'Remedios', 5),
(79, 'Retiro', 5),
(80, 'Rionegro', 5),
(81, 'Sabanalarga', 5),
(82, 'Sabaneta', 5),
(83, 'Salgar', 5),
(84, 'San Francisco', 5),
(85, 'San Jerónimo', 5),
(86, 'San Luis', 5),
(87, 'San Pedro', 5),
(88, 'San Rafael', 5),
(89, 'San Roque', 5),
(90, 'San Vicente', 5),
(91, 'Santa Bárbara', 5),
(92, 'Santo Domingo', 5),
(93, 'El Santuario', 5),
(94, 'Segovia', 5),
(95, 'Sopetrán', 5),
(96, 'Támesis', 5),
(97, 'Tarazá', 5),
(98, 'Tarso', 5),
(99, 'Titiribí', 5),
(100, 'Toledo', 5),
(101, 'Turbo', 5),
(102, 'Uramita', 5),
(103, 'Urrao', 5),
(104, 'Valdivia', 5),
(105, 'Valparaíso', 5),
(106, 'Vegachí', 5),
(107, 'Venecia', 5),
(108, 'Yalí', 5),
(109, 'Yarumal', 5),
(110, 'Yolombó', 5),
(111, 'Yondó', 5),
(112, 'Zaragoza', 5),
(113, 'San Pedro de Uraba', 5),
(114, 'Santafé de Antioquia', 5),
(115, 'Santa Rosa de Osos', 5),
(116, 'San Andrés de Cuerquía', 5),
(117, 'Vigía del Fuerte', 5),
(118, 'San José de La Montaña', 5),
(119, 'San Juan de Urabá', 5),
(120, 'El Carmen de Viboral', 5),
(121, 'San Carlos', 5),
(122, 'Frontino', 5),
(123, 'Granada', 5),
(124, 'Jardín', 5),
(125, 'Sonsón', 5),
(126, 'Barranquilla', 8),
(127, 'Baranoa', 8),
(128, 'Candelaria', 8),
(129, 'Galapa', 8),
(130, 'Luruaco', 8),
(131, 'Malambo', 8),
(132, 'Manatí', 8),
(133, 'Piojó', 8),
(134, 'Polonuevo', 8),
(135, 'Sabanagrande', 8),
(136, 'Sabanalarga', 8),
(137, 'Santa Lucía', 8),
(138, 'Santo Tomás', 8),
(139, 'Soledad', 8),
(140, 'Suan', 8),
(141, 'Tubará', 8),
(142, 'Usiacurí', 8),
(143, 'Juan de Acosta', 8),
(144, 'Palmar de Varela', 8),
(145, 'Campo de La Cruz', 8),
(146, 'Repelón', 8),
(147, 'Puerto Colombia', 8),
(148, 'Ponedera', 8),
(149, 'Bogotá D.C.', 11),
(150, 'Achí', 13),
(151, 'Arenal', 13),
(152, 'Arjona', 13),
(153, 'Arroyohondo', 13),
(154, 'Calamar', 13),
(155, 'Cantagallo', 13),
(156, 'Cicuco', 13),
(157, 'Córdoba', 13),
(158, 'Clemencia', 13),
(159, 'El Guamo', 13),
(160, 'Magangué', 13),
(161, 'Mahates', 13),
(162, 'Margarita', 13),
(163, 'Montecristo', 13),
(164, 'Mompós', 13),
(165, 'Morales', 13),
(166, 'Norosí', 13),
(167, 'Pinillos', 13),
(168, 'Regidor', 13),
(169, 'Río Viejo', 13),
(170, 'San Estanislao', 13),
(171, 'San Fernando', 13),
(172, 'San Juan Nepomuceno', 13),
(173, 'Santa Catalina', 13),
(174, 'Santa Rosa', 13),
(175, 'Simití', 13),
(176, 'Soplaviento', 13),
(177, 'Talaigua Nuevo', 13),
(178, 'Tiquisio', 13),
(179, 'Turbaco', 13),
(180, 'Turbaná', 13),
(181, 'Villanueva', 13),
(182, 'Barranco de Loba', 13),
(183, 'Santa Rosa del Sur', 13),
(184, 'Hatillo de Loba', 13),
(185, 'El Carmen de Bolívar', 13),
(186, 'San Martín de Loba', 13),
(187, 'Altos del Rosario', 13),
(188, 'San Jacinto del Cauca', 13),
(189, 'San Pablo de Borbur', 13),
(190, 'San Jacinto', 13),
(191, 'El Peñón', 13),
(192, 'Cartagena', 13),
(193, 'María la Baja', 13),
(194, 'San Cristóbal', 13),
(195, 'Zambrano', 13),
(196, 'Tununguá', 15),
(197, 'Motavita', 15),
(198, 'Ciénega', 15),
(199, 'Tunja', 15),
(200, 'Almeida', 15),
(201, 'Aquitania', 15),
(202, 'Arcabuco', 15),
(203, 'Berbeo', 15),
(204, 'Betéitiva', 15),
(205, 'Boavita', 15),
(206, 'Boyacá', 15),
(207, 'Briceño', 15),
(208, 'Buena Vista', 15),
(209, 'Busbanzá', 15),
(210, 'Caldas', 15),
(211, 'Campohermoso', 15),
(212, 'Cerinza', 15),
(213, 'Chinavita', 15),
(214, 'Chiquinquirá', 15),
(215, 'Chiscas', 15),
(216, 'Chita', 15),
(217, 'Chitaraque', 15),
(218, 'Chivatá', 15),
(219, 'Cómbita', 15),
(220, 'Coper', 15),
(221, 'Corrales', 15),
(222, 'Covarachía', 15),
(223, 'Cubará', 15),
(224, 'Cucaita', 15),
(225, 'Cuítiva', 15),
(226, 'Chíquiza', 15),
(227, 'Chivor', 15),
(228, 'Duitama', 15),
(229, 'El Cocuy', 15),
(230, 'El Espino', 15),
(231, 'Firavitoba', 15),
(232, 'Floresta', 15),
(233, 'Gachantivá', 15),
(234, 'Gameza', 15),
(235, 'Garagoa', 15),
(236, 'Guacamayas', 15),
(237, 'Guateque', 15),
(238, 'Guayatá', 15),
(239, 'Güicán', 15),
(240, 'Iza', 15),
(241, 'Jenesano', 15),
(242, 'Jericó', 15),
(243, 'Labranzagrande', 15),
(244, 'La Capilla', 15),
(245, 'La Victoria', 15),
(246, 'Macanal', 15),
(247, 'Maripí', 15),
(248, 'Miraflores', 15),
(249, 'Mongua', 15),
(250, 'Monguí', 15),
(251, 'Moniquirá', 15),
(252, 'Muzo', 15),
(253, 'Nobsa', 15),
(254, 'Nuevo Colón', 15),
(255, 'Oicatá', 15),
(256, 'Otanche', 15),
(257, 'Pachavita', 15),
(258, 'Páez', 15),
(259, 'Paipa', 15),
(260, 'Pajarito', 15),
(261, 'Panqueba', 15),
(262, 'Pauna', 15),
(263, 'Paya', 15),
(264, 'Pesca', 15),
(265, 'Pisba', 15),
(266, 'Puerto Boyacá', 15),
(267, 'Quípama', 15),
(268, 'Ramiriquí', 15),
(269, 'Ráquira', 15),
(270, 'Rondón', 15),
(271, 'Saboyá', 15),
(272, 'Sáchica', 15),
(273, 'Samacá', 15),
(274, 'San Eduardo', 15),
(275, 'San Mateo', 15),
(276, 'Santana', 15),
(277, 'Santa María', 15),
(278, 'Santa Sofía', 15),
(279, 'Sativanorte', 15),
(280, 'Sativasur', 15),
(281, 'Siachoque', 15),
(282, 'Soatá', 15),
(283, 'Socotá', 15),
(284, 'Socha', 15),
(285, 'Sogamoso', 15),
(286, 'Somondoco', 15),
(287, 'Sora', 15),
(288, 'Sotaquirá', 15),
(289, 'Soracá', 15),
(290, 'Susacón', 15),
(291, 'Sutamarchán', 15),
(292, 'Sutatenza', 15),
(293, 'Tasco', 15),
(294, 'Tenza', 15),
(295, 'Tibaná', 15),
(296, 'Tinjacá', 15),
(297, 'Tipacoque', 15),
(298, 'Toca', 15),
(299, 'Tópaga', 15),
(300, 'Tota', 15),
(301, 'Turmequé', 15),
(302, 'Tutazá', 15),
(303, 'Umbita', 15),
(304, 'Ventaquemada', 15),
(305, 'Viracachá', 15),
(306, 'Zetaquira', 15),
(307, 'Togüí', 15),
(308, 'Villa de Leyva', 15),
(309, 'Paz de Río', 15),
(310, 'Santa Rosa de Viterbo', 15),
(311, 'San Pablo de Borbur', 15),
(312, 'San Luis de Gaceno', 15),
(313, 'San José de Pare', 15),
(314, 'San Miguel de Sema', 15),
(315, 'Tuta', 15),
(316, 'Tibasosa', 15),
(317, 'La Uvita', 15),
(318, 'Belén', 15),
(319, 'Manizales', 17),
(320, 'Aguadas', 17),
(321, 'Anserma', 17),
(322, 'Aranzazu', 17),
(323, 'Belalcázar', 17),
(324, 'Chinchiná', 17),
(325, 'Filadelfia', 17),
(326, 'La Dorada', 17),
(327, 'La Merced', 17),
(328, 'Manzanares', 17),
(329, 'Marmato', 17),
(330, 'Marulanda', 17),
(331, 'Neira', 17),
(332, 'Norcasia', 17),
(333, 'Pácora', 17),
(334, 'Palestina', 17),
(335, 'Pensilvania', 17),
(336, 'Riosucio', 17),
(337, 'Risaralda', 17),
(338, 'Salamina', 17),
(339, 'Samaná', 17),
(340, 'San José', 17),
(341, 'Supía', 17),
(342, 'Victoria', 17),
(343, 'Villamaría', 17),
(344, 'Viterbo', 17),
(345, 'Marquetalia', 17),
(346, 'Florencia', 18),
(347, 'Albania', 18),
(348, 'Curillo', 18),
(349, 'El Doncello', 18),
(350, 'El Paujil', 18),
(351, 'Morelia', 18),
(352, 'Puerto Rico', 18),
(353, 'Solano', 18),
(354, 'Solita', 18),
(355, 'Valparaíso', 18),
(356, 'San José del Fragua', 18),
(357, 'Belén de Los Andaquies', 18),
(358, 'Cartagena del Chairá', 18),
(359, 'Milán', 18),
(360, 'La Montañita', 18),
(361, 'San Vicente del Caguán', 18),
(362, 'Popayán', 19),
(363, 'Almaguer', 19),
(364, 'Argelia', 19),
(365, 'Balboa', 19),
(366, 'Bolívar', 19),
(367, 'Buenos Aires', 19),
(368, 'Cajibío', 19),
(369, 'Caldono', 19),
(370, 'Caloto', 19),
(371, 'Corinto', 19),
(372, 'El Tambo', 19),
(373, 'Florencia', 19),
(374, 'Guachené', 19),
(375, 'Guapi', 19),
(376, 'Inzá', 19),
(377, 'Jambaló', 19),
(378, 'La Sierra', 19),
(379, 'La Vega', 19),
(380, 'López', 19),
(381, 'Mercaderes', 19),
(382, 'Miranda', 19),
(383, 'Morales', 19),
(384, 'Padilla', 19),
(385, 'Patía', 19),
(386, 'Piamonte', 19),
(387, 'Piendamó', 19),
(388, 'Puerto Tejada', 19),
(389, 'Puracé', 19),
(390, 'Rosas', 19),
(391, 'Santa Rosa', 19),
(392, 'Silvia', 19),
(393, 'Sotara', 19),
(394, 'Suárez', 19),
(395, 'Sucre', 19),
(396, 'Timbío', 19),
(397, 'Timbiquí', 19),
(398, 'Toribio', 19),
(399, 'Totoró', 19),
(400, 'Villa Rica', 19),
(401, 'Santander de Quilichao', 19),
(402, 'San Sebastián', 19),
(403, 'Páez', 19),
(404, 'Valledupar', 20),
(405, 'Aguachica', 20),
(406, 'Agustín Codazzi', 20),
(407, 'Astrea', 20),
(408, 'Becerril', 20),
(409, 'Bosconia', 20),
(410, 'Chimichagua', 20),
(411, 'Chiriguaná', 20),
(412, 'Curumaní', 20),
(413, 'El Copey', 20),
(414, 'El Paso', 20),
(415, 'Gamarra', 20),
(416, 'González', 20),
(417, 'La Gloria', 20),
(418, 'Manaure', 20),
(419, 'Pailitas', 20),
(420, 'Pelaya', 20),
(421, 'Pueblo Bello', 20),
(422, 'La Paz', 20),
(423, 'San Alberto', 20),
(424, 'San Diego', 20),
(425, 'San Martín', 20),
(426, 'Tamalameque', 20),
(427, 'Río de Oro', 20),
(428, 'La Jagua de Ibirico', 20),
(429, 'San Bernardo del Viento', 23),
(430, 'Montería', 23),
(431, 'Ayapel', 23),
(432, 'Buenavista', 23),
(433, 'Canalete', 23),
(434, 'Cereté', 23),
(435, 'Chimá', 23),
(436, 'Chinú', 23),
(437, 'Cotorra', 23),
(438, 'Lorica', 23),
(439, 'Los Córdobas', 23),
(440, 'Momil', 23),
(441, 'Moñitos', 23),
(442, 'Planeta Rica', 23),
(443, 'Pueblo Nuevo', 23),
(444, 'Puerto Escondido', 23),
(445, 'Purísima', 23),
(446, 'Sahagún', 23),
(447, 'San Andrés Sotavento', 23),
(448, 'San Antero', 23),
(449, 'San Pelayo', 23),
(450, 'Tierralta', 23),
(451, 'Tuchín', 23),
(452, 'Valencia', 23),
(453, 'San José de Uré', 23),
(454, 'Ciénaga de Oro', 23),
(455, 'San Carlos', 23),
(456, 'Montelíbano', 23),
(457, 'La Apartada', 23),
(458, 'Puerto Libertador', 23),
(459, 'Anapoima', 25),
(460, 'Arbeláez', 25),
(461, 'Beltrán', 25),
(462, 'Bituima', 25),
(463, 'Bojacá', 25),
(464, 'Cabrera', 25),
(465, 'Cachipay', 25),
(466, 'Cajicá', 25),
(467, 'Caparrapí', 25),
(468, 'Caqueza', 25),
(469, 'Chaguaní', 25),
(470, 'Chipaque', 25),
(471, 'Choachí', 25),
(472, 'Chocontá', 25),
(473, 'Cogua', 25),
(474, 'Cota', 25),
(475, 'Cucunubá', 25),
(476, 'El Colegio', 25),
(477, 'El Rosal', 25),
(478, 'Fomeque', 25),
(479, 'Fosca', 25),
(480, 'Funza', 25),
(481, 'Fúquene', 25),
(482, 'Gachala', 25),
(483, 'Gachancipá', 25),
(484, 'Gachetá', 25),
(485, 'Girardot', 25),
(486, 'Granada', 25),
(487, 'Guachetá', 25),
(488, 'Guaduas', 25),
(489, 'Guasca', 25),
(490, 'Guataquí', 25),
(491, 'Guatavita', 25),
(492, 'Guayabetal', 25),
(493, 'Gutiérrez', 25),
(494, 'Jerusalén', 25),
(495, 'Junín', 25),
(496, 'La Calera', 25),
(497, 'La Mesa', 25),
(498, 'La Palma', 25),
(499, 'La Peña', 25),
(500, 'La Vega', 25),
(501, 'Lenguazaque', 25),
(502, 'Macheta', 25),
(503, 'Madrid', 25),
(504, 'Manta', 25),
(505, 'Medina', 25),
(506, 'Mosquera', 25),
(507, 'Nariño', 25),
(508, 'Nemocón', 25),
(509, 'Nilo', 25),
(510, 'Nimaima', 25),
(511, 'Nocaima', 25),
(512, 'Venecia', 25),
(513, 'Pacho', 25),
(514, 'Paime', 25),
(515, 'Pandi', 25),
(516, 'Paratebueno', 25),
(517, 'Pasca', 25),
(518, 'Puerto Salgar', 25),
(519, 'Pulí', 25),
(520, 'Quebradanegra', 25),
(521, 'Quetame', 25),
(522, 'Quipile', 25),
(523, 'Apulo', 25),
(524, 'Ricaurte', 25),
(525, 'San Bernardo', 25),
(526, 'San Cayetano', 25),
(527, 'San Francisco', 25),
(528, 'Sesquilé', 25),
(529, 'Sibaté', 25),
(530, 'Silvania', 25),
(531, 'Simijaca', 25),
(532, 'Soacha', 25),
(533, 'Subachoque', 25),
(534, 'Suesca', 25),
(535, 'Supatá', 25),
(536, 'Susa', 25),
(537, 'Sutatausa', 25),
(538, 'Tabio', 25),
(539, 'Tausa', 25),
(540, 'Tena', 25),
(541, 'Tenjo', 25),
(542, 'Tibacuy', 25),
(543, 'Tibirita', 25),
(544, 'Tocaima', 25),
(545, 'Tocancipá', 25),
(546, 'Topaipí', 25),
(547, 'Ubalá', 25),
(548, 'Ubaque', 25),
(549, 'Une', 25),
(550, 'Útica', 25),
(551, 'Vianí', 25),
(552, 'Villagómez', 25),
(553, 'Villapinzón', 25),
(554, 'Villeta', 25),
(555, 'Viotá', 25),
(556, 'Zipacón', 25),
(557, 'San Juan de Río Seco', 25),
(558, 'Villa de San Diego de Ubate', 25),
(559, 'Guayabal de Siquima', 25),
(560, 'San Antonio del Tequendama', 25),
(561, 'Agua de Dios', 25),
(562, 'Carmen de Carupa', 25),
(563, 'Vergara', 25),
(564, 'Albán', 25),
(565, 'Anolaima', 25),
(566, 'Chía', 25),
(567, 'El Peñón', 25),
(568, 'Sopó', 25),
(569, 'Gama', 25),
(570, 'Sasaima', 25),
(571, 'Yacopí', 25),
(572, 'Fusagasugá', 25),
(573, 'Zipaquirá', 25),
(574, 'Facatativá', 25),
(575, 'Istmina', 27),
(576, 'Quibdó', 27),
(577, 'Acandí', 27),
(578, 'Alto Baudo', 27),
(579, 'Atrato', 27),
(580, 'Bagadó', 27),
(581, 'Bahía Solano', 27),
(582, 'Bajo Baudó', 27),
(583, 'Bojaya', 27),
(584, 'Cértegui', 27),
(585, 'Condoto', 27),
(586, 'Juradó', 27),
(587, 'Lloró', 27),
(588, 'Medio Atrato', 27),
(589, 'Medio Baudó', 27),
(590, 'Medio San Juan', 27),
(591, 'Nóvita', 27),
(592, 'Nuquí', 27),
(593, 'Río Iro', 27),
(594, 'Río Quito', 27),
(595, 'Riosucio', 27),
(596, 'Sipí', 27),
(597, 'Unguía', 27),
(598, 'El Litoral del San Juan', 27),
(599, 'El Cantón del San Pablo', 27),
(600, 'El Carmen de Atrato', 27),
(601, 'San José del Palmar', 27),
(602, 'Belén de Bajira', 27),
(603, 'Carmen del Darien', 27),
(604, 'Tadó', 27),
(605, 'Unión Panamericana', 27),
(606, 'Neiva', 41),
(607, 'Acevedo', 41),
(608, 'Agrado', 41),
(609, 'Aipe', 41),
(610, 'Algeciras', 41),
(611, 'Altamira', 41),
(612, 'Baraya', 41),
(613, 'Campoalegre', 41),
(614, 'Colombia', 41),
(615, 'Elías', 41),
(616, 'Garzón', 41),
(617, 'Gigante', 41),
(618, 'Guadalupe', 41),
(619, 'Hobo', 41),
(620, 'Iquira', 41),
(621, 'Isnos', 41),
(622, 'La Argentina', 41),
(623, 'La Plata', 41),
(624, 'Nátaga', 41),
(625, 'Oporapa', 41),
(626, 'Paicol', 41),
(627, 'Palermo', 41),
(628, 'Palestina', 41),
(629, 'Pital', 41),
(630, 'Pitalito', 41),
(631, 'Rivera', 41),
(632, 'Saladoblanco', 41),
(633, 'Santa María', 41),
(634, 'Suaza', 41),
(635, 'Tarqui', 41),
(636, 'Tesalia', 41),
(637, 'Tello', 41),
(638, 'Teruel', 41),
(639, 'Timaná', 41),
(640, 'Villavieja', 41),
(641, 'Yaguará', 41),
(642, 'San Agustín', 41),
(643, 'Riohacha', 44),
(644, 'Albania', 44),
(645, 'Barrancas', 44),
(646, 'Dibula', 44),
(647, 'Distracción', 44),
(648, 'El Molino', 44),
(649, 'Fonseca', 44),
(650, 'Hatonuevo', 44),
(651, 'Maicao', 44),
(652, 'Manaure', 44),
(653, 'Uribia', 44),
(654, 'Urumita', 44),
(655, 'Villanueva', 44),
(656, 'La Jagua del Pilar', 44),
(657, 'San Juan del Cesar', 44),
(658, 'Santa Marta', 47),
(659, 'Algarrobo', 47),
(660, 'Aracataca', 47),
(661, 'Ariguaní', 47),
(662, 'Cerro San Antonio', 47),
(663, 'Chivolo', 47),
(664, 'Concordia', 47),
(665, 'El Banco', 47),
(666, 'El Piñon', 47),
(667, 'El Retén', 47),
(668, 'Fundación', 47),
(669, 'Guamal', 47),
(670, 'Nueva Granada', 47),
(671, 'Pedraza', 47),
(672, 'Pivijay', 47),
(673, 'Plato', 47),
(674, 'Remolino', 47),
(675, 'Salamina', 47),
(676, 'San Zenón', 47),
(677, 'Santa Ana', 47),
(678, 'Sitionuevo', 47),
(679, 'Tenerife', 47),
(680, 'Zapayán', 47),
(681, 'Zona Bananera', 47),
(682, 'San Sebastián de Buenavista', 47),
(683, 'Sabanas de San Angel', 47),
(684, 'Pijiño del Carmen', 47),
(685, 'Santa Bárbara de Pinto', 47),
(686, 'Pueblo Viejo', 47),
(687, 'Ciénaga', 47),
(688, 'Villavicencio', 50),
(689, 'Acacias', 50),
(690, 'Cabuyaro', 50),
(691, 'Cubarral', 50),
(692, 'Cumaral', 50),
(693, 'El Calvario', 50),
(694, 'El Castillo', 50),
(695, 'El Dorado', 50),
(696, 'Granada', 50),
(697, 'Guamal', 50),
(698, 'Mapiripán', 50),
(699, 'Mesetas', 50),
(700, 'La Macarena', 50),
(701, 'Uribe', 50),
(702, 'Lejanías', 50),
(703, 'Puerto Concordia', 50),
(704, 'Puerto Gaitán', 50),
(705, 'Puerto López', 50),
(706, 'Puerto Lleras', 50),
(707, 'Puerto Rico', 50),
(708, 'Restrepo', 50),
(709, 'San Juanito', 50),
(710, 'San Martín', 50),
(711, 'Vista Hermosa', 50),
(712, 'Barranca de Upía', 50),
(713, 'Fuente de Oro', 50),
(714, 'San Carlos de Guaroa', 50),
(715, 'San Juan de Arama', 50),
(716, 'Castilla la Nueva', 50),
(717, 'Santacruz', 52),
(718, 'Pasto', 52),
(719, 'Albán', 52),
(720, 'Aldana', 52),
(721, 'Ancuyá', 52),
(722, 'Barbacoas', 52),
(723, 'Colón', 52),
(724, 'Consaca', 52),
(725, 'Contadero', 52),
(726, 'Córdoba', 52),
(727, 'Cuaspud', 52),
(728, 'Cumbal', 52),
(729, 'Cumbitara', 52),
(730, 'El Charco', 52),
(731, 'El Peñol', 52),
(732, 'El Rosario', 52),
(733, 'El Tambo', 52),
(734, 'Funes', 52),
(735, 'Guachucal', 52),
(736, 'Guaitarilla', 52),
(737, 'Gualmatán', 52),
(738, 'Iles', 52),
(739, 'Imués', 52),
(740, 'Ipiales', 52),
(741, 'La Cruz', 52),
(742, 'La Florida', 52),
(743, 'La Llanada', 52),
(744, 'La Tola', 52),
(745, 'La Unión', 52),
(746, 'Leiva', 52),
(747, 'Linares', 52),
(748, 'Los Andes', 52),
(749, 'Magüí', 52),
(750, 'Mallama', 52),
(751, 'Mosquera', 52),
(752, 'Nariño', 52),
(753, 'Olaya Herrera', 52),
(754, 'Ospina', 52),
(755, 'Francisco Pizarro', 52),
(756, 'Policarpa', 52),
(757, 'Potosí', 52),
(758, 'Providencia', 52),
(759, 'Puerres', 52),
(760, 'Pupiales', 52),
(761, 'Ricaurte', 52),
(762, 'Roberto Payán', 52),
(763, 'Samaniego', 52),
(764, 'Sandoná', 52),
(765, 'San Bernardo', 52),
(766, 'San Lorenzo', 52),
(767, 'San Pablo', 52),
(768, 'Santa Bárbara', 52),
(769, 'Sapuyes', 52),
(770, 'Taminango', 52),
(771, 'Tangua', 52),
(772, 'Túquerres', 52),
(773, 'Yacuanquer', 52),
(774, 'San Pedro de Cartago', 52),
(775, 'El Tablón de Gómez', 52),
(776, 'Buesaco', 52),
(777, 'San Andrés de Tumaco', 52),
(778, 'Belén', 52),
(779, 'Chachagüí', 52),
(780, 'Arboleda', 52),
(781, 'Silos', 54),
(782, 'Cácota', 54),
(783, 'Toledo', 54),
(784, 'Mutiscua', 54),
(785, 'El Zulia', 54),
(786, 'Salazar', 54),
(787, 'Cucutilla', 54),
(788, 'Puerto Santander', 54),
(789, 'Gramalote', 54),
(790, 'El Tarra', 54),
(791, 'Teorama', 54),
(792, 'Arboledas', 54),
(793, 'Lourdes', 54),
(794, 'Bochalema', 54),
(795, 'Convención', 54),
(796, 'Hacarí', 54),
(797, 'Herrán', 54),
(798, 'Tibú', 54),
(799, 'San Cayetano', 54),
(800, 'San Calixto', 54),
(801, 'La Playa', 54),
(802, 'Chinácota', 54),
(803, 'Ragonvalia', 54),
(804, 'La Esperanza', 54),
(805, 'Villa del Rosario', 54),
(806, 'Chitagá', 54),
(807, 'Sardinata', 54),
(808, 'Abrego', 54),
(809, 'Los Patios', 54),
(810, 'Ocaña', 54),
(811, 'Bucarasica', 54),
(812, 'Santiago', 54),
(813, 'Labateca', 54),
(814, 'Cachirá', 54),
(815, 'Villa Caro', 54),
(816, 'Durania', 54),
(817, 'Pamplona', 54),
(818, 'Pamplonita', 54),
(819, 'Cúcuta', 54),
(820, 'El Carmen', 54),
(821, 'Armenia', 63),
(822, 'Buenavista', 63),
(823, 'Circasia', 63),
(824, 'Córdoba', 63),
(825, 'Filandia', 63),
(826, 'La Tebaida', 63),
(827, 'Montenegro', 63),
(828, 'Pijao', 63),
(829, 'Quimbaya', 63),
(830, 'Salento', 63),
(831, 'Calarcá', 63),
(832, 'Génova', 63),
(833, 'Pereira', 66),
(834, 'Apía', 66),
(835, 'Balboa', 66),
(836, 'Dosquebradas', 66),
(837, 'Guática', 66),
(838, 'La Celia', 66),
(839, 'La Virginia', 66),
(840, 'Marsella', 66),
(841, 'Mistrató', 66),
(842, 'Pueblo Rico', 66),
(843, 'Quinchía', 66),
(844, 'Santuario', 66),
(845, 'Santa Rosa de Cabal', 66),
(846, 'Belén de Umbría', 66),
(847, 'Puerto Wilches', 68),
(848, 'Puerto Parra', 68),
(849, 'Bucaramanga', 68),
(850, 'Aguada', 68),
(851, 'Albania', 68),
(852, 'Aratoca', 68),
(853, 'Barbosa', 68),
(854, 'Barichara', 68),
(855, 'Barrancabermeja', 68),
(856, 'Betulia', 68),
(857, 'Bolívar', 68),
(858, 'Cabrera', 68),
(859, 'California', 68),
(860, 'Carcasí', 68),
(861, 'Cepitá', 68),
(862, 'Cerrito', 68),
(863, 'Charalá', 68),
(864, 'Charta', 68),
(865, 'Chipatá', 68),
(866, 'Cimitarra', 68),
(867, 'Concepción', 68),
(868, 'Confines', 68),
(869, 'Contratación', 68),
(870, 'Coromoro', 68),
(871, 'Curití', 68),
(872, 'El Guacamayo', 68),
(873, 'El Playón', 68),
(874, 'Encino', 68),
(875, 'Enciso', 68),
(876, 'Florián', 68),
(877, 'Floridablanca', 68),
(878, 'Galán', 68),
(879, 'Gambita', 68),
(880, 'Girón', 68),
(881, 'Guaca', 68),
(882, 'Guadalupe', 68),
(883, 'Guapotá', 68),
(884, 'Guavatá', 68),
(885, 'Güepsa', 68),
(886, 'Jesús María', 68),
(887, 'Jordán', 68),
(888, 'La Belleza', 68),
(889, 'Landázuri', 68),
(890, 'La Paz', 68),
(891, 'Lebríja', 68),
(892, 'Los Santos', 68),
(893, 'Macaravita', 68),
(894, 'Málaga', 68),
(895, 'Matanza', 68),
(896, 'Mogotes', 68),
(897, 'Molagavita', 68),
(898, 'Ocamonte', 68),
(899, 'Oiba', 68),
(900, 'Onzaga', 68),
(901, 'Palmar', 68),
(902, 'Páramo', 68),
(903, 'Piedecuesta', 68),
(904, 'Pinchote', 68),
(905, 'Puente Nacional', 68),
(906, 'Rionegro', 68),
(907, 'San Andrés', 68),
(908, 'San Gil', 68),
(909, 'San Joaquín', 68),
(910, 'San Miguel', 68),
(911, 'Santa Bárbara', 68),
(912, 'Simacota', 68),
(913, 'Socorro', 68),
(914, 'Suaita', 68),
(915, 'Sucre', 68),
(916, 'Suratá', 68),
(917, 'Tona', 68),
(918, 'Vélez', 68),
(919, 'Vetas', 68),
(920, 'Villanueva', 68),
(921, 'Zapatoca', 68),
(922, 'Palmas del Socorro', 68),
(923, 'San Vicente de Chucurí', 68),
(924, 'San José de Miranda', 68),
(925, 'Santa Helena del Opón', 68),
(926, 'Sabana de Torres', 68),
(927, 'El Carmen de Chucurí', 68),
(928, 'Valle de San José', 68),
(929, 'San Benito', 68),
(930, 'Hato', 68),
(931, 'Chimá', 68),
(932, 'Capitanejo', 68),
(933, 'El Peñón', 68),
(934, 'Sincelejo', 70),
(935, 'Buenavista', 70),
(936, 'Caimito', 70),
(937, 'Coloso', 70),
(938, 'Coveñas', 70),
(939, 'Chalán', 70),
(940, 'El Roble', 70),
(941, 'Galeras', 70),
(942, 'Guaranda', 70),
(943, 'La Unión', 70),
(944, 'Los Palmitos', 70),
(945, 'Majagual', 70),
(946, 'Morroa', 70),
(947, 'Ovejas', 70),
(948, 'Palmito', 70),
(949, 'San Benito Abad', 70),
(950, 'San Marcos', 70),
(951, 'San Onofre', 70),
(952, 'San Pedro', 70),
(953, 'Sucre', 70),
(954, 'Tolú Viejo', 70),
(955, 'San Luis de Sincé', 70),
(956, 'San Juan de Betulia', 70),
(957, 'Santiago de Tolú', 70),
(958, 'Sampués', 70),
(959, 'Corozal', 70),
(960, 'Alpujarra', 73),
(961, 'Alvarado', 73),
(962, 'Ambalema', 73),
(963, 'Armero', 73),
(964, 'Ataco', 73),
(965, 'Cajamarca', 73),
(966, 'Chaparral', 73),
(967, 'Coello', 73),
(968, 'Coyaima', 73),
(969, 'Cunday', 73),
(970, 'Dolores', 73),
(971, 'Espinal', 73),
(972, 'Falan', 73),
(973, 'Flandes', 73),
(974, 'Fresno', 73),
(975, 'Guamo', 73),
(976, 'Herveo', 73),
(977, 'Honda', 73),
(978, 'Icononzo', 73),
(979, 'Mariquita', 73),
(980, 'Melgar', 73),
(981, 'Murillo', 73),
(982, 'Natagaima', 73),
(983, 'Ortega', 73),
(984, 'Palocabildo', 73),
(985, 'Piedras', 73),
(986, 'Planadas', 73),
(987, 'Prado', 73),
(988, 'Purificación', 73),
(989, 'Rio Blanco', 73),
(990, 'Roncesvalles', 73),
(991, 'Rovira', 73),
(992, 'Saldaña', 73),
(993, 'Santa Isabel', 73),
(994, 'Venadillo', 73),
(995, 'Villahermosa', 73),
(996, 'Villarrica', 73),
(997, 'Valle de San Juan', 73),
(998, 'Carmen de Apicala', 73),
(999, 'San Luis', 73),
(1000, 'San Antonio', 73),
(1001, 'Casabianca', 73),
(1002, 'Anzoátegui', 73),
(1003, 'Ibagué', 73),
(1004, 'Líbano', 73),
(1005, 'Lérida', 73),
(1006, 'Suárez', 73),
(1007, 'El Dovio', 76),
(1008, 'Roldanillo', 76),
(1009, 'Argelia', 76),
(1010, 'Sevilla', 76),
(1011, 'Zarzal', 76),
(1012, 'El Cerrito', 76),
(1013, 'Cartago', 76),
(1014, 'Caicedonia', 76),
(1015, 'El Cairo', 76),
(1016, 'La Unión', 76),
(1017, 'Restrepo', 76),
(1018, 'Dagua', 76),
(1019, 'Guacarí', 76),
(1020, 'Ansermanuevo', 76),
(1021, 'Bugalagrande', 76),
(1022, 'La Victoria', 76),
(1023, 'Ginebra', 76),
(1024, 'Yumbo', 76),
(1025, 'Obando', 76),
(1026, 'Bolívar', 76),
(1027, 'Cali', 76),
(1028, 'San Pedro', 76),
(1029, 'Guadalajara de Buga', 76),
(1030, 'Calima', 76),
(1031, 'Andalucía', 76),
(1032, 'Pradera', 76),
(1033, 'Yotoco', 76),
(1034, 'Palmira', 76),
(1035, 'Riofrío', 76),
(1036, 'Alcalá', 76),
(1037, 'Versalles', 76),
(1038, 'El Águila', 76),
(1039, 'Toro', 76),
(1040, 'Candelaria', 76),
(1041, 'La Cumbre', 76),
(1042, 'Ulloa', 76),
(1043, 'Trujillo', 76),
(1044, 'Vijes', 76),
(1045, 'Tuluá', 76),
(1046, 'Florida', 76),
(1047, 'Jamundí', 76),
(1048, 'Buenaventura', 76),
(1049, 'Arauquita', 81),
(1050, 'Cravo Norte', 81),
(1051, 'Fortul', 81),
(1052, 'Puerto Rondón', 81),
(1053, 'Saravena', 81),
(1054, 'Tame', 81),
(1055, 'Arauca', 81),
(1056, 'Yopal', 85),
(1057, 'Aguazul', 85),
(1058, 'Chámeza', 85),
(1059, 'Hato Corozal', 85),
(1060, 'La Salina', 85),
(1061, 'Monterrey', 85),
(1062, 'Pore', 85),
(1063, 'Recetor', 85),
(1064, 'Sabanalarga', 85),
(1065, 'Sácama', 85),
(1066, 'Tauramena', 85),
(1067, 'Trinidad', 85),
(1068, 'Villanueva', 85),
(1069, 'San Luis de Gaceno', 85),
(1070, 'Paz de Ariporo', 85),
(1071, 'Nunchía', 85),
(1072, 'Maní', 85),
(1073, 'Támara', 85),
(1074, 'Orocué', 85),
(1075, 'Mocoa', 86),
(1076, 'Colón', 86),
(1077, 'Orito', 86),
(1078, 'Puerto Caicedo', 86),
(1079, 'Puerto Guzmán', 86),
(1080, 'Leguízamo', 86),
(1081, 'Sibundoy', 86),
(1082, 'San Francisco', 86),
(1083, 'San Miguel', 86),
(1084, 'Santiago', 86),
(1085, 'Valle de Guamez', 86),
(1086, 'Puerto Asís', 86),
(1087, 'Villagarzón', 86),
(1088, 'Providencia', 88),
(1089, 'San Andrés', 88),
(1090, 'Leticia', 91),
(1091, 'El Encanto', 91),
(1092, 'La Chorrera', 91),
(1093, 'La Pedrera', 91),
(1094, 'La Victoria', 91),
(1095, 'Puerto Arica', 91),
(1096, 'Puerto Nariño', 91),
(1097, 'Puerto Santander', 91),
(1098, 'Tarapacá', 91),
(1099, 'Puerto Alegría', 91),
(1100, 'Miriti Paraná', 91),
(1101, 'Inírida', 94),
(1102, 'Barranco Minas', 94),
(1103, 'Mapiripana', 94),
(1104, 'San Felipe', 94),
(1105, 'Puerto Colombia', 94),
(1106, 'La Guadalupe', 94),
(1107, 'Cacahual', 94),
(1108, 'Pana Pana', 94),
(1109, 'Morichal', 94),
(1110, 'Calamar', 95),
(1111, 'San José del Guaviare', 95),
(1112, 'Miraflores', 95),
(1113, 'El Retorno', 95),
(1114, 'Mitú', 97),
(1115, 'Caruru', 97),
(1116, 'Pacoa', 97),
(1117, 'Taraira', 97),
(1118, 'Papunaua', 97),
(1119, 'Yavaraté', 97),
(1120, 'Puerto Carreño', 99),
(1121, 'La Primavera', 99),
(1122, 'Santa Rosalía', 99),
(1123, 'Cumaribo', 99),
(1124, 'N/A', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones`
--

DROP TABLE IF EXISTS `observaciones`;
CREATE TABLE IF NOT EXISTS `observaciones` (
  `IdObservacion` int(11) NOT NULL AUTO_INCREMENT,
  `IdEstado` int(11) NOT NULL,
  `observacion` varchar(21844) NOT NULL,
  `fechaRegistro` varchar(20) NOT NULL,
  `numRadicado` varchar(200) NOT NULL,
  `Respuesta` varchar(26000) DEFAULT NULL,
  `fechaRespuesta` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`IdObservacion`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

DROP TABLE IF EXISTS `paises`;
CREATE TABLE IF NOT EXISTS `paises` (
  `IdPais` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`IdPais`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`IdPais`, `Nombre`) VALUES
(1, 'Afganistán'),
(2, 'Albania'),
(3, 'Alemania'),
(4, 'Andorra'),
(5, 'Angola'),
(6, 'Antigua y Barbuda'),
(7, 'Arabia Saudita'),
(8, 'Argelia'),
(9, 'Argentina'),
(10, 'Armenia'),
(11, 'Australia'),
(12, 'Austria'),
(13, 'Azerbaiyán'),
(14, 'Bahamas'),
(15, 'Bangladés'),
(16, 'Barbados'),
(17, 'Baréin'),
(18, 'Bélgica'),
(19, 'Belice'),
(20, 'Benín'),
(21, 'Bielorrusia'),
(22, 'Birmania'),
(23, 'Bolivia'),
(24, 'Bosnia y Herzegovina'),
(25, 'Botsuana'),
(26, 'Brasil'),
(27, 'Brunéi'),
(28, 'Bulgaria'),
(29, 'Burkina Faso'),
(30, 'Burundi'),
(31, 'Bután'),
(32, 'Cabo Verde'),
(33, 'Camboya'),
(34, 'Camerún'),
(35, 'Canadá'),
(36, 'Catar'),
(37, 'Chad'),
(38, 'Chile'),
(39, 'China'),
(40, 'Chipre'),
(41, 'Ciudad del Vaticano'),
(42, 'Colombia'),
(43, 'Comoras'),
(44, 'Corea del Norte'),
(45, 'Corea del Sur'),
(46, 'Costa de Marfil'),
(47, 'Costa Rica'),
(48, 'Croacia'),
(49, 'Cuba'),
(50, 'Dinamarca'),
(51, 'Dominica'),
(52, 'Ecuador'),
(53, 'Egipto'),
(54, 'El Salvador'),
(55, 'Emiratos Árabes Unidos'),
(56, 'Eritrea'),
(57, 'Eslovaquia'),
(58, 'Eslovenia'),
(59, 'España'),
(60, 'Estados Unidos'),
(61, 'Estonia'),
(62, 'Etiopía'),
(63, 'Filipinas'),
(64, 'Finlandia'),
(65, 'Fiyi'),
(66, 'Francia'),
(67, 'Gabón'),
(68, 'Gambia'),
(69, 'Georgia'),
(70, 'Ghana'),
(71, 'Granada'),
(72, 'Grecia'),
(73, 'Guatemala'),
(74, 'Guyana'),
(75, 'Guinea'),
(76, 'Guinea ecuatorial'),
(77, 'Guinea-Bisáu'),
(78, 'Haití'),
(79, 'Honduras'),
(80, 'Hungría'),
(81, 'India'),
(82, 'Indonesia'),
(83, 'Irak'),
(84, 'Irán'),
(85, 'Irlanda'),
(86, 'Islandia'),
(87, 'Islas Marshall'),
(88, 'Islas Salomón'),
(89, 'Israel'),
(90, 'Italia'),
(91, 'Jamaica'),
(92, 'Japón'),
(93, 'Jordania'),
(94, 'Kazajistán'),
(95, 'Kenia'),
(96, 'Kirguistán'),
(97, 'Kiribati'),
(98, 'Kuwait'),
(99, 'Laos'),
(100, 'Lesoto'),
(101, 'Letonia'),
(102, 'Líbano'),
(103, 'Liberia'),
(104, 'Libia'),
(105, 'Liechtenstein'),
(106, 'Lituania'),
(107, 'Luxemburgo'),
(108, 'Macedonia del Norte'),
(109, 'Madagascar'),
(110, 'Malasia'),
(111, 'Malaui'),
(112, 'Maldivas'),
(113, 'Malí'),
(114, 'Malta'),
(115, 'Marruecos'),
(116, 'Mauricio'),
(117, 'Mauritania'),
(118, 'México'),
(119, 'Micronesia'),
(120, 'Moldavia'),
(121, 'Mónaco'),
(122, 'Mongolia'),
(123, 'Montenegro'),
(124, 'Mozambique'),
(125, 'Namibia'),
(126, 'Nauru'),
(127, 'Nepal'),
(128, 'Nicaragua'),
(129, 'Níger'),
(130, 'Nigeria'),
(131, 'Noruega'),
(132, 'Nueva Zelanda'),
(133, 'Omán'),
(134, 'Países Bajos'),
(135, 'Pakistán'),
(136, 'Palaos'),
(137, 'Panamá'),
(138, 'Papúa Nueva Guinea'),
(139, 'Paraguay'),
(140, 'Perú'),
(141, 'Polonia'),
(142, 'Portugal'),
(143, 'Reino Unido'),
(144, 'República Centroafricana'),
(145, 'República Checa'),
(146, 'República del Congo'),
(147, 'República Democrática del Congo'),
(148, 'República Dominicana'),
(149, 'República Sudafricana'),
(150, 'Ruanda'),
(151, 'Rumanía'),
(152, 'Rusia'),
(153, 'Samoa'),
(154, 'San Cristóbal y Nieves'),
(155, 'San Marino'),
(156, 'San Vicente y las Granadinas'),
(157, 'Santa Lucía'),
(158, 'Santo Tomé y Príncipe'),
(159, 'Senegal'),
(160, 'Serbia'),
(161, 'Seychelles'),
(162, 'Sierra Leona'),
(163, 'Singapur'),
(164, 'Siria'),
(165, 'Somalia'),
(166, 'Sri Lanka'),
(167, 'Suazilandia'),
(168, 'Sudán'),
(169, 'Sudán del Sur'),
(170, 'Suecia'),
(171, 'Suiza'),
(172, 'Surinam'),
(173, 'Tailandia'),
(174, 'Tanzania'),
(175, 'Tayikistán'),
(176, 'Timor Oriental'),
(177, 'Togo'),
(178, 'Tonga'),
(179, 'Trinidad y Tobago'),
(180, 'Túnez'),
(181, 'Turkmenistán'),
(182, 'Turquía'),
(183, 'Tuvalu'),
(184, 'Ucrania'),
(185, 'Uganda'),
(186, 'Uruguay'),
(187, 'Uzbekistán'),
(188, 'Vanuatu'),
(189, 'Venezuela'),
(190, 'Vietnam'),
(191, 'Yemen'),
(192, 'Yibuti'),
(193, 'Zambia'),
(194, 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones`
--

DROP TABLE IF EXISTS `peticiones`;
CREATE TABLE IF NOT EXISTS `peticiones` (
  `IdPeticion` int(11) NOT NULL AUTO_INCREMENT,
  `numRadicado` varchar(21844) DEFAULT NULL,
  `clave` varchar(5) NOT NULL,
  `IdEstadoPeticion` int(11) NOT NULL,
  `FechaCreacion` datetime NOT NULL,
  `IdTipoPeticion` int(11) NOT NULL,
  `IdTipoPersona` int(11) NOT NULL,
  `nombreRemitente` varchar(100) DEFAULT NULL,
  `apellidosRemitente` varchar(100) DEFAULT NULL,
  `razonSocial` varchar(100) DEFAULT NULL,
  `idTipoEmpresa` int(11) DEFAULT NULL,
  `IdPais` int(11) NOT NULL,
  `IdDepartamento` int(11) DEFAULT NULL,
  `IdMunicipio` int(11) DEFAULT NULL,
  `Direccion` varchar(100) NOT NULL,
  `Telefono` varchar(100) NOT NULL,
  `Movil` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `IdTipoPoblacion` int(11) NOT NULL,
  `temaPeticion` varchar(200) NOT NULL,
  `Mensaje` varchar(2000) NOT NULL,
  `IdRespuesta` int(11) DEFAULT NULL,
  `numRespuesta` varchar(100) DEFAULT NULL,
  `IdUsuarioAsignado` int(11) NOT NULL,
  `FechaAprobacion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`IdPeticion`),
  KEY `IdEstadoPeticion` (`IdEstadoPeticion`),
  KEY `IdTipoPeticion` (`IdTipoPeticion`),
  KEY `IdTipoPersona` (`IdTipoPersona`),
  KEY `idTipoEmpresa` (`idTipoEmpresa`),
  KEY `IdPais` (`IdPais`),
  KEY `IdDepartamento` (`IdDepartamento`),
  KEY `IdMunicipio` (`IdMunicipio`),
  KEY `IdTipoPoblacion` (`IdTipoPoblacion`),
  KEY `IdUsuarioAsignado` (`IdUsuarioAsignado`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `peticiones`
--

INSERT INTO `peticiones` (`IdPeticion`, `numRadicado`, `clave`, `IdEstadoPeticion`, `FechaCreacion`, `IdTipoPeticion`, `IdTipoPersona`, `nombreRemitente`, `apellidosRemitente`, `razonSocial`, `idTipoEmpresa`, `IdPais`, `IdDepartamento`, `IdMunicipio`, `Direccion`, `Telefono`, `Movil`, `Correo`, `IdTipoPoblacion`, `temaPeticion`, `Mensaje`, `IdRespuesta`, `numRespuesta`, `IdUsuarioAsignado`, `FechaAprobacion`) VALUES
(41, 'CR2022062241', 'x6pzf', 1, '2022-06-22 02:21:20', 9, 1, 'NicolÃ¡s', 'GutiÃ©rrez BohÃ³rquez', '0', 24, 42, 11, 149, 'Carrera 83a #65-61', '4849551', '3102526107', 'ngutierrez@cuentadealtocosto.org', 1, 'CreaciÃ³n de mensaje', 'CreaciÃ³n de mensaje', NULL, NULL, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rechazos`
--

DROP TABLE IF EXISTS `rechazos`;
CREATE TABLE IF NOT EXISTS `rechazos` (
  `IdRechazo` int(11) NOT NULL AUTO_INCREMENT,
  `IdPeticion` int(11) NOT NULL,
  `Motivo` varchar(500) NOT NULL,
  `Fecha` datetime NOT NULL,
  PRIMARY KEY (`IdRechazo`),
  KEY `IdPeticion` (`IdPeticion`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `smtp_options`
--

DROP TABLE IF EXISTS `smtp_options`;
CREATE TABLE IF NOT EXISTS `smtp_options` (
  `IdCorreo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `pass_smtp` varchar(50) NOT NULL,
  PRIMARY KEY (`IdCorreo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `smtp_options`
--

INSERT INTO `smtp_options` (`IdCorreo`, `nombre`, `correo`, `pass_smtp`) VALUES
(1, 'Notificaciones CAC', 'info@cuentadealtocosto.org', 'jcvxrwvsldpmczhd'),
(2, 'Dirección', 'direccion@cuentadealtocosto.org', 'phvrkvprqpcxhvrt'),
(3, 'Dirección solicitudes', 'direccion.solicitudes@cuentadealtocosto.org', 'cnfqclzrlxpgjwhp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `IdPeticion` int(11) NOT NULL AUTO_INCREMENT,
  `test` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`IdPeticion`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `test`
--

INSERT INTO `test` (`IdPeticion`, `test`) VALUES
(13, 'NicolÃ¡s');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocomunicado`
--

DROP TABLE IF EXISTS `tipocomunicado`;
CREATE TABLE IF NOT EXISTS `tipocomunicado` (
  `IdTipoComunicado` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`IdTipoComunicado`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipocomunicado`
--

INSERT INTO `tipocomunicado` (`IdTipoComunicado`, `Descripcion`) VALUES
(1, 'Envío de información'),
(2, 'Invitación'),
(3, 'Respuesta'),
(4, 'Solicitud'),
(5, 'Tramite interno CAC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

DROP TABLE IF EXISTS `tipodocumento`;
CREATE TABLE IF NOT EXISTS `tipodocumento` (
  `IdTipoDocumento` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) NOT NULL,
  `IdTipoPersona` int(11) NOT NULL,
  PRIMARY KEY (`IdTipoDocumento`),
  KEY `IdTipoPersona` (`IdTipoPersona`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`IdTipoDocumento`, `Descripcion`, `IdTipoPersona`) VALUES
(1, 'Cédula de ciudadanía', 1),
(2, 'Cédula de extranjería', 1),
(3, 'Tarjeta de identidad', 1),
(4, 'NIT', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoempresa`
--

DROP TABLE IF EXISTS `tipoempresa`;
CREATE TABLE IF NOT EXISTS `tipoempresa` (
  `IdTipoEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`IdTipoEmpresa`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipoempresa`
--

INSERT INTO `tipoempresa` (`IdTipoEmpresa`, `Descripcion`) VALUES
(1, 'Agremiaciones'),
(24, 'Ninguna'),
(6, 'Asociaciones de usuarios y Veedurías'),
(7, 'Agropecuario'),
(8, 'Ambiental'),
(9, 'Comercio Internacional'),
(10, 'Comercio Nacional'),
(11, 'Construcción'),
(12, 'Cultura'),
(13, 'Educación'),
(14, 'Gobierno'),
(15, 'Industria'),
(16, 'Laboral'),
(17, 'Minas y Energía'),
(18, 'Organizaciones No Gubernamentales'),
(19, 'Salud y Protección Social'),
(20, 'Seguridad y Defensa'),
(21, 'Tecnología e Innovación'),
(22, 'Transporte'),
(23, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopersona`
--

DROP TABLE IF EXISTS `tipopersona`;
CREATE TABLE IF NOT EXISTS `tipopersona` (
  `IdTipoPersona` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`IdTipoPersona`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipopersona`
--

INSERT INTO `tipopersona` (`IdTipoPersona`, `Descripcion`) VALUES
(1, 'Persona Natural'),
(2, 'Persona Jurídica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopeticion`
--

DROP TABLE IF EXISTS `tipopeticion`;
CREATE TABLE IF NOT EXISTS `tipopeticion` (
  `IdTipoPeticion` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`IdTipoPeticion`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipopeticion`
--

INSERT INTO `tipopeticion` (`IdTipoPeticion`, `Descripcion`) VALUES
(1, 'Derecho de petición de carácter general'),
(2, 'Derecho de petición de carácter particular'),
(3, 'Solicitud de información'),
(4, 'Consulta'),
(5, 'Queja'),
(6, 'Reclamo'),
(7, 'Sugerencia'),
(8, 'Denuncia'),
(9, 'Correspondencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopoblacion`
--

DROP TABLE IF EXISTS `tipopoblacion`;
CREATE TABLE IF NOT EXISTS `tipopoblacion` (
  `IdTipoPoblacion` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`IdTipoPoblacion`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipopoblacion`
--

INSERT INTO `tipopoblacion` (`IdTipoPoblacion`, `Descripcion`) VALUES
(1, 'Aseguradores en salud'),
(19, 'Sociedad científica '),
(18, 'Institución académica'),
(17, 'Paciente'),
(16, 'Entidad pública en salud'),
(15, 'Entidad pública'),
(14, 'Entidad de control'),
(20, 'Investigador independiente'),
(21, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE IF NOT EXISTS `tipousuario` (
  `IdTipoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`IdTipoUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`IdTipoUsuario`, `Descripcion`) VALUES
(1, 'Super Admin'),
(2, 'Direccion'),
(3, 'Coordinador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `IdEstado` int(11) NOT NULL,
  `Nombres` varchar(100) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `numIdent` varchar(20) NOT NULL,
  `Cargo` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `IdTipoUsuario` int(11) NOT NULL,
  `IdCoordinacion` int(11) NOT NULL,
  `Pass` varchar(250) NOT NULL,
  PRIMARY KEY (`IdUsuario`),
  UNIQUE KEY `numIdent` (`numIdent`),
  KEY `IdTipoUsuario` (`IdTipoUsuario`),
  KEY `IdCoordinacion` (`IdCoordinacion`),
  KEY `IdEstado` (`IdEstado`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `IdEstado`, `Nombres`, `Apellidos`, `numIdent`, `Cargo`, `Correo`, `IdTipoUsuario`, `IdCoordinacion`, `Pass`) VALUES
(1, 1, 'Nicolás', 'Gutiérrez', '1010057528', 'Analista de Software', 'ngutierrez@cuentadealtocosto.org', 2, 2, '1010057528'),
(2, 1, 'Admin', 'User', '1012418977', 'Administrador', 'administrativa@cuentadealtocosto.org', 1, 1, '1012418977'),
(6, 1, 'Luisa', 'Giraldo', '53135916', 'Lider de Calidad', 'lgiraldo@cuentadealtocosto.org', 2, 1, '53135916'),
(5, 1, 'Liliana', 'Barbosa', '52073597', 'Coordinadora administrativa', 'lbarbosa@cuentadealtocosto.org', 3, 2, '52073597'),
(7, 1, 'Marí­a Helena', 'Barrera', '1023911799', 'Auxiliar administrativa', 'mbarrera@cuentadealtocosto.org', 3, 1, '1023911799'),
(8, 1, 'Angie', 'Bermudez', '1019128032', 'Analista administrativa y financiera', 'abermudez@cuentadealtocosto.org', 3, 2, '1019128032');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

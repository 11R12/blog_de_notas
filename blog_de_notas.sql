-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         8.4.5 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para blog_notas
CREATE DATABASE IF NOT EXISTS `blog_notas` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `blog_notas`;

-- Volcando estructura para tabla blog_notas.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `usuario_uuid` binary(16) NOT NULL,
  `nombre_categoria` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `usuario_categoria_unico` (`usuario_uuid`,`nombre_categoria`) USING BTREE,
  CONSTRAINT `fk_categoria_usuario` FOREIGN KEY (`usuario_uuid`) REFERENCES `usuarios` (`uuid`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla blog_notas.categorias: ~2 rows (aproximadamente)
INSERT INTO `categorias` (`id`, `usuario_uuid`, `nombre_categoria`) VALUES
	(10, _binary 0x41c52683711d43c49669b6b299acccd8, 'Aqui tambien hay notas, mira...'),
	(8, _binary 0x41c52683711d43c49669b6b299acccd8, 'Notas Expontaneas');

-- Volcando estructura para tabla blog_notas.notas
CREATE TABLE IF NOT EXISTS `notas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` binary(16) NOT NULL,
  `usuario_uuid` binary(16) NOT NULL,
  `categoria_id` int unsigned NOT NULL DEFAULT '16',
  `titulo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `contenido` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `fecha_creacion` timestamp NULL DEFAULT (now()),
  `fecha_actualizacion` timestamp NULL DEFAULT (now()) ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uuid` (`uuid`) USING BTREE,
  KEY `usuario_uuid` (`usuario_uuid`) USING BTREE,
  KEY `categoria_id` (`categoria_id`) USING BTREE,
  CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`usuario_uuid`) REFERENCES `usuarios` (`uuid`) ON DELETE CASCADE,
  CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla blog_notas.notas: ~13 rows (aproximadamente)
INSERT INTO `notas` (`id`, `uuid`, `usuario_uuid`, `categoria_id`, `titulo`, `contenido`, `fecha_creacion`, `fecha_actualizacion`) VALUES
	(6, _binary 0xf21722e25ad7400fb3c83cedca84edee, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:02', '2026-01-05 13:39:02'),
	(7, _binary 0x28b17879d53948dd92220e40dc16e911, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:14', '2026-01-05 13:39:14'),
	(8, _binary 0xebc3d90f026045f09322c0ae9600e23f, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:15', '2026-01-05 13:39:15'),
	(9, _binary 0xfa1f5aba1b9a4e34ba752e48b18145c2, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:15', '2026-01-05 13:39:15'),
	(10, _binary 0xafc4a8332d6f4cc08307df055b6d9408, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:15', '2026-01-05 13:39:15'),
	(11, _binary 0x8047c7a33844453c82c2de3d1c42ff1d, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:15', '2026-01-05 13:39:15'),
	(12, _binary 0x48afecba655b4ad9b21eb91ded97f70e, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:16', '2026-01-05 13:39:16'),
	(13, _binary 0x40090fb775bd459db527f9f1b8c01fcb, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:16', '2026-01-05 13:39:16'),
	(14, _binary 0xb4ab53ff0d3e4dcbaccb82e95973b16f, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:16', '2026-01-05 13:39:16'),
	(15, _binary 0xa37785cdb08b481e87ba5b920b03943a, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:39:16', '2026-01-05 13:39:16'),
	(16, _binary 0x1405e9bef78d4bc58ff14572dcd81cd2, _binary 0x41c52683711d43c49669b6b299acccd8, 8, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:45:53', '2026-01-05 13:45:53'),
	(17, _binary 0x997339b4f14c4b8cbd12eb2556edf292, _binary 0x41c52683711d43c49669b6b299acccd8, 10, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:46:04', '2026-01-05 13:46:04'),
	(18, _binary 0x733ca0fb13f545bfb7840cb248fcadb1, _binary 0x41c52683711d43c49669b6b299acccd8, 10, 'Nota categoria 4', 'Contenido de la nota de Prueba', '2026-01-05 13:46:04', '2026-01-05 13:46:04');

-- Volcando estructura para tabla blog_notas.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` binary(16) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `numero_telefono` varchar(20) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ultimo_ingreso` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uuid_idx` (`uuid`) USING BTREE,
  UNIQUE KEY `correo_idx` (`correo`) USING BTREE,
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla blog_notas.usuarios: ~1 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `uuid`, `correo`, `password`, `nombre`, `numero_telefono`, `fecha_creacion`, `ultimo_ingreso`) VALUES
	(1, _binary 0x41c52683711d43c49669b6b299acccd8, 'melendezGmail.com', 'c4a861f460ed9ea69ce817630aa09be4', 'Alexander', '123123213', '2026-01-05 11:36:49', '2026-01-05 12:00:00');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

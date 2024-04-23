-- --------------------------------------------------------
-- Host:                         localhost
-- VersiÃ³n del servidor:         10.4.28-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL VersiÃ³n:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para dbeu1
CREATE DATABASE IF NOT EXISTS `dbeu2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `dbeu2`;

-- Volcando estructura para tabla dbeu1.tbescuela
CREATE TABLE IF NOT EXISTS `tbescuela` (
  `id_escuela` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_escual` varchar(200) NOT NULL,
  PRIMARY KEY (`id_escuela`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla dbeu1.tbescuela: ~4 rows (aproximadamente)
INSERT INTO `tbescuela` (`id_escuela`, `nombre_escual`) VALUES
	(1, 'Ing. de Sitemas'),
	(2, 'Ing. Financiera'),
	(3, 'Ing. Comercial'),
	(4, 'Ing. Industrial');

-- Volcando estructura para tabla dbeu1.tbestudiante
CREATE TABLE IF NOT EXISTS `tbestudiante` (
  `id_estudiante` int(11) NOT NULL AUTO_INCREMENT,
  `registro_estudiante` int(8) NOT NULL,
  `nombre_estudiante` varchar(150) NOT NULL,
  `apellido_estudiante` varchar(150) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `id_escuela` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`),
  KEY `id_escuela` (`id_escuela`),
  CONSTRAINT `tbestudiante_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `tbescuela` (`id_escuela`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla dbeu1.tbestudiante: ~5 rows (aproximadamente)
INSERT INTO `tbestudiante` (`id_estudiante`, `registro_estudiante`, `nombre_estudiante`, `apellido_estudiante`, `fecha_nacimiento`, `id_escuela`) VALUES
	(1, 12345678, 'Ivan', 'Malaga Espinoza', '2010-01-01', 1),
	(2, 98765432, 'Jesus', 'Agreda', '2003-07-06', 1),
	(3, 88888888, 'Gabo', 'Melendez', '2024-04-02', 1),
	(4, 11111111, 'Ximena', 'Ortiz', '2008-01-01', 1),
	(5, 66666666, 'Roberto', 'Huaman', '2018-02-14', 1);

-- Volcando estructura para tabla dbeu1.tbmateria
CREATE TABLE IF NOT EXISTS `tbmateria` (
  `codigo_materia` varchar(50) NOT NULL,
  `nombre_materia` varchar(150) NOT NULL,
  `creditos` int(11) NOT NULL,
  `id_escuela` int(11) DEFAULT NULL,
  PRIMARY KEY (`codigo_materia`),
  KEY `id_escuela` (`id_escuela`),
  CONSTRAINT `id_escuela` FOREIGN KEY (`id_escuela`) REFERENCES `tbescuela` (`id_escuela`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla dbeu1.tbmateria: ~5 rows (aproximadamente)
INSERT INTO `tbmateria` (`codigo_materia`, `nombre_materia`, `creditos`, `id_escuela`) VALUES
	('ejemplo', 'ejemplo', 6, NULL),
	('SI-12', 'Base de datos 2', 4, 1),
	('SI-22', 'Programacion 2', 4, 1),
	('SI-32', 'Analisis de suelos', 3, 4),
	('SI-42', 'Ecommerce', 3, 1);

-- Volcando estructura para tabla dbeu1.tbtrabajos
CREATE TABLE IF NOT EXISTS `tbtrabajos` (
  `id_trabajos` int(11) NOT NULL AUTO_INCREMENT,
  `ponderacion` int(11) NOT NULL,
  `nota_trabajo` int(10) unsigned zerofill DEFAULT NULL,
  `id_unidad` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_trabajos`),
  KEY `id_unidad` (`id_unidad`),
  CONSTRAINT `tbtrabajos_ibfk_1` FOREIGN KEY (`id_unidad`) REFERENCES `tbunidad` (`id_unidad`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla dbeu1.tbtrabajos: ~10 rows (aproximadamente)
INSERT INTO `tbtrabajos` (`id_trabajos`, `ponderacion`, `nota_trabajo`, `id_unidad`) VALUES
	(1, 30, 0000000005, 1),
	(2, 20, 0000000015, NULL),
	(3, 20, 0000000015, 4),
	(5, 30, 0000000015, 4),
	(6, 50, 0000000010, 4),
	(7, 20, 0000000015, 5),
	(8, 30, 0000000014, 5),
	(9, 50, 0000000020, 5),
	(10, 10, 0000000020, 1),
	(11, 50, 0000000009, 1);

-- Volcando estructura para tabla dbeu1.tbunidad
CREATE TABLE IF NOT EXISTS `tbunidad` (
  `id_unidad` int(11) NOT NULL AUTO_INCREMENT,
  `numero_unidad` int(11) NOT NULL,
  `nota_unidad` int(10) unsigned zerofill DEFAULT NULL,
  `id_estudiante` int(11) DEFAULT NULL,
  `codigo_materia` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_unidad`),
  KEY `id_estudiante` (`id_estudiante`),
  KEY `codigo_materia` (`codigo_materia`),
  CONSTRAINT `tbunidad_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `tbestudiante` (`id_estudiante`),
  CONSTRAINT `tbunidad_ibfk_2` FOREIGN KEY (`codigo_materia`) REFERENCES `tbmateria` (`codigo_materia`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla dbeu1.tbunidad: ~9 rows (aproximadamente)
INSERT INTO `tbunidad` (`id_unidad`, `numero_unidad`, `nota_unidad`, `id_estudiante`, `codigo_materia`) VALUES
	(1, 1, 0000000009, 4, 'SI-22'),
	(2, 2, NULL, 4, 'SI-22'),
	(3, 3, NULL, 4, 'SI-22'),
	(4, 1, NULL, 5, 'SI-12'),
	(5, 2, NULL, 5, 'SI-12'),
	(6, 3, NULL, 5, 'SI-12'),
	(7, 1, NULL, 5, 'SI-22'),
	(8, 2, NULL, 5, 'SI-22'),
	(9, 3, NULL, 5, 'SI-22');


DELIMITER //

CREATE TRIGGER actualizar_nota_unidad_after_insert
AFTER INSERT ON tbtrabajos
FOR EACH ROW
BEGIN
    DECLARE total_ponderacion_trabajos DECIMAL(10,2);
    DECLARE nota_unidad_actual DECIMAL(10,2);

    -- Obtener la suma total de la ponderaciÃ³n de los trabajos de la unidad
    SELECT SUM(ponderacion) INTO total_ponderacion_trabajos
    FROM tbtrabajos
    WHERE id_unidad = NEW.id_unidad;

    -- Calcular la nota de la unidad considerando la ponderaciÃ³n de los trabajos
    SET nota_unidad_actual = (SELECT SUM((ponderacion / total_ponderacion_trabajos) * nota_trabajo) FROM tbtrabajos WHERE id_unidad = NEW.id_unidad);

    -- Actualizar la nota de la unidad en la tabla tbunidad
    UPDATE tbunidad
    SET nota_unidad = nota_unidad_actual
    WHERE id_unidad = NEW.id_unidad;
END;
//

CREATE TRIGGER actualizar_nota_unidad_after_delete
AFTER DELETE ON tbtrabajos
FOR EACH ROW
BEGIN
    DECLARE total_ponderacion_trabajos DECIMAL(10,2);
    DECLARE nota_unidad_actual DECIMAL(10,2);

    -- Obtener la suma total de la ponderaciÃ³n de los trabajos de la unidad
    SELECT SUM(ponderacion) INTO total_ponderacion_trabajos
    FROM tbtrabajos
    WHERE id_unidad = OLD.id_unidad;

    -- Calcular la nota de la unidad considerando la ponderaciÃ³n de los trabajos
    IF total_ponderacion_trabajos > 0 THEN
        SET nota_unidad_actual = (SELECT SUM((ponderacion / total_ponderacion_trabajos) * nota_trabajo) FROM tbtrabajos WHERE id_unidad = OLD.id_unidad);
    ELSE
        SET nota_unidad_actual = 0;
    END IF;

    -- Actualizar la nota de la unidad en la tabla tbunidad
    UPDATE tbunidad
    SET nota_unidad = nota_unidad_actual
    WHERE id_unidad = OLD.id_unidad;
END;
//

CREATE TRIGGER actualizar_nota_unidad_after_update
AFTER UPDATE ON tbtrabajos
FOR EACH ROW
BEGIN
    DECLARE total_ponderacion_trabajos DECIMAL(10,2);
    DECLARE nota_unidad_actual DECIMAL(10,2);

    -- Obtener la suma total de la ponderaciÃ³n de los trabajos de la unidad
    SELECT SUM(ponderacion) INTO total_ponderacion_trabajos
    FROM tbtrabajos
    WHERE id_unidad = NEW.id_unidad;

    -- Calcular la nota de la unidad considerando la ponderaciÃ³n de los trabajos
    SET nota_unidad_actual = (SELECT SUM((ponderacion / total_ponderacion_trabajos) * nota_trabajo) FROM tbtrabajos WHERE id_unidad = NEW.id_unidad);

    -- Actualizar la nota de la unidad en la tabla tbunidad
    UPDATE tbunidad
    SET nota_unidad = nota_unidad_actual
    WHERE id_unidad = NEW.id_unidad;
END;
//

DELIMITER ;
/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

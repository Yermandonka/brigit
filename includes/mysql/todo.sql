CREATE DATABASE IF NOT EXISTS `brigit` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

DROP USER IF EXISTS 'brigit'@'%';
CREATE USER 'brigit'@'%' IDENTIFIED BY 'brigit';
GRANT ALL PRIVILEGES ON `brigit`.* TO 'brigit'@'%';

DROP USER IF EXISTS 'brigit'@'localhost';
CREATE USER 'brigit'@'localhost' IDENTIFIED BY 'brigit';
GRANT ALL PRIVILEGES ON `brigit`.* TO 'brigit'@'localhost';

/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
USE brigit;
DROP TABLE IF EXISTS `RolesUsuario`;
DROP TABLE IF EXISTS `Roles`;
DROP TABLE IF EXISTS `Usuarios`;
DROP TABLE IF EXISTS `Palabras`;

CREATE TABLE IF NOT EXISTS `Roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `RolesUsuario` (
  `usuario` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  PRIMARY KEY (`usuario`, `rol`),
  KEY `rol` (`rol`),
  CONSTRAINT `fk_rolesusuario_usuario`
    FOREIGN KEY (`usuario`) REFERENCES `Usuarios`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreUsuario` varchar(30) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `password` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Palabras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `palabra` varchar(30) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `significado` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `creador` varchar(30) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `votos` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_palabras_creador`
    FOREIGN KEY (`creador`) REFERENCES `Usuarios`(`nombreUsuario`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER $$

CREATE TRIGGER `RolesUsuario` 
AFTER INSERT ON `Usuarios`
FOR EACH ROW 
BEGIN
  INSERT INTO RolesUsuario (usuario, rol)
  VALUES (NEW.id, 2);
END $$

DELIMITER ;

/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
use brigit;
TRUNCATE TABLE `RolesUsuario`;
TRUNCATE TABLE `Roles`;
TRUNCATE TABLE `Usuarios`;

INSERT INTO `Roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(2, 'user');

/*
  user: userpass
  admin: adminpass
*/
INSERT INTO `Usuarios` (`id`, `nombreUsuario`, `password`) VALUES
(1, 'admin', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS'),
(2, 'user', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

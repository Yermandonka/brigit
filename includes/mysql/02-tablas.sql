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
    FOREIGN KEY (`creadorid`) REFERENCES `Usuarios`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

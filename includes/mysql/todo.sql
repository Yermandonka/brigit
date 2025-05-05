CREATE DATABASE IF NOT EXISTS `brigit` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

DROP USER IF EXISTS 'brigit'@'%';
CREATE USER 'brigit'@'%' IDENTIFIED BY 'brigit';
GRANT ALL PRIVILEGES ON `brigit`.* TO 'brigit'@'%';

DROP USER IF EXISTS 'brigit'@'localhost';
CREATE USER 'brigit'@'localhost' IDENTIFIED BY 'brigit';
GRANT ALL PRIVILEGES ON `brigit`.* TO 'brigit'@'localhost';

/*
  Remember to disable the option "Enable foreign key checks" to avoid issues when importing the script.
*/
USE brigit;
DROP TABLE IF EXISTS `UserRoles`;
DROP TABLE IF EXISTS `Roles`;
DROP TABLE IF EXISTS `Words`;
DROP TABLE IF EXISTS `Users`;

CREATE TABLE IF NOT EXISTS `Roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
  `name` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `password` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `UserRoles` (
  `user` int(11) NOT NULL UNIQUE,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`user`, `role`),
  KEY `role` (`role`),
  CONSTRAINT `fk_userroles_user`
    FOREIGN KEY (`user`) REFERENCES `Users`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(30) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `meaning` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `creator` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `votes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_words_creator`
    FOREIGN KEY (`creator`) REFERENCES `Users`(`username`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*
  Remember to disable the option "Enable foreign key checks" to avoid issues when importing the script.
*/
USE brigit;
TRUNCATE TABLE `UserRoles`;
TRUNCATE TABLE `Roles`;
TRUNCATE TABLE `Users`;

INSERT INTO `Roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

/*
  user: userpass
  admin: adminpass
*/
INSERT INTO `Users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$O3c1kBFa2yDK5F47IUqusOJmIANjHP6EiPyke5dD18ldJEow.e0eS'),
(2, 'user', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG');

INSERT INTO `UserRoles` (`user`, `role`) VALUES
(1, '1'),
(2, '2');
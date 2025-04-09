DROP USER IF EXISTS 'brigit'@'%';
CREATE USER 'brigit'@'%' IDENTIFIED BY 'brigit';
GRANT ALL PRIVILEGES ON `brigit`.* TO 'brigit'@'%';

DROP USER IF EXISTS 'brigit'@'localhost';
CREATE USER 'brigit'@'localhost' IDENTIFIED BY 'brigit';
GRANT ALL PRIVILEGES ON `brigit`.* TO 'brigit'@'localhost';
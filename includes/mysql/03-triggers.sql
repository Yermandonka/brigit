DELIMITER $$

CREATE TRIGGER `RolesUsuario` 
AFTER INSERT ON `Usuarios`
FOR EACH ROW 
BEGIN
  INSERT INTO RolesUsuario (usuario, rol)
  VALUES (NEW.id, 2);
END $$

DELIMITER ;
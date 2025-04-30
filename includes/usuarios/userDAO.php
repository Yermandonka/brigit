<?php
namespace codigo\brigit\includes\usuarios;
use codigo\brigit\includes\Aplicacion;
use codigo\brigit\includes\baseDAO;

class userDAO extends baseDAO implements IUser
{
    public function __construct()
    {

    }

    public function login($userDTO)
    {
        $foundedUserDTO = $this->buscaUsuario($userDTO->nombreUsuario());

        if ($foundedUserDTO && self::testHashPassword($userDTO->password(), $foundedUserDTO->password())) {
            return $foundedUserDTO;
        }

        return false;
    }

    private function buscaUsuario($username)
    {
        $escUserName = $this->realEscapeString($username);

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT id, username, password FROM Users U WHERE U.username = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $escUserName);

        $stmt->execute();

        $stmt->bind_result($id, $nombreUsuario, $password);

        if ($stmt->fetch()) {
            $user = new userDTO($id, $nombreUsuario, $password);

            $stmt->close();

            return $user;
        }

        return false;
    }

    public function create($userDTO)
    {
        $createdUserDTO = false;
        try {
            if ($this->buscaUsuario($userDTO->nombreUsuario())) {
                throw new userAlreadyExistException("Ya existe el usuario '{$userDTO->nombreUsuario()}'");
            }
            $escUserName = $this->realEscapeString($userDTO->nombreUsuario());

            $hashedPassword = self::hashPassword($userDTO->password());

            $conn = Aplicacion::getInstance()->getConexionBd();

            $query = "INSERT INTO Users(username, password) VALUES (?, ?)";

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ss", $escUserName, $hashedPassword);

            if ($stmt->execute()) {
                $user = $this->buscaUsuario($escUserName);
                $idUser = 0;
                if ($user->id() != false) {
                    $idUser = $this->buscaUsuario($escUserName)->id();
                }
                $roleId = 2;
                $queryRole = "INSERT INTO UserRoles(user, role) VALUES (?, ?)";
                $stmtRole = $conn->prepare($queryRole);
                $stmtRole->bind_param("ii", $idUser, $roleId);
                $stmtRole->execute();

                $createdUserDTO = new userDTO($idUser, $userDTO->nombreUsuario(), $userDTO->password());

                return $createdUserDTO;
            }
        } catch (\mysqli_sql_exception $e) {
            // código de violación de restricción de integridad (PK)

            if ($conn->sqlstate == 23000) {
                throw new userAlreadyExistException("Ya existe el usuario '{$userDTO->nombreUsuario()}'");
            }

            throw $e;
        }

        return $createdUserDTO;
    }

    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private static function testHashPassword($password, $hashedPassword)
    {
        var_dump($password);
        var_dump($hashedPassword);

        $result = password_verify($password, $hashedPassword);
        var_dump($result);
        return $result;
    }
}
?>
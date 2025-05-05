<?php
namespace codigo\brigit\includes\users;

class userDTO
{
    private $id;

    private $nombreUsuario;

    private $password;

    public function __construct($id, $nombreUsuario, $password)
    {
        $this->id = $id;
        $this->nombreUsuario = $nombreUsuario;
        $this->password = $password;
    }

    public function id()
    {
        return $this->id;
    }

    public function nombreUsuario()
    {
        return $this->nombreUsuario;
    }

    public function password()
    {
        return $this->password;
    }
}
?>
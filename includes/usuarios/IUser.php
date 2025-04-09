<?php
namespace codigo\brigit\includes\usuarios;
interface IUser
{
    public function login($userDTO);

    public function create($userDTO);

}
?>
<?php
namespace codigo\brigit\includes\users;
interface IUser
{
    public function login($userDTO);

    public function create($userDTO);

}
?>
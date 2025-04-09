<?php
namespace codigo\brigit\includes\usuarios;
class userMock implements IUser
{
    public function login($userDTO)
    {
        return true;
    }

    public function create($userDTO)
    {
        return true;
    }

}
?>
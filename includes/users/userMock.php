<?php
namespace codigo\brigit\includes\users;
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
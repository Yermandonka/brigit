<?php
namespace codigo\brigit\includes\usuarios;
use codigo\brigit\includes\usuarios\IUser;
use codigo\brigit\includes\usuarios\userDAO;
use codigo\brigit\includes\usuarios\userMock;

class userFactory
{
    public static function CreateUser() : IUser
    {
        $userDAO = false;

        if (true)
        {
            $userDAO = new userDAO();
        }
        /*else
        {
            $userDAO = new userMock();
        }*/
        
        return $userDAO;
    }
}

?>
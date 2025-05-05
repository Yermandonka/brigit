<?php
namespace codigo\brigit\includes\users;
use codigo\brigit\includes\users\IUser;
use codigo\brigit\includes\users\userDAO;
use codigo\brigit\includes\users\userMock;

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
<?php
namespace codigo\brigit\includes\meanings;
use codigo\brigit\includes\meanings\IMeaning;
use codigo\brigit\includes\meanings\meaningDAO;
use codigo\brigit\includes\meanings\meaningMock;

class meaningFactory
{
    public static function CreateMeaning() : IMeaning
    {
        $meaningDAO = false;

        if (true)
        {
            $meaningDAO = new meaningDAO();
        }
        /*else
        {
            $meaningDAO = new meaningMock();
        }*/
        
        return $meaningDAO;
    }
}

?>
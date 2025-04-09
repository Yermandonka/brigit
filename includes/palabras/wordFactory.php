<?php
namespace codigo\brigit\includes\palabras;
use codigo\brigit\includes\palabras\IWord;
use codigo\brigit\includes\palabras\wordDAO;
use codigo\brigit\includes\palabras\wordMock;

class wordFactory
{
    public static function CreateWord() : IWord
    {
        $wordDAO = false;

        if (true)
        {
            $wordDAO = new wordDAO();
        }
        /*else
        {
            $wordDAO = new wordMock();
        }*/
        
        return $wordDAO;
    }
}

?>
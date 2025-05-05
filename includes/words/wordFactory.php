<?php
namespace codigo\brigit\includes\words;
use codigo\brigit\includes\words\IWord;
use codigo\brigit\includes\words\wordDAO;
use codigo\brigit\includes\words\wordMock;

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
<?php
namespace codigo\brigit\includes\palabras;
use codigo\brigit\includes\palabras\wordFactory;

class wordAppService
{
    private static $instance;

    public static function GetSingleton()
    {
        if (!self::$instance instanceof self)
        {
            self::$instance = new self;
        }

        return self::$instance;
    }
  
    private function __construct()
    {
    } 

    public function create($wordDTO)
    {
        $IWordDAO = wordFactory::CreateWord();

        $createdWordDTO = $IWordDAO->create($wordDTO);

        return $createdWordDTO;
    }

    public function getAllWords()
    {
        $IWordDAO = wordFactory::CreateWord();

        $words = $IWordDAO->getAllWords();

        return $words;
    }

}

?>
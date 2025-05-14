<?php
namespace codigo\brigit\includes\words;
use codigo\brigit\includes\words\wordFactory;

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

    public function getAllWords($user)
    {
        $IWordDAO = wordFactory::CreateWord();

        $words = $IWordDAO->getAllWords($user);

        return $words;
    }

    public function getThisWord($word)
    {
        $IWordDAO = wordFactory::CreateWord();

        $words = $IWordDAO->getThisWord($word);

        return $words;
    }

    public function delete($word)
    {
        $IWordDAO = wordFactory::CreateWord();

        $IWordDAO->delete($word);
    }

}

?>
<?php
namespace codigo\brigit\includes\meanings;
use codigo\brigit\includes\meanings\meaningFactory;

class meaningAppService
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

    public function create($meaningDTO)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $createdMeaningDTO = $IMeaningDAO->create($meaningDTO);

        return $createdMeaningDTO;
    }

    public function getAllMeanings($word)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $meanings = $IMeaningDAO->getAllMeanings($word);

        return $meanings;
    }

    public function getAllVotes($word)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $meanings = $IMeaningDAO->getAllVotes($word);

        return $meanings;
    }

    public function addVote($word, $meaning)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $IMeaningDAO->addVote($word, $meaning);
    }

    public function removeVote($word, $meaning)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $IMeaningDAO->removeVote($word, $meaning);
    }

}

?>
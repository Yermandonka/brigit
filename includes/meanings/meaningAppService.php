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

    public function getThisMeaning($word, $meaning)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $meaningDTO = $IMeaningDAO->getThisMeaning($word, $meaning);

        return $meaningDTO;
    }

    public function getAllMeanings($word = null, $user = null)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $meanings = $IMeaningDAO->getAllMeanings($word, $user);

        return $meanings;
    }

    public function getAllVotes($word)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $meanings = $IMeaningDAO->getAllVotes($word);

        return $meanings;
    }
    public function getVotes($word, $meaning)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $votes = $IMeaningDAO->getVotes($word, $meaning);

        return $votes;
    }

    public function addVote($word, $meaning, $add)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $IMeaningDAO->addVote($word, $meaning, $add);
    }

    public function getMeaningId($word, $meaning)
    {
        $meaningDAO = meaningFactory::CreateMeaning();
        return $meaningDAO->getMeaningId($word, $meaning);
    }

    public function getAllWords($word, $user = null)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $meanings = $IMeaningDAO->getAllWords($word, $user);

        return $meanings;
    }

    public function delete($meaningDTO)
    {
        $IMeaningDAO = meaningFactory::CreateMeaning();

        $IMeaningDAO->delete($meaningDTO);
    }
}
?>
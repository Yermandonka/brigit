<?php
namespace codigo\brigit\includes\votes;
use codigo\brigit\includes\votes\voteFactory;

class voteAppService
{
    private static $instance;

    public static function GetSingleton()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
  
    private function __construct()
    {
    } 

    public function create($voteDTO)
    {
        $IVoteDAO = voteFactory::CreateVote();
        $createdVoteDTO = $IVoteDAO->create($voteDTO);
        return $createdVoteDTO;
    }

    public function getAllVotes($word)
    {
        $IVoteDAO = voteFactory::CreateVote();
        return $IVoteDAO->getAllVotes($word);
    }

    public function addVote($word, $vote)
    {
        $IVoteDAO = voteFactory::CreateVote();
        return $IVoteDAO->addVote($word, $vote);
    }

    public function removeVote($word, $vote)
    {
        $IVoteDAO = voteFactory::CreateVote();
        return $IVoteDAO->removeVote($word, $vote);
    }
}
?>
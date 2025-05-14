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

    public function create($voter, $meaning_id, $type)
    {
        $voteDTO = new voteDTO($voter, $meaning_id, $type);
        $voteDAO = voteFactory::CreateVote();
        return $voteDAO->create($voteDTO);
    }

    public function getUserVote($voter, $meaning_id)
    {
        $voteDAO = voteFactory::CreateVote();
        return $voteDAO->getUserVote($voter, $meaning_id);
    }

    public function updateVoteType($voter, $meaning_id, $type)
    {
        $voteDAO = voteFactory::CreateVote();
        return $voteDAO->updateVoteType($voter, $meaning_id, $type);
    }

    public function getAllVotes($user = null)
    {
        $voteDAO = voteFactory::CreateVote();
        return $voteDAO->getAllVotes($user);
    }
}
?>
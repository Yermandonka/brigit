<?php
namespace codigo\brigit\includes\votes;
interface IVote
{
    public function create($voteDTO);
    public function getUserVote($voter, $meaning_id);
    public function updateVoteType($voter, $meaning_id, $type);
    public function getAllVotes($user = null);
}
?>
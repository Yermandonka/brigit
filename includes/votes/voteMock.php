<?php
namespace codigo\brigit\includes\votes;
class voteMock implements IVote
{
    public function create($meaningDTO)
    {
        return true;
    }
    public function getUserVote($voter, $meaning_id)
    {
        return 'like'; // Simulando un voto de tipo 'like'
    }
    public function updateVoteType($voter, $meaning_id, $type)
    {
        return true; // Simulando una actualización exitosa
    }
}
?>
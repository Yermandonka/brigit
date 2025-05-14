<?php
namespace codigo\brigit\includes\meanings;
interface IMeaning
{
    public function create($wordDTO);
    public function delete($meaningDTO);
    public function getThisMeaning($word, $meaning);
    public function getAllMeanings($word, $user);
    public function getAllVotes($word);
    public function getVotes($word, $meaning);
    public function getMeaningId($word, $meaning);
    public function addVote($word, $meaning, $add);
    public function getAllWords($word);
}
?>
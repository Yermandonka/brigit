<?php
namespace codigo\brigit\includes\meanings;
interface IMeaning
{
    public function create($wordDTO);
    public function getAllMeanings($word);
    public function getAllVotes($word);
}
?>
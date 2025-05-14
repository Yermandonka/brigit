<?php
namespace codigo\brigit\includes\words;
interface IWord
{
    public function create($wordDTO);
    public function getAllWords($user);
    public function getThisWord($word);
    public function delete($word);
}
?>
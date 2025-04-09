<?php
namespace codigo\brigit\includes\palabras;
interface IWord
{
    public function create($wordDTO);
    public function getAllWords();
}
?>
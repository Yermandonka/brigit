<?php
namespace codigo\brigit\includes\words;
class wordMock implements IWord
{
    public function create($wordDTO)
    {
        return true;
    }

    public function getAllWords()
    {
        return [];
    }

    public function getThisWord($word)
    {
        return new wordDTO(1, $word, "creator");
    }
}
?>
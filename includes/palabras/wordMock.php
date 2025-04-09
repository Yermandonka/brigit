<?php
namespace codigo\brigit\includes\palabras;
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
}
?>
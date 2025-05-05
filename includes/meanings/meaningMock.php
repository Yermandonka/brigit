<?php
namespace codigo\brigit\includes\meanings;
class meaningMock implements IMeaning
{
    public function create($meaningDTO)
    {
        return true;
    }

    public function getAllMeanings($word)
    {
        return [];
    }
}
?>
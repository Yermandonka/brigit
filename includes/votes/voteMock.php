<?php
namespace codigo\brigit\includes\votes;
class voteMock implements IVote
{
    public function create($meaningDTO)
    {
        return true;
    }
}
?>
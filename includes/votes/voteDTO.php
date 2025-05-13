<?php
namespace codigo\brigit\includes\votes;

class voteDTO
{
    private $voter;
    private $meaning;
    private $type;

    public function __construct($voter, $meaning, $type)
    {
        $this->voter = $voter;
        $this->meaning = $meaning;
        $this->type = $type;
    }

    public function voter()
    {
        return $this->voter;
    }

    public function meaning()
    {
        return $this->meaning;
    }

    public function type()
    {
        return $this->type;
    }
}
?>
<?php
namespace codigo\brigit\includes\votes;

class voteDTO
{
    private const VALID_TYPES = ['like', 'dislike'];
    private $voter;
    private $meaning_id;
    private $tipe;

    public function __construct($voter, $meaning_id, $tipe)
    {
        if (!in_array($tipe, self::VALID_TYPES)) {
            throw new \InvalidArgumentException('El tipo debe ser "like" o "dislike"');
        }
        
        $this->voter = $voter;
        $this->meaning_id = $meaning_id;
        $this->tipe = $tipe;
    }
    public function meaning_id()
    {
        return $this->meaning_id;
    }

    public function voter()
    {
        return $this->voter;
    }

    public function tipe()
    {
        return $this->tipe;
    }

    public static function getValidTypes()
    {
        return self::VALID_TYPES;
    }
}
?>
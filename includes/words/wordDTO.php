<?php
namespace codigo\brigit\includes\words;

class wordDTO
{
    private $id;

    private $palabra;

    private $creador;

    public function __construct($id, $palabra, $creador)
    {
        $this->id = $id;
        $this->palabra = $palabra;
        $this->creador = $creador;
    }

    public function id()
    {
        return $this->id;
    }

    public function palabra()
    {
        return $this->palabra;
    }

    public function creador()
    {
        return $this->creador;
    }

}
?>
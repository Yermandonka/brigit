<?php
namespace codigo\brigit\includes\palabras;

class wordDTO
{
    private $id;

    private $palabra;

    private $significado;

    private $creador;

    private $votos;

    public function __construct($id, $palabra, $significado, $creador, $votos)
    {
        $this->id = $id;
        $this->palabra = $palabra;
        $this->significado = $significado;
        $this->creador = $creador;
        $this->votos = $votos;
    }

    public function id()
    {
        return $this->id;
    }

    public function palabra()
    {
        return $this->palabra;
    }

    public function significado()
    {
        return $this->significado;
    }

    public function creador()
    {
        return $this->creador;
    }

    public function votos()
    {
        return $this->votos;
    }
}
?>
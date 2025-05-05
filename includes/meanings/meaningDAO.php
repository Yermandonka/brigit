<?php
namespace codigo\brigit\includes\meanings;
use codigo\brigit\includes\Aplicacion;
use codigo\brigit\includes\baseDAO;

class meaningDAO extends baseDAO implements IMeaning
{
    public function __construct()
    {

    }


    private function buscaMeaning($meaningDTO)
    {
        $escPalabra = $this->realEscapeString($meaningDTO->palabra());
        $escSignificado = $this->realEscapeString($meaningDTO->significado());

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT meaning FROM meanings M WHERE M.word = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $escPalabra);

        $stmt->execute();

        $stmt->bind_result($significados);

        if ($stmt->fetch())
        {

                $stmt->close();

                return in_array($escSignificado, $significados);
        }
        $stmt->close();
        return false;

    }

    private function countMeanings($meaningDTO)
    {
        $escPalabra = $this->realEscapeString($meaningDTO->palabra());
        $escSignificado = $this->realEscapeString($meaningDTO->significado());

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT meaning FROM meanings M WHERE M.word = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $escPalabra);

        $stmt->execute();

        $stmt->bind_result($significados);

        if ($stmt->fetch())
        {
                $stmt->close();
                return count($significados);
        }
        $stmt->close();
        return false;

    }

    public function create($meaningDTO)
    {
        $createdMeaningDTO = false;

        try
        {
            $escPalabra = $this->realEscapeString($meaningDTO->palabra());

            $conn = Aplicacion::getInstance()->getConexionBd();
            
            $escSignificado = $this->realEscapeString($meaningDTO->significado());

            $escCreador = $this->realEscapeString($meaningDTO->creador());

            $escVotos = $this->realEscapeString($meaningDTO->votos());

            $query = "INSERT INTO meanings(word, meaning, creator, votes) VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssi", $escPalabra, $escSignificado, $escCreador, $escVotos);

            if ($stmt->execute())
            {
                $idMeaning = $conn->insert_id;
                
                $createdMeaningDTO = new meaningDTO($idMeaning, $meaningDTO->palabra(), $meaningDTO->significado(), $meaningDTO->creador(), $meaningDTO->votos());

                return $createdMeaningDTO;
            }
        }
        catch(\mysqli_sql_exception $e)
        {

            if ($conn->sqlstate == 23000) 
            { 
                throw new meaningAlreadyExistException("Ya existe el significado");
            }

            throw $e;
        }

        return $createdMeaningDTO;
    }

    public function getAllMeanings($word)
    {
        $meanings = [];
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT id, word, meaning, creator, votes FROM meanings WHERE word = ?";

        $stmt = $conn->prepare($query);
        
        $stmt->bind_param("s", $word);
        $stmt->execute();
        $stmt->bind_result($id, $palabra, $significado, $creador, $votos);

        while ($stmt->fetch()) {
            $meaning = new meaningDTO($id, $palabra, $significado, $creador, $votos);
            $meanings[] = $meaning;
        }
    
        $stmt->close();
        return $meanings;
    }

    public function getAllVotes($word)
    {
        $votes = 0;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT votes FROM meanings WHERE word = ?";

        $stmt = $conn->prepare($query);
        
        $stmt->bind_param("s", $word);
        $stmt->execute();
        $stmt->bind_result($votos);

        while ($stmt->fetch()) {
            $votes += $votos;
        }
    
        $stmt->close();
        return $votes;
    }

}
?>
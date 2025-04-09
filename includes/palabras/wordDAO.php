<?php
namespace codigo\brigit\includes\palabras;
use codigo\brigit\includes\Aplicacion;
use codigo\brigit\includes\baseDAO;

class wordDAO extends baseDAO implements IWord
{
    public function __construct()
    {

    }


    private function buscaPalabra($palabra)
    {
        $escPalabra = $this->realEscapeString($palabra);

        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT id, palabra, significado, creador, votos FROM Palabras P WHERE P.palabra = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $escPalabra);

        $stmt->execute();

        $stmt->bind_result($id, $palabra, $significado, $creador, $votos);

        if ($stmt->fetch())
        {
            $word = new wordDTO($id, $palabra, $significado, $creador, $votos);

            $stmt->close();

            return $word;
        }

        return false;
    }

    public function create($wordDTO)
    {
        $createdWordDTO = false;

        try
        {
            if ($this->buscaPalabra($wordDTO->palabra())) {
                throw new wordAlreadyExistException("Ya existe la palabra '{$wordDTO->palabra()}'");
            }
            $escPalabra = $this->realEscapeString($wordDTO->palabra());

            $conn = Aplicacion::getInstance()->getConexionBd();
            
            $escSignificado = $this->realEscapeString($wordDTO->significado());

            $escCreador = $this->realEscapeString($wordDTO->creador());

            $escVotos = $this->realEscapeString($wordDTO->votos());

            $query = "INSERT INTO Palabras(palabra, significado, creador, votos) VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssi", $escPalabra, $escSignificado, $escCreador, $escVotos);

            if ($stmt->execute())
            {
                $idWord = $conn->insert_id;
                
                $createdWordDTO = new wordDTO($idWord, $wordDTO->palabra(), $wordDTO->significado(), $wordDTO->creador(), $wordDTO->votos());

                return $createdWordDTO;
            }
        }
        catch(\mysqli_sql_exception $e)
        {
            // código de violación de restricción de integridad (PK)

            if ($conn->sqlstate == 23000) 
            { 
                throw new wordAlreadyExistException("Ya existe la palabra '{$wordDTO->palabra()}'");
            }

            throw $e;
        }

        return $createdWordDTO;
    }

    public function getAllWords()
{
    $words = [];
    $conn = Aplicacion::getInstance()->getConexionBd();

    $query = "SELECT id, palabra, significado, creador, votos FROM Palabras";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->bind_result($id, $palabra, $significado, $creador, $votos);

    while ($stmt->fetch()) {
        $word = new wordDTO($id, $palabra, $significado, $creador, $votos);
        $words[] = $word;
    }

    $stmt->close();
    return $words;
}

}
?>
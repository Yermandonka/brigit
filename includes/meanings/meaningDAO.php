<?php
namespace codigo\brigit\includes\meanings;
use codigo\brigit\includes\Aplicacion;
use codigo\brigit\includes\baseDAO;
use codigo\brigit\includes\words\wordAppService;

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

        if ($stmt->fetch()) {

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

        if ($stmt->fetch()) {
            $stmt->close();
            return count($significados);
        }
        $stmt->close();
        return false;

    }

    public function create($meaningDTO)
    {
        $createdMeaningDTO = false;

        try {
            $escPalabra = $this->realEscapeString($meaningDTO->palabra());

            $conn = Aplicacion::getInstance()->getConexionBd();

            $escSignificado = $this->realEscapeString(htmlentities($meaningDTO->significado(), ENT_QUOTES, 'UTF-8'));

            $escCreador = $this->realEscapeString($meaningDTO->creador());

            $escVotos = $this->realEscapeString($meaningDTO->votos());

            $query = "INSERT INTO meanings(meaning, word, creator, votes) VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($query);

            $stmt->bind_param("sssi", $escSignificado, $escPalabra, $escCreador, $escVotos);

            if ($stmt->execute()) {
                $idMeaning = $conn->insert_id;

                $createdMeaningDTO = new meaningDTO($idMeaning, $meaningDTO->palabra(), $meaningDTO->significado(), $meaningDTO->creador(), $meaningDTO->votos());

                return $createdMeaningDTO;
            }
        } catch (\mysqli_sql_exception $e) {

            if ($conn->sqlstate == 23000) {
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

        $query = "SELECT id, meaning, word, creator, votes FROM meanings WHERE word = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $word);
        $stmt->execute();
        $stmt->bind_result($id, $significado, $palabra, $creador, $votos);

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

    public function addVote($word, $meaning, $add)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();

        $escPalabra = $this->realEscapeString($word);

        $conn = Aplicacion::getInstance()->getConexionBd();
        $escSignificado = $this->realEscapeString(htmlentities($meaning, ENT_QUOTES, 'UTF-8'));
        if ($add) {
            $query = "UPDATE meanings SET votes = votes + 1 WHERE word = ? AND meaning = ?";
        } else {
            $query = "UPDATE meanings SET votes = votes - 1 WHERE word = ? AND meaning = ?";
        }
        $stmt = $conn->prepare($query);

        $stmt->bind_param("ss", $escPalabra, $escSignificado);
        $stmt->execute();
        $stmt->close();
    }

    public function getMeaningId($word, $meaning)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();

        $escPalabra = $this->realEscapeString($word);
        $escSignificado = $this->realEscapeString(html_entity_decode($meaning, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $escSignificado2 = $this->realEscapeString(htmlentities($escSignificado, ENT_QUOTES, 'UTF-8'));

        $query = "SELECT id FROM meanings WHERE word = ? AND meaning = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("ss", $escPalabra, $escSignificado2);
        $stmt->execute();
        $stmt->bind_result($id);

        if ($stmt->fetch()) {
            return $id;
        }

        return null;
    }

    public function getAllWords($word)
    {
        $words = [];
        $wordDTOs = [];
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT DISTINCT word FROM meanings WHERE meaning LIKE CONCAT('%', ?, '%')";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $word);
        $stmt->execute();
        $stmt->bind_result($foundWord);

        while ($stmt->fetch()) {
            $words[] = $foundWord;
        }

        $stmt->close();

        $wordAppService = wordAppService::GetSingleton();
        foreach ($words as $word) {
            $wordDTO = $wordAppService->getThisWord($word);
            if ($wordDTO) {
                $wordDTOs[] = $wordDTO;
            }
        }

        return $wordDTOs;
    }
}
?>
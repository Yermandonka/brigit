<?php
namespace codigo\brigit\includes\words;
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

        $query = "SELECT id, word, creator FROM Words W WHERE W.word = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $escPalabra);

        $stmt->execute();

        $stmt->bind_result($id, $palabra, $creador);

        if ($stmt->fetch()) {
            $word = new wordDTO($id, $palabra, $creador);

            $stmt->close();

            return $word;
        }

        return false;
    }

    public function create($wordDTO)
    {
        $createdWordDTO = false;

        try {
            if ($this->buscaPalabra($wordDTO->palabra())) {
                throw new wordAlreadyExistException("Ya existe la palabra '{$wordDTO->palabra()}'");
            }
            $escPalabra = $this->realEscapeString($wordDTO->palabra());

            $conn = Aplicacion::getInstance()->getConexionBd();

            $escCreador = $this->realEscapeString($wordDTO->creador());

            $query = "INSERT INTO Words(word, creator) VALUES (?, ?)";

            $stmt = $conn->prepare($query);

            $stmt->bind_param("ss", $escPalabra, $escCreador);

            if ($stmt->execute()) {
                $idWord = $conn->insert_id;

                $createdWordDTO = new wordDTO($idWord, $wordDTO->palabra(), $wordDTO->creador());

                return $createdWordDTO;
            }
        } catch (\mysqli_sql_exception $e) {

            if ($conn->sqlstate == 23000) {
                throw new wordAlreadyExistException("Ya existe la palabra '{$wordDTO->palabra()}'");
            }

            throw $e;
        }

        return $createdWordDTO;
    }

    public function getAllWords($user = null)
    {
        $words = [];
        $conn = Aplicacion::getInstance()->getConexionBd();

        if ($user !== null) {
            $query = "SELECT id, word, creator FROM Words WHERE creator = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $user);
        } else {
            $query = "SELECT id, word, creator FROM Words";
            $stmt = $conn->prepare($query);
        }

        $stmt->execute();
        $stmt->bind_result($id, $palabra, $creador);

        while ($stmt->fetch()) {
            $word = new wordDTO($id, $palabra, $creador);
            $words[] = $word;
        }

        $stmt->close();
        return $words;
    }

    public function getThisWord($word)
    {   
        $word1 = false;
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT id, word, creator FROM Words WHERE word LIKE ?";

        $stmt = $conn->prepare($query);

        // Escapar el parámetro y agregar comodines para búsqueda parcial
        $searchWord = '%' . $this->realEscapeString($word) . '%';
        $stmt->bind_param("s", $searchWord);

        $stmt->execute();
        $stmt->bind_result($id, $palabra, $creador);

        while ($stmt->fetch()) {
            $word1 = new wordDTO($id, $palabra, $creador);
        }

        $stmt->close();
        return $word1;
    }

    public function delete($word)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "DELETE FROM Words WHERE word = ?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("s", $word);
        $stmt->execute();
        $stmt->close();
    }

}
?>
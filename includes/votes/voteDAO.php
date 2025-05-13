<?php
namespace codigo\brigit\includes\votes;
use codigo\brigit\includes\Aplicacion;
use codigo\brigit\includes\baseDAO;

class voteDAO extends baseDAO implements IVote
{
    public function __construct()
    {
    }

    public function create($voteDTO)
    {
        $createdVoteDTO = false;

        try {
            $escPalabra = $this->realEscapeString($voteDTO->word());
            $escVote = $this->realEscapeString($voteDTO->vote());
            $escCreator = $this->realEscapeString($voteDTO->creator());
            $escVotes = $this->realEscapeString($voteDTO->votes());

            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = "INSERT INTO votes(word, vote, creator, votes) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $escPalabra, $escVote, $escCreator, $escVotes);

            if ($stmt->execute()) {
                $idVote = $conn->insert_id;
                $createdVoteDTO = new voteDTO($idVote, $voteDTO->word(), $voteDTO->vote(), $voteDTO->creator(), $voteDTO->votes());
                return $createdVoteDTO;
            }
        } catch (\mysqli_sql_exception $e) {
            if ($conn->sqlstate == 23000) {
                throw new voteAlreadyExistException("Ya existe este voto");
            }
            throw $e;
        }

        return $createdVoteDTO;
    }

    public function getAllVotesForWord($word)
    {
        $votes = [];
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT id, word, meaning, creator, votes FROM votes WHERE word = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $word);
        $stmt->execute();
        $stmt->bind_result($id, $palabra, $significado, $creador, $votos);

        while ($stmt->fetch()) {
            $vote = new voteDTO($id, $palabra, $significado, $creador, $votos);
            $votes[] = $vote;
        }

        $stmt->close();
        return $votes;
    }

    public function getAllVotes($word)
    {
        $votes = 0;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT votes FROM votes WHERE word = ?";
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

    public function addVote($word, $vote)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $escPalabra = $this->realEscapeString($word);
        $escVote = $this->realEscapeString(htmlentities($vote, ENT_QUOTES, 'UTF-8'));

        $query = "UPDATE votes SET votes = votes + 1 WHERE word = ? AND vote = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $escPalabra, $escVote);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function removeVote($word, $vote)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $escPalabra = $this->realEscapeString($word);
        $escVote = $this->realEscapeString(htmlentities($vote, ENT_QUOTES, 'UTF-8'));

        $query = "UPDATE votes SET votes = votes - 1 WHERE word = ? AND vote = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $escPalabra, $escVote);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}

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
            $escVoter = $this->realEscapeString($voteDTO->voter());
            $escMeaning = $this->realEscapeString($voteDTO->meaning());
            $escType = $this->realEscapeString($voteDTO->type());

            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = "INSERT INTO votes(voter, meaning_id, type) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sis", $escVoter, $escMeaning, $escType);

            if ($stmt->execute()) {
                $createdVoteDTO = new voteDTO($voteDTO->voter(), $voteDTO->meaning(), $voteDTO->type());
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

    public function getUserVote($voter, $meaning_id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT type FROM votes WHERE voter = ? AND meaning_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $voter, $meaning_id);
        $stmt->execute();
        $stmt->bind_result($type);
        
        if ($stmt->fetch()) {
            $stmt->close();
            return $type;
        }
        
        $stmt->close();
        return false;
    }

    public function updateVoteType($voter, $meaning_id, $type)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "UPDATE votes SET type = ? WHERE voter = ? AND meaning_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $type, $voter, $meaning_id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}

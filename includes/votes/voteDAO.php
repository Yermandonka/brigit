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
        $conn = Aplicacion::getInstance()->getConexionBd();
        // Cambiado 'type' por 'tipe' para coincidir con la base de datos
        $query = "INSERT INTO votes(voter, meaning_id, tipe) VALUES (?, ?, ?)";
        
        try {
            $stmt = $conn->prepare($query);
            
            $voter = $voteDTO->voter();
            $meaningId = $voteDTO->meaning_id();
            $type = $voteDTO->tipe();
            
            $stmt->bind_param("sis", $voter, $meaningId, $type);
            
            if ($stmt->execute()) {
                return new VoteDTO($voter, $meaningId, $type);
            }
            
            return false;
        } catch (\Exception $e) {
            error_log("Error in voteDAO->create: " . $e->getMessage());
            throw $e;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function getUserVote($voter, $meaning_id)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT tipe FROM votes WHERE voter = ? AND meaning_id = ?";
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

    public function getAllVotes($user = null)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT COUNT(*) FROM votes WHERE voter = ?";
        
        try {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            
            return $count;
        } catch (\Exception $e) {
            error_log("Error in getAllVotes: " . $e->getMessage());
            throw $e;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function updateVoteType($voter, $meaning_id, $type)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "UPDATE votes SET tipe = ? WHERE voter = ? AND meaning_id = ?";
        
        try {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $type, $voter, $meaning_id);
            
            $result = $stmt->execute();
            
            return $result;
        } catch (\Exception $e) {
            error_log("Error in updateVoteType: " . $e->getMessage());
            throw $e;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
}

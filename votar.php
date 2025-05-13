<?php
require_once __DIR__ . '/includes/config.php';
use codigo\brigit\includes\meanings\meaningAppService;
use codigo\brigit\includes\votes\voteAppService;

// Verificar si el usuario está logueado
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión para votar']);
    exit();
}

// Obtener parámetros
$palabra = $_GET['palabra'] ?? '';
$significado = $_GET['significado'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$voter = $_SESSION['nombre'] ?? '';

$response = ['success' => false, 'votes' => 0];

if ($palabra && $significado && $tipo && $voter) {
    $meaningAppService = meaningAppService::GetSingleton();
    $voteAppService = voteAppService::GetSingleton();

    try {
        $meaningId = $meaningAppService->getMeaningId($palabra, $significado);
        if ($tipo === 'like') {
            if ($voteAppService->getUserVote($voter, $meaningId) === false) {
                $meaningAppService->addVote($palabra, $significado, true);
                $voteAppService->create($voter, $meaningId, 'like');
            } else if ($voteAppService->getUserVote($voter, $meaningId) === 'dislike') {
                $meaningAppService->addVote($palabra, $significado, true);
                $meaningAppService->addVote($palabra, $significado, true);
                $voteAppService->updateVoteType($voter, $meaningId, 'like');
            }
        } else if ($tipo === 'dislike') {
            if ($voteAppService->getUserVote($voter, $meaningId) === false) {
                $meaningAppService->addVote($palabra, $significado, false);
                $voteAppService->create($voter, $meaningId, 'dislike');
            } else if ($voteAppService->getUserVote($voter, $meaningId) === 'like') {
                $meaningAppService->addVote($palabra, $significado, false);
                $meaningAppService->addVote($palabra, $significado, false);
                $voteAppService->updateVoteType($voter, $meaningId, 'dislike');
            }
        }

        // Obtener el nuevo conteo de votos
        $votes = $meaningAppService->getAllVotes($palabra);
        $lastVoto = $voteAppService->getUserVote($voter, $meaningId);
        
        $response = [
            'success' => true,
            'votes' => $votes,
            'lastVote' => $lastVoto
        ];
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }

}

// Devolver respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

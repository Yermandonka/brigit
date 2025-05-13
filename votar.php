<?php
require_once __DIR__.'/includes/config.php';
use codigo\brigit\includes\meanings\meaningAppService;

// Obtener parámetros
$palabra = $_GET['palabra'] ?? '';
$significado = $_GET['significado'] ?? '';
$tipo = $_GET['tipo'] ?? '';

$response = ['success' => false, 'votes' => 0];

if ($palabra && $significado && $tipo) {
    $meaningAppService = meaningAppService::GetSingleton();
    
    try {
        if ($tipo === 'like') {
            $meaningAppService->addVote($palabra, $significado, true);
        } else if ($tipo === 'dislike') {
            $meaningAppService->addVote($palabra, $significado, false);
        }
        
        // Obtener el nuevo conteo de votos
        $votes = $meaningAppService->getAllVotes($palabra);
        
        $response = [
            'success' => true,
            'votes' => $votes
        ];
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
    }
}

// Devolver respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

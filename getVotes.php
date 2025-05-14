<?php
require_once __DIR__ . '/includes/config.php';
use codigo\brigit\includes\meanings\meaningAppService;

$palabra = $_GET['palabra'] ?? '';

if ($palabra) {
    $meanignService = meaningAppService::GetSingleton();
    $votes = $meanignService->getAllVotes($palabra);
    
    if ($votes !== null) {
        echo json_encode([
            'success' => true,
            'votes' => $votes
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Palabra no encontrada'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Palabra no especificada'
    ]);
}
<?php
require_once __DIR__.'/includes/config.php';
use codigo\brigit\includes\meanings\meaningAppService;
use codigo\brigit\includes\words\wordAppService;

header('Content-Type: application/json');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

if (isset($_GET['palabra'], $_GET['significado'])) {
    $meaning = $_GET['significado'];
    $palabra = $_GET['palabra'];
    $meaningAppService = meaningAppService::GetSingleton();
    $wordAppService = wordAppService::GetSingleton();
    $meaningDTO = $meaningAppService->getThisMeaning($palabra, $meaning);
    
    try {
        $meaningAppService->delete($meaningDTO);
        echo json_encode(['success' => true]);
        if (count($meaningAppService->getAllMeanings($palabra)) === 0) {
            $wordAppService->delete($palabra);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parámetros incorrectos']);
}
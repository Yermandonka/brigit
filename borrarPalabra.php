<?php
require_once 'config.php';
use codigo\brigit\includes\meanings\meaningAppService;

header('Content-Type: application/json');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

if (isset($_GET['palabra'])) {
    $palabra = $_GET['palabra'];
    $meaningAppService = meaningAppService::GetSingleton();
    $meaningDTO = $meaningAppService->getThisMeaning($palabra);
    
    try {
        $meaningAppService->delete($meaningDTO);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parámetros incorrectos']);
}
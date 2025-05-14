<?php
require_once __DIR__ . '/includes/config.php';
use codigo\brigit\includes\meanings\MeaningAppService;
use codigo\brigit\includes\meanings\meaningDTO;

try {
    if (!isset($_POST['palabra']) || !isset($_POST['significado'])) {
        throw new Exception('Faltan parámetros requeridos');
    }

    $palabra = trim($_POST['palabra']);
    $significado = trim($_POST['significado']);
    $creador = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'anonimo';

    if (empty($palabra) || empty($significado)) {
        throw new Exception('Los parámetros no pueden estar vacíos');
    }

    // Usar el servicio MeaningApp para crear el significado
    $meaningService = MeaningAppService::GetSingleton();
    $result = $meaningService->create(new meaningDTO(0, $palabra, $significado, $creador, 0));

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Significado añadido correctamente'
        ]);
    } else {
        throw new Exception('Error al guardar el significado');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
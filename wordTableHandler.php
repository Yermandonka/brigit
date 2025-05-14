<?php
require_once __DIR__ . '/includes/config.php';
use codigo\brigit\includes\tables\WordTable;

header('Content-Type: text/html; charset=utf-8');

try {
    if (!isset($_GET['palabra'])) {
        throw new Exception('Palabra no especificada');
    }

    $palabra = $_GET['palabra'];
    $wordTable = new WordTable();
    echo $wordTable->manage($palabra);
    
} catch (Exception $e) {
    http_response_code(500);
    echo '<div class="error">' . htmlspecialchars($e->getMessage()) . '</div>';
}
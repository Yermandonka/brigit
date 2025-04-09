<?php
use codigo\brigit\includes\palabras\wordAppService;
require_once __DIR__.'/includes/config.php';

$wordAppService = wordAppService::GetSingleton();

$words = $wordAppService->getAllWords();

$tituloPagina = 'Foros';

$contenidoPrincipal = <<<EOS
<h1>Lista de Palabras</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Palabra</th>
            <th>Significado</th>
            <th>Creador ID</th>
            <th>Votos</th>
        </tr>
    </table>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
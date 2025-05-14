<?php
require_once __DIR__.'/includes/config.php';
use codigo\brigit\includes\words\wordAppService;
use codigo\brigit\includes\tables\myWordsTable;
use codigo\brigit\includes\tables\myMeaningsTable;


// Verificar si el usuario está logueado
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php');
    exit();
}

// Inicializar servicios y tablas
$wordAppService = wordAppService::GetSingleton();
$myWordsTable = new myWordsTable();
$htmlMyWordsTable = $myWordsTable->manage();
$myMeaningsTable = new myMeaningsTable();
$htmlMyMeaningsTable = $myMeaningsTable->manage();


$tituloPagina = 'Mi Área Personal';

$contenidoPrincipal = <<<EOS
<div class='my-area-container'>
    <section class='my-words'>
        <h2>Mis Palabras</h2>
        {$htmlMyWordsTable}
    </section>

    <section class="my-meanings">
        <h2>Mis Significados</h2>
        {$htmlMyMeaningsTable}
    </section>

</div>

EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
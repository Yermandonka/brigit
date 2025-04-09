<?php
use codigo\brigit\includes\tablas\RankingTable;
require_once __DIR__.'/includes/config.php';


$table = new RankingTable();
$htmlTable = $table->manage();


$tituloPagina = 'Ranking';

$contenidoPrincipal = <<<EOS
$htmlTable
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
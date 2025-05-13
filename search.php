<?php
use codigo\brigit\includes\tables\RankingTable;
require_once __DIR__.'/includes/config.php';

$table = new RankingTable();

$htmlTable = $table->search($_GET['palabra'] ?? null);

$contenidoPrincipal = <<<EOS
EOS;


$tituloPagina = 'Search Page';

$contenidoPrincipal = <<<EOS
<div class="row search">
<div class="col">
<form class="form-inline my-2 my-lg-0">
<input class="form-control mr-sm-2" type="search" placeholder="Buscar palabra">
<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
</form>
</div>
</div>

$htmlTable

EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
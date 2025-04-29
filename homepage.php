<?php

require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'Homepage';

$contenidoPrincipal = <<<EOS
<div class="row search">
<div class="col">
<form class="form-inline my-2 my-lg-0">
<input class="form-control mr-sm-2" type="search" placeholder="Buscar palabra">
<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
</form>
</div>
</div>

<div class="row funcionalidades">
<div class="funcionalidad col-xs-12 col-md-6" id="creador">
<a href="creador.php">Creador</a>
</div>
<div class="funcionalidad col-xs-12 col-md-6" id="ranking">
<a href="ranking.php">Ranking</a>
</div>
<div class="funcionalidad col-xs-12 col-md-6" id="buscador">
<a href="buscador.php">Buscador</a>
</div>
<div class="funcionalidad col-xs-12 col-md-6" id="foros">
<a href="foros.php">Foros</a>
</div>
</div>

EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

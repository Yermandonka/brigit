<?php

require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'Index';
$RUTA_APP = RUTA_APP;

$contenidoPrincipal = <<<EOS
<div class="row search">
<div class="col">
<form class="form-inline my-2 my-lg-0" method="get" action="search.php" target="_blank">
<input class="form-control mr-sm-2" type="search" name="palabra" placeholder="Buscar palabra">
<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
</form>
</div>
</div>

<div class="row funcionalidades">
<div class="funcionalidad col-xs-12 col-md-6" id="creador">
<a href="creador.php" style="background-image: url('$RUTA_APP/images/littlegirlinabluearmchair.png');">Creador</a>
</div>
<div class="funcionalidad col-xs-12 col-md-6" id="ranking">
<a href="ranking.php" style="background-image: url('$RUTA_APP/images/cocktails.png');">Ranking</a>
</div>
<div class="funcionalidad col-xs-12 col-md-6" id="buscador">
<a href="search.php" style="background-image: url('$RUTA_APP/images/maninavest.png');">Buscador</a>
</div>
<div class="funcionalidad col-xs-12 col-md-6" id="myArea">
<a href="myArea.php" style="background-image: url('$RUTA_APP/images/thefightingtemeraire.png');">MyArea</a>
</div>
</div>

EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

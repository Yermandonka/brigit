<?php

require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'Homepage';

$contenidoPrincipal = <<<EOS
<div id="funcionalidades1" class="funcionalidades">
<div id="creador" class="funcionalidad">
<a href="creador.php">Creador</a>
</div>
<div id="ranking" class="funcionalidad">
<a href="ranking.php">Ranking</a>
</div>
</div>
<div id="funcionalidades2" class="funcionalidades">
<div id="buscador" class="funcionalidad">
<a href="buscador.php">Buscador</a>
</div>
<div id="foros" class="funcionalidad">
<a href="foros.php">Foros</a>
</div>
</div>
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla.php';

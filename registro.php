<?php
use codigo\brigit\includes\formularios\FormularioRegistro;
require_once __DIR__.'/includes/config.php';

$form = new FormularioRegistro();
$htmlFormRegistro = $form->Manage();

$tituloPagina = 'Registro';

$contenidoPrincipal = <<<EOS
$htmlFormRegistro
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

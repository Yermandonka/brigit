<?php
use codigo\brigit\includes\formularios\FormularioPalabra;
require_once __DIR__.'/includes/config.php';

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php?redirect=creador.php');
}

$form = new FormularioPalabra();
$htmlFormLogin = $form->Manage();

$tituloPagina = 'Creador';

$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
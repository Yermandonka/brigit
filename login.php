<?php
use codigo\brigit\includes\formularios\FormularioLogin;
require_once __DIR__.'/includes/config.php';

$redirect = $_GET['redirect'] ?? null;
$form = new FormularioLogin();
$htmlFormLogin = $form->Manage($redirect);

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

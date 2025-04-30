<?php
use codigo\brigit\includes\formularios\FormularioLogin;
require_once __DIR__.'/includes/config.php';

if (isset($_GET['redirect'])) {
    $_POST['redirect'] = $_GET['redirect'];
}

$redirect = $_GET['redirect'] ?? null;
$form = new FormularioLogin();
$htmlFormLogin = $form->Manage();

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS
$htmlFormLogin
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';

<?php
function mostrarSaludo()
{
	$rutaApp = RUTA_APP;
	if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) {
		return "<p>Bienvenido, {$_SESSION['nombre']}</p> <a href='{$rutaApp}/logout.php'>(salir)</a>";
	} else {
		return "<p>Usuario desconocido.</p> <a href='{$rutaApp}/login.php'>Login</a> <a href='{$rutaApp}/registro.php'>Registro</a>";
	}
}
?>
<header>
	<div id="menu">
		<a href="sobrenosotros.php">Sobre nosotros</a>
		<a href="creador.php">Creador</a>
		<a href="ranking.php">Ranking</a>
		<a href="buscador.php">Buscador</a>
		<a href="foros.php">Foros</a>
	</div>
	<div id="logoandlogin">
		<h1><a href="homepage.php">brigit.com</a></h1>
		<div class="saludo">
			<?= mostrarSaludo() ?>
		</div>
	</div>
</header>
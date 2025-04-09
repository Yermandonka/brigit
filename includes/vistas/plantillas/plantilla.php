<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $tituloPagina ?></title>
	<link rel="stylesheet" media="screen" href="<?= RUTA_CSS ?>/navegador.css">
	<link rel="stylesheet" media="print" href="<?= RUTA_CSS ?>/impresora.css">
	<link rel="stylesheet" media="(max-width:800px)" href="<?= RUTA_CSS ?>/tablet.css">
</head>

<body>
	<div id="contenedor">
		<?php
		require(RAIZ_APP . '/vistas/comun/cabecera.php');
		?>
		<main>
			<article>
				<?= $contenidoPrincipal ?>
			</article>
		</main>
		<?php
		require(RAIZ_APP . '/vistas/comun/pie.php');
		?>
	</div>
</body>

</html>
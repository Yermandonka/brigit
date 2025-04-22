<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $tituloPagina ?></title>
	<link rel="stylesheet" media="screen" href="<?= RUTA_CSS ?>/navegador.css">
	<link rel="stylesheet" media="print" href="<?= RUTA_CSS ?>/impresora.css">
	<link rel="stylesheet" media="(max-width:800px)" href="<?= RUTA_CSS ?>/tablet.css">
	<link rel="stylesheet" href="<?= RUTA_BOOTSTRAP ?>/bootstrap.css">
</head>

<body>
	<div id="contenedor">
		<div class="row">
			<div class="col-12">
				<?php
				require(RAIZ_APP . '/vistas/comun/menu.php');
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<?php
				require(RAIZ_APP . '/vistas/comun/cabecera.php');
				?>
			</div>
		</div>
		<div class="row align-items-center">
			<div class="col-lg-12">
				<main>
					<?= $contenidoPrincipal ?>
				</main>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<?php
				require(RAIZ_APP . '/vistas/comun/pie.php');
				?>
			</div>
		</div>
	</div>
</body>

</html>
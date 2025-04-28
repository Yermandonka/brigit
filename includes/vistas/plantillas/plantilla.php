<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $tituloPagina ?></title>
	<link rel="stylesheet" media="screen" href="<?= RUTA_CSS ?>/navegador.css">
	<link rel="stylesheet" media="print" href="<?= RUTA_CSS ?>/impresora.css">
	<link rel="stylesheet" media="(max-widFth:800px)" href="<?= RUTA_CSS ?>/tablet.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?= RUTA_BOOTSTRAP ?>/bootstrap.css">
</head>

<body>
	<div id="contenedor">
		<div class="row menu">
			<?php
			require(RAIZ_APP . '/vistas/comun/menu.php');
			?>
		</div>
		<div class="row header">
			<div class="col">
				<?php
				require(RAIZ_APP . '/vistas/comun/header.php');
				?>
			</div>
		</div>
		<div class="row main">
			<div class="col">
				<main>
					<?= $contenidoPrincipal ?>
				</main>
			</div>
		</div>
		<div class="row footer">
			<div class="col">
				<?php
				require(RAIZ_APP . '/vistas/comun/footer.php');
				?>
			</div>
		</div>
	</div>
</body>

</html>
<!DOCTYPE html>
<html>

<head>
	<title><?= $tituloPagina ?></title>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?= $tituloPagina ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="<?= RUTA_BOOTSTRAP ?>/bootstrap.css">
		<link rel="stylesheet" media="screen" href="<?= RUTA_CSS ?>/navegador.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?= RUTA_JS ?>/javascript.js"></script>
</head>

<body>
	<div id="container-fluid">
		<div class="row menu w-100">
			<?php
			require(RAIZ_APP . '/vistas/comun/menu.php');
			?>
		</div>
		<div class="row header w-100">
			<div class="col">
				<?php
				require(RAIZ_APP . '/vistas/comun/header.php');
				?>
			</div>
		</div>
		<div class="row header2 w-100">
			<div class="col">
				<?php
				require(RAIZ_APP . '/vistas/comun/navbar.php');
				?>
			</div>
		</div>
		<div class="row main w-100">
			<div class="col">
				<main>
					<?= $contenidoPrincipal ?>
				</main>
			</div>
		</div>
		<div class="row footer w-100">
			<div class="col">
				<?php
				require(RAIZ_APP . '/vistas/comun/footer.php');
				?>
			</div>
		</div>
	</div>
</body>

</html>
<?php
function mostrarSaludo()
{
  if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) {
    echo "<label>Bienvenido, " . $_SESSION['nombre'] . ".<a href='logout.php'>(salir)</a></label>";
  } else {
    echo "<label>usuario desconocido. <a href='login.php'>Login.</a> <a href='register.php'>Registro</a></label>";
  }
}
?>

<nav class="navbar navbar-expand-lg">
  <!-- Logo/Nombre del sitio -->
  <a id="logoandlogin" class="logo" href="homepage.php">brigit.com</a>

  <!-- Botón hamburguesa para móviles -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Contenido colapsable -->
  <div class="collapse navbar-collapse" id="navbarSupportedContent d-lg-none">
    <!-- Lista de enlaces que aparecerán en el menú hamburguesa -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item d-lg-none">
        <a class="nav-link" href="sobrenosotros.php">Sobre Nosotros</a>
      </li>
      <li class="nav-item d-lg-none">
        <a class="nav-link" href="creador.php">Creador</a>
      </li>
      <li class="nav-item d-lg-none">
        <a class="nav-link" href="ranking.php">Ranking</a>
      </li>
    </ul>
    <div id="logoandlogin">
      <?php mostrarSaludo(); ?>
    </div>
  </div>
</nav>
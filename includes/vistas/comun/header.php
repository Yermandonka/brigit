<?php
function mostrarSaludo()
{
  if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) {
    echo "<label><span>Bienvenido, " . $_SESSION['nombre'] . "</span> <a href='logout.php'>(salir)</a></label>";
  } else {
    echo "<label><span>Usuario desconocido</span> <a href='login.php'>LOGIN</a> <a href='registro.php'>REGISTRO</a></label>";
  }
}
?>

<nav class="navbar navbar-expand-lg">
  <!-- Logo/Nombre del sitio -->
  <a class="logo" href="homepage.php">brigit.com</a>

  <!-- Botón hamburguesa para móviles -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <img src="/codigo/brigit/images/menu.svg" alt="Menú" style="width: 30px; height: 30px;">
  </button>

  <div class="saludo">
    <?php mostrarSaludo(); ?>
  </div>
</nav>
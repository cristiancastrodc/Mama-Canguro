<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "menu.php";
  // Inicializar la sesion
  if (!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
?>
<!DOCTYPE HTML>
<html>
  <head>
    <!-- General -->
    <meta charset="UTF-8">
    <title>Secretaría | Mama Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico">
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/style-menu-secre.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/layout.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  </head>
  <body>
    <div class="bg bg-min-height">
      <!-- Menú -->
      <div class="container">
          <form method="post">
          <?php
            _print_menu_principal();
          ?>
          </form>
      </div>
      <!-- Fin del menú -->
      <?php
        _print_footer();
      ?>
    </div>
    <!-- Javascripts -->
    <script src="../assets/js/lock.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>
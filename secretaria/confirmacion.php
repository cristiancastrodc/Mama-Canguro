<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Confirmación | Clínica Mamá Canguro</title>
    <link rel="icon" type="image/png" href="../assets/img/icon.ico"/>
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style-login.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/layout.css" rel="stylesheet" type="text/css" media="all">
    <!-- Javascripts -->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="assets/js/jquery-v1.min.js"></script>
    <script src="../assets/js/lock.js"></script>
  </head>
  <body>
    <div class="row">
      <div class="col-lg-12">
        <img src="../assets/img/confirmacion.png" alt="" class="img-responsive center">
        <div class="alert alert-info center-align"><b>Éxito!</b> Información de paciente registrada.</div>
        <a href="../secretaria" role="button" class="btn btn-block btn-lg btn-success">Regresar al menú.</a>
      </div>
    </div>
    <?php
      _print_footer();
    ?>
  </body>
</html>
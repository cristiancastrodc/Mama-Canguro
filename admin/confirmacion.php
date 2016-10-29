<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('admin');
  // Recuperar el mensaje de confirmación
  $nro_mensaje = $_GET["nromensaje"];
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
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
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  </head>
  <body>
    <!-- Cuerpo de la página -->
    <section id="container" >
      <?php
        // Mostrar el header
        _print_header();
        // Mostrar el menú
        _print_menu($conexion);
      ?>
      <!-- ****************************** MAIN CONTENT ******************************-->
      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">
          <div class="row">
            <div class="col-lg-12">
              <img src="assets/img/confirmacion.jpg" alt="" class="img-responsive center banner-img">
              <div class="alert alert-info center-align"><b>Éxito!</b>
                <?php
                  if ($nro_mensaje == 1) {
                    echo "Se restauró la Base de Datos.";
                  } elseif ($nro_mensaje == 2) {
                    echo "Muestra recepcionada.";
                  } elseif ($nro_mensaje == 3) {
                    echo "Resultado de examen guardado.";
                  } elseif ($nro_mensaje == 4) {
                    echo "Atención de paciente registrada.";
                  } elseif ($nro_mensaje == 5) {
                    echo "Resultado de consulta almacenado.";
                  } elseif ($nro_mensaje == 6) {
                    echo "Datos de paciente actualizados.";
                  } elseif ($nro_mensaje == 7) {
                    echo "Atención registrada.";
                  } elseif ($nro_mensaje = 8) {
                    echo "Datos de servicio actualizados.";
                  }
                ?>
              </div>
              <a href="index.php" role="button" class="btn btn-block btn-lg btn-success">Regresar al menú.</a>
            </div>
          </div>
        </section>
      </section>
      <?php
        _print_footer();
      ?>
    </section>
    <!-- Javascripts -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script src="../assets/js/lock.js"></script>
  </body>
</html>
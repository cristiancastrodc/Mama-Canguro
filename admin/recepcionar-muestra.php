<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <title>Recepcionar Muestra de Laboratorio | Administrador </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout.css">
    <!-- Javascripts -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
    </script>
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
        <div class="row mt">
          <div class="col-lg-12 contenido-biologo">
            <div class="content-panel">
              <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Muestras pendientes de entrega</h3>
              <?php
                _print_biologo_recepcionar($conexion);
              ?>

            </div>
          </div>
        </div>
      </section>
    </section>
    <!--main content end-->
    <?php
      _print_footer();
    ?>
    <!--footer end-->
  </section> <!-- Fin del cuerpo de la página -->
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="assets/js/jquery.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
  <script src="assets/js/jquery.scrollTo.min.js"></script>
  <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="assets/js/common-scripts.js"></script>
  <script src="../assets/js/lock.js"></script>
  <script src="assets/js/dataTables/jquery.dataTables.js"></script>
  <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
  <script type="application/javascript">
    $(document).ready(function () {
      $("#a_biologo").addClass("active");
      $("#tabla-examenes-sin-entregar").dataTable();
    });
  </script>
  </body>
</html>
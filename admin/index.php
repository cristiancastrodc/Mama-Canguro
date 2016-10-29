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
    <title>Menú Principal | Administrador </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
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
        <div class="row">
          <div class="col-lg-12 main-chart">
            <div class="row">
              <!-- CALENDAR-->
              <div class="col-lg-8 col-sm-6">
                <div id="calendar" class="mb">
                  <div class="panel green-panel no-margin">
                    <div class="panel-body">
                      <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                        <div class="arrow"></div>
                        <h3 class="popover-title" style="disadding: none;"></h3>
                        <div id="date-popover-content" class="popover-content"></div>
                      </div>
                      <div id="my-calendar"></div>
                    </div>
                  </div>
                </div><!-- / calendar -->
              </div><!-- end col-lg-8 -->
                <!-- SECCION PARA LOS MIEMBROS DEL EQUIPO -->
              <div class="col-lg-4 col-sm-6 ds">
                <?php
                  _print_usuarios_activos($conexion);
                ?>
              </div>
            </div> <!-- row end -->
            <div class="row mt">
              <!--CUSTOM CHART START -->
              <div class="border-head">
                <h3 class="center-align">Atenciones de los Últimos 6 Días</h3>
              </div>
                <?php
                  // Variable tipo numérica que almacena el día actual
                  $hoy = strtotime(date('Y-m-j'));
                  // Calcular el primer día de la iteración
                  if (date('l', $hoy) == 'Saturday') {
                    $primer_dia = strtotime('-5 day', $hoy);
                  }
                  else{
                    $primer_dia = strtotime('-6 day', $hoy);
                  }
                  // Imprimir el reporte
                  _reporte_seis_ultimas_atenciones($conexion, date('Y-m-d', $primer_dia), date('Y-m-d', $hoy));
                ?>
            </div> <!-- row end -->
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
  <script src="assets/js/zabuto_calendar.js"></script>
  <script src="../assets/js/lock.js"></script>
  <script type="application/javascript">
    $(document).ready(function () {
      $("#my-calendar").zabuto_calendar({
        language: "es"
      });
      $("#a_inicio").addClass("active");
    });
  </script>
  </body>
</html>
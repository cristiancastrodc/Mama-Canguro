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
    <title>Reportes | Clínica Mamá Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/layout.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/js/jquery-ui/jquery-ui.css" rel="stylesheet">
    <!-- Javascripts -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?php
      // Mostrar el header
      _print_header();
      // Mostrar el menú
      _print_menu($conexion);
    ?>
    <!-- Cuerpo de la página -->
    <section id="container" >
      <!-- *******************************  MAIN CONTENT  ******************************************* -->
      <section id="main-content">
        <section class="wrapper">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-panel">
                <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Reportes y Estadísticas</h3>
                <!-- INICIO DE REPORTE 1-->
                <h3 id="r1" class="titulo-reporte">1. Lista de Atenciones por Día</h3>
                <div id="report1" class="row">
                  <div class="col-xs-6">
                    <input type="text" id="r1_fecha" class="form-control" placeholder="Fecha">
                  </div>
                  <div class="col-xs-6">
                    <a id="a_r1" role="button" class="btn btn-danger btn-block">Generar Reporte</a>
                  </div>
                  <hr>
                </div>
                <hr>
                <!-- FIN DE REPORTE 1 -->
                <!-- INICIO DE REPORTE 2 -->
                <h3 id="r2" class="titulo-reporte">2. Atenciones y Cobros por Servicio por Día</h3>
                <div id="report2" class="row">
                  <div class="col-xs-6">
                    <input type="text" id="r2_fecha" class="form-control" placeholder="Fecha">
                  </div>
                  <div class="col-xs-6">
                    <a id="a_r2" role="button" class="btn btn-danger btn-block">Generar Reporte</a>
                  </div>
                </div>
                <hr>
                <!-- FIN DE REPORTE 2 -->
                <!-- INICIO DE REPORTE 4 -->
                <h3 id="r4" class="titulo-reporte">3. Atenciones y Cobros por Servicio por Mes</h3>
                <div id="report4" class="row">
                  <div class="col-xs-6">
                    <select class="form-control" id="r4_mes">
                      <option value="1">Enero</option>
                      <option value="2">Febrero</option>
                      <option value="3">Marzo</option>
                      <option value="4">Abril</option>
                      <option value="5">Mayo</option>
                      <option value="6">Junio</option>
                      <option value="7">Julio</option>
                      <option value="8">Agosto</option>
                      <option value="9">Septiembre</option>
                      <option value="10">Octubre</option>
                      <option value="11">Noviembre</option>
                      <option value="12">Diciembre</option>
                    </select>
                  </div>
                  <div class="col-xs-6">
                    <a id="a_r4" href="generacion-reportes.php?reporte=4&mes=1" role="button" class="btn btn-danger btn-block">Generar Reporte</a>
                  </div>
                </div>
                <hr>
                <!-- FIN DE REPORTE 4 -->
                <!-- INICIO DE REPORTE 3 -->
                <h3 id="r3" class="titulo-reporte">4. Atenciones y Cobros de un Servicio entre Fechas</h3>
                <div id="report3" class="row">
                  <div class="col-xs-4">
                    <input type="text" id="r3_fecha_inicio" class="form-control" placeholder="Fecha de Inicio">
                  </div>
                  <div class="col-xs-4">
                    <input type="text" id="r3_fecha_fin" class="form-control" placeholder="Fecha de Fin">
                  </div>
                  <div class="col-xs-4">
                    <a id="a_r3" role="button" class="btn btn-danger btn-block">Generar Reporte</a>
                  </div>
                </div>
                <hr>
                <!-- FIN DE REPORTE 3 -->
                <!-- INICIO DE REPORTE 5 -->
                <h3 id="r5" class="titulo-reporte">5. Atenciones y Cobros Totales Diarios entre Fechas</h3>
                <div id="report5" class="row">
                  <div class="col-xs-4">
                    <input type="text" id="r5_fecha_inicio" class="form-control" placeholder="Fecha de Inicio">
                  </div>
                  <div class="col-xs-4">
                    <input type="text" id="r5_fecha_fin" class="form-control" placeholder="Fecha de Fin">
                  </div>
                  <div class="col-xs-4">
                    <a id="a_r5" role="button" class="btn btn-danger btn-block">Generar Reporte</a>
                  </div>
                </div>
                <hr>
                <!-- FIN DE REPORTE 5 -->
                <!-- INICIO DE REPORTE 6 -->
                <h3><a class="titulo-reporte" href="generacion-reportes.php?reporte=6">6. Atenciones Mensuales</a></h3>
                <hr>
                <!-- FIN DE REPORTE 6 -->
                <!-- INICIO DE REPORTE 7 -->
                <h3 id="r7" class="titulo-reporte">7. Filiaciones Diarias entre Fechas</h3>
                <div id="report7" class="row">
                  <div class="col-xs-4">
                    <input type="text" id="r7_fecha_inicio" class="form-control" placeholder="Fecha de Inicio">
                  </div>
                  <div class="col-xs-4">
                    <input type="text" id="r7_fecha_fin" class="form-control" placeholder="Fecha de Fin">
                  </div>
                  <div class="col-xs-4">
                    <a id="a_r7" role="button" class="btn btn-danger btn-block">Generar Reporte</a>
                  </div>
                </div>
                <hr>
                <!-- FIN DE REPORTE 7 -->
                <!-- INICIO DE REPORTE 8 -->
                <h3 id="r8" class="titulo-reporte">8. Estadístico de Pacientes</h3>
                <div id="report8" class="row">
                  <div class="col-xs-4">
                    <input type="text" id="r8_fecha_inicio" class="form-control" placeholder="Fecha de Inicio">
                  </div>
                  <div class="col-xs-4">
                    <input type="text" id="r8_fecha_fin" class="form-control" placeholder="Fecha de Fin">
                  </div>
                  <div class="col-xs-4">
                    <a id="a_r8" role="button" class="btn btn-danger btn-block">Generar Reporte</a>
                  </div>
                </div>
                <hr>
                <!-- FIN DE REPORTE 8 -->
              </div>
            </div>
          </div><!-- end row -->
        </section><!-- /wrapper -->
      </section><!-- /MAIN CONTENT -->
      <?php
        _print_footer();
      ?>
    </section> <!-- Fin del cuerpo de la página -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-ui/jquery-ui.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script src="assets/js/reportes.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script>
      $(document).ready(function () {
        $("#a_administrador").addClass("active");
      });
    </script>
  </body>
</html>

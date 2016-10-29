<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  require_once "funciones-reportes.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  // Recuperar el nro de reporte
  $reporte = $_GET["reporte"];
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <title>Reporte | Administrador </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout.css">
    <link href="assets/css/table-responsive.css" rel="stylesheet">
    <!-- Javascripts -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
              <div class="content-panel">
                <?php
                  if ($reporte == 1) {
                    $fecha = $_GET["fecha"];
                    _r_atenciones_por_dia($conexion, $fecha);
                  }elseif ($reporte == 2) {
                    $fecha = $_GET["fecha"];
                    _r_atenciones_especialidad_dia($conexion, $fecha);
                  }elseif ($reporte == 3) {
                    $fecha_inicio = $_GET["fechaini"];
                    $fecha_fin = $_GET["fechafin"];
                    _r_atenciones_especialidad_periodo($conexion, $fecha_inicio, $fecha_fin);
                  }elseif ($reporte == 4) {
                    $mes = $_GET["mes"];
                    _r_atenciones_especialidad_mes($conexion, $mes);
                  }elseif ($reporte == 5) {
                    $fecha_inicio = $_GET["fechaini"];
                    $fecha_fin = $_GET["fechafin"];
                    _r_ultimas_atenciones($conexion, $fecha_inicio, $fecha_fin);
                  }elseif ($reporte == 6) {
                    _r_atenciones_mensuales($conexion);
                  }elseif ($reporte == 7) {
                    $fecha_inicio = $_GET["fechaini"];
                    $fecha_fin = $_GET["fechafin"];
                    _r_filiaciones_periodo($conexion, $fecha_inicio, $fecha_fin);
                  }elseif ($reporte == 8) {
                    $fecha_inicio = $_GET["fechaini"];
                    $fecha_fin = $_GET["fechafin"];
                    _r_estadistico_pacientes($conexion, $fecha_inicio, $fecha_fin);
                  }
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
        $("#a_administrador").addClass("active");
        $("#tabla-reporte").dataTable({ "bSort" : false });
        $("#tabla-lista-servicios").dataTable();
        $("#toggleServicios").click(function () {
          $("#no-more-tables").slideToggle();
        });
      });

      function seleccionar ( idservicio ) {
        var fecha_inicio = $("#fechaInicio").val();
        var fecha_fin = $("#fechaFin").val();
        $.ajax({
          method: "GET",
          url: "reporte3contenido.php",
          data: {
            servicio : idservicio,
            inicio : fecha_inicio,
            fin : fecha_fin
          }
        }).done(function (data) {
          $("#no-more-tables").slideToggle();
          $("#reporte3contenido").html (data);
        });
      }
    </script>
  </body>
</html>
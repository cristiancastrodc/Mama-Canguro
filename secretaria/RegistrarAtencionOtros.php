<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "menu.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
?>
<!DOCTYPE HTML>
<html>
  <head>
    <!-- General -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Atención | Mama Canguro</title>
    <link rel="icon" type="image/png" href="../assets/img/icon.ico">
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/style-menu-secre.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/layout.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
  </head>
  <body>
    <section id="container" >
      <div class="bg bg-min-height">
        <!-- Menú -->
        <div class="container">
          <div class="top-banner-grids">
            <?php
              _print_menu();
            ?>
          </div>
        </div>
        <!-- Fin del menú -->
        <!-- Realización del proceso -->
        <!-- Contenido principal -->
        <div class="container">
          <div class="row-mt">
            <div class="col-lg-12">
              <div class="form-panel">
                <h3><i class="fa fa-angle-double-right"></i> REGISTRAR ATENCION</h3>
                <form class="form-horizontal style-form" method="post" action="guardar-atencion.php">
                  <div class="form-group">
                    <label class="col-md-2 control-label">DNI del paciente</label>
                    <div class="col-md-4">
                      <input type='text' class='form-control round-form' id='txtdni' name='txtdni' placeholder='DNI' maxlength="8" required>
                    </div>
                  </div>
                  <!-- Dentro de este div se carga el contenido generado por AJAX -->
                  <div id="paciente"></div>
                  <div id="contenido">
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Servicio:</label>
                      <div class='col-lg-4'>
                        <input type="text" class="form-control round-form" id="txtServicio" name="txtServicio" placeholder="Servicio" required>
                      </div>
                      <label class="checkbox-inline col-lg-1 control-label">
                        <input type="checkbox" id="cbExamenes" value="Examen">Exámenes
                      </label>
                      <label class="checkbox-inline col-lg-1 control-label">
                        <input type="checkbox" id="cbConsultas" value="Consulta">Consultas
                      </label>
                      <label class="checkbox-inline col-lg-2 control-label">
                        <input type="checkbox" id="cbProcedimientos" value="Procedimiento">Procedimientos
                      </label>
                    </div>
                    <div id="tabla_servicios"></div>
                  </div>
                </form>
              </div>
            </div><!-- Fin de col-lg-12 -->
          </div><!-- Fin de row-mt -->
        </div>
      </div>
    </section>
    <?php
      _print_footer();
    ?>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/secretaria.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script>
      $(document).ready(function () {
        $("#contenido").css("display", "none");
      });
    </script>
  </body>
</html>
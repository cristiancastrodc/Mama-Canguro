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
    <title>Administrar filiación | Mama Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico">
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/style-menu-secre.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/layout.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/table-responsive.css" rel="stylesheet">
  </head>
  <body>
    <section id="container">
      <div class="bg bg-min-height">
        <div class="container">
          <div class="top-banner-grids">
            <?php
              _print_menu();
            ?>
          </div>
        </div> <!-- end header -->
        <div class="container">
          <div class="row mt">
            <div class="col-lg-12">
              <div class="form-panel">
                <h3><i class="fa fa-angle-double-right"></i> ADMINISTRAR FILIACION</h3>
                <h4 class="mb"><i class="fa fa-angle-right"></i> DATOS DEL PACIENTE</h4>
                <form class="form-horizontal style-form" method="post" action="actualizar-datos-paciente.php">
                  <div class="form-group" id="dnisearch">
                    <label class="col-lg-3 control-label">Ingrese DNI para buscar:</label>
                    <div class="col-lg-3">
                      <input type='text' class='form-control round-form' id='txtdni' name='txtdni' placeholder='DNI' maxlength="8">
                    </div>
                  </div>
                  <div class="form-group" id="namesearch">
                    <label class="col-lg-3 control-label">Ingrese Nombre para buscar:</label>
                    <div class="col-lg-3">
                      <input type='text' class='form-control round-form' id='txtnombres' name='txtnombres' placeholder='Nombres' onkeyup="mostrarPacienteNombres()">
                    </div>
                    <div class="col-lg-3">
                      <input type='text' class='form-control round-form' id='txtapellidos' name='txtapellidos' placeholder='Apellidos' onkeyup="mostrarPacienteNombres()">
                    </div>
                  </div>
                  <!-- AQUÍ VA EL CONTENIDO GENERADO POR AJAX -->
                  <!-- MUY IMPORTANTE, no remover -->
                  <div id="contenido"></div>
                  <!-- FIN DEL CONTENIDO GENERADO POR AJAX -->
                </form>
              </div><!-- end form panel -->
            </div><!-- col-lg-12-->
          </div><!-- /row -->
        </div>
      </div>
      <?php
        _print_footer();
      ?>

    </section>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script src="assets/js/filiacion.js"></script>
  </body>
</html>
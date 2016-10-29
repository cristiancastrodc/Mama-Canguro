<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "menu.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
?>
<!DOCTYPE html>
<html>
	<head>
    <!-- General -->
    <meta charset="UTF-8">
    <title>Ver Servicios | Mama Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico">
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/style-menu-secre.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/layout.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/table-responsive.css" rel="stylesheet">
    <!-- Javascripts -->
	</head>
	<body>
    <section id="container" >
      <div class="bg bg-min-height">
        <div class="container">
          <form >
          <?php
            _print_menu();
          ?>
          </form>
        </div>
        <div class="container">
          <div class="row mt">
            <div class="col-lg-12">
              <div class="form-panel">
		            <h3><i class="fa fa-angle-double-right ml"></i> SERVICIOS</h3>
                <form class="form-horizontal style-form" method="">
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Ingrese Servicio:</label>
                    <div class="col-lg-4">
                      <input type='text' class='form-control round-form' id='txtservicio' name='txtservicio' placeholder='Servicio'>
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
    </section> <!-- container -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script>
      $(document).ready(function () {
        $("#txtservicio").keyup(function () {
          var servicio_texto = $("#txtservicio").val();
          if (servicio_texto.length > 0) {
            $.ajax({
              method: "GET",
              url: "lista-de-servicios.php",
              data: {
                servicio : servicio_texto
              }
            }).done(function ( data ) {
              $("#contenido").html(data);
            });
          } else {
            $("#contenido").html("");
          }
        });
      });
    </script>
	</body>
</html>
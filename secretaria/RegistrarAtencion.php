<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "menu.php";
  // Inicializar la sesion
  session_start();
  // Si el usuario no es de tipo secretaría, o no está logueado, redireccionar
  _redireccionar('secretaria');
  // Recuperamos el servicio, el cual se envío por url
  $idservicio = $_GET['idservicio'];
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
                  <!-- ocultamos el idservicio, para utilizarlo en el envío del formulario -->
                  <input type="hidden" id="txtservicio" name="txtservicio" value="<?=$idservicio?>">
                  <div class="form-group">
                    <label class="col-lg-2 control-label">DNI del paciente</label>
                    <div class="col-lg-4">
                      <input type='text' class='form-control round-form' id='txtdni' name='txtdni' placeholder='DNI' maxlength="8" required>
                    </div>
                  </div>
                  <!-- Dentro de este div se carga el contenido generado por AJAX -->
                  <div id="contenido"></div>
                </form>
              </div>
            </div><!-- Fin de col-lg-12 -->
          </div><!-- Fin de row-mt -->
        </div>
      </div>
      <?php
        _print_footer();
      ?>

    </section> <!-- Fin del proceso -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script>
      $(document).ready(function () {
        $("#txtdni").keyup(function () {
          var dni_paciente = $("#txtdni").val();
          if (dni_paciente.length == 8) {
            var servicio_texto = $("#txtservicio").val();
            $.ajax({
              method: "GET",
              url: "recuperar-paciente-atencion.php",
              data: {
                dni : dni_paciente,
                servicio : servicio_texto
              }
            })
            .done(function ( data ) {
              $("#contenido").html(data);
              $("#contenido").css("display", "block");
              $("#txtdescuento").keyup(function () {
                var precio = $("#txtprecio").val();
                precio = Number(precio.substring(3));
                var descuento = $("#txtdescuento").val();
                descuento = Number(descuento);
                if (descuento <= precio) {
                  var total = precio - descuento;
                  total = "S/. " + total;
                  $("#txtpago").val(total);
                }
                else{
                  $("#txtpago").val(precio);
                }
              });
            });
          } else {
            $("#contenido").css("display", "none");
            $("#contenido").html("");
          }
        });
      });
    </script>
  </body>
</html>
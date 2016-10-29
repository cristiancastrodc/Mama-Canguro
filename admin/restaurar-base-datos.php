<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }
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
    <title>Restaurar Base de Datos | Clínica Mamá Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/layout.css" rel="stylesheet">
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
          <div class="row mt">
            <div class="col-lg-12">
              <div class="form-panel">
                <h3><i class="fa fa-angle-double-right"></i> Restaurar Estado Anterior de la Base de Datos</h3>
                <form class="form-horizontal style-form" method="POST" action="restaurar-bd-procesar.php" enctype="multipart/form-data">
                  <div class="form-group">
                    <div class="col-lg-12">
                      <div class="alert alert-danger">
                        <p class="center-align">Restaurar un estado anterior de la Base de Datos puede conllevar a <b>pérdida de información e inestabilidad</b>.
                           Use esta función con precaución y solo en los casos mencionados en el <b>Manual de Usuario y/o contacte al proveedor</b>.
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 col-sm-4 control-label">Seleccione el archivo de Copia de Seguridad:</label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control" accept=".sql" required name="archivoSubida" id="archivoSubida">
                    </div>
                  </div>
                  <a href="#myModal" role="button" class="btn btn-danger btn-lg btn-block" data-toggle="modal"><i class="fa fa-warning"></i> Realizar restauración de la base de datos</a>
                  <div class="form-group">
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Confirmar usuario y contraseña</h4>
                          </div>
                          <div class="modal-body">
                            <div class="alert alert-danger">
                              AVISO: Restaurar el estado de la Base de Datos puede causar pérdida de información y errores.
                              Confirme sus datos para realizar la restauración.
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="col-lg-6">
                                  <input type="text" class="form-control" id="txtuser" name="txtuser" placeholder="Usuario">
                                </div>
                                <div class="col-lg-6">
                                  <input type="password" class="form-control" id="txtpass" name="txtpass" placeholder="Contraseña">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-warning"></i> Confirmar restauración</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div><!-- end form panel -->
            </div><!-- col-lg-12-->
          </div><!-- /row -->
        </section><!-- /wrapper -->
      </section><!-- /MAIN CONTENT -->
      <?php
        _print_footer();
      ?>
    </section> <!-- Fin del cuerpo de la página -->
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script>
      $(document).ready(function(){
        $("#a_administrador").addClass("active");
      });
    </script>
  </body>
</html>

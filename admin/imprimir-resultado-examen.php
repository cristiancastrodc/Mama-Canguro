<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once 'components.php';
  //inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('admin');
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $nro_atencion =$_GET['nroatencion'];
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <title>Ver Resultado de Examen | Administrador </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
    <link href="../assets/css/style-login.css" rel="stylesheet">
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style-menu-admin.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="../assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../assets/plugins/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css" />
    <link rel="stylesheet" href="../assets/css/Markdown.Editor.hack.css" />
    <link rel="stylesheet" href="../assets/plugins/CLEditor1_4_3/jquery.cleditor.css" />
    <link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-wysihtml5-hack.css" />
    <link rel="stylesheet" href="assets/css/layout.css">
  </head>
  <body>
    <section id="container">
      <?php
        // Mostrar el header
        _print_header();
        // Mostrar el menú
        _print_menu($conexion);
      ?>
      <section id="main-content">
        <section class="wrapper">
          <div class="row mt">
            <div class="col-lg-12 main-chart">
              <div class="box">
                <header>
                  <div class="icons"><i class="icon-th-large"></i></div>
                  <h5>Examen de Laboratorio</h5>
                  <ul class="nav pull-right">
                    <li>
                      <div class="btn-group">
                        <a class="accordion-toggle btn btn-xs minimize-box" data-toggle="collapse" href="#cleditorDiv">
                          <i class="icon-minus"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </header>
                <div id="cleditorDiv" class="body collapse in">
                  <form class="form-horizontal style-form">
                    <div class="cleditorMain">
                      <div id="muestra">
                        <?php
                          $sentencia = "CALL sp_taatencion_ver_resultado($nro_atencion);";
                          if (mysqli_multi_query($conexion, $sentencia)) {
                            if($resultado = mysqli_store_result($conexion)) {
                              if ($fila = mysqli_fetch_row($resultado)) {
                                $formato = $fila[0];
                                echo utf8_encode($formato);
                              }
                            }
                            mysqli_free_result($resultado);
                          }
                          mysqli_next_result($conexion);
                        ?>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </section>
      <?php
        _print_footer();
      ?>
    </section>
    <script src="../assets/plugins/jquery-2.0.3.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="../assets/plugins/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    <script src="../assets/plugins/bootstrap-wysihtml5-hack.js"></script>
    <script src="../assets/plugins/CLEditor1_4_3/jquery.cleditor.min.js"></script>
    <script src="../assets/plugins/pagedown/Markdown.Converter.js"></script>
    <script src="../assets/plugins/pagedown/Markdown.Sanitizer.js"></script>
    <script src="../assets/plugins/Markdown.Editor-hack.js"></script>
    <script src="../assets/js/editorInit.js"></script>
    <script type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script>
      $(document).ready(function(){
        $("#a_doctor").addClass("active");
      });
    </script>
  </body>
</html>

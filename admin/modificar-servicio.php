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
  // Recuperar los parámetros enviados por GET
  $id_servicio = $_GET["idservicio"];
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- General -->
    <meta charset="utf-8">
    <title>Administrar Servicios | Administrador </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
    <link href="../assets/css/style-login.css" rel="stylesheet">
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
            <div class="col-lg-12">
              <div class="form-panel">
                <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Modificar servicio</h3>
                <?php
                  // Recuperar el contenido del servicio
                  $sentencia = "CALL sp_taservicio_listar($id_servicio)";
                  if (mysqli_multi_query($conexion, $sentencia)) {
                    if ($resultado = mysqli_store_result($conexion)) {
                      if ($servicio = mysqli_fetch_row($resultado)) {
                        $denominacion = $servicio[0];
                        $denominacion = utf8_encode($denominacion);
                        $precio = $servicio[1];
                        $tipo = $servicio[2];
                        $descripcion = $servicio[3];
                        $descripcion = utf8_encode($descripcion);
                        $formato = $servicio[4];
                        $formato = utf8_encode($formato);
                        $consultorio = $servicio[5];
                      }
                    }
                  }
                ?>
                <form action="actualizar-datos-servicio.php" method="POST" class="form-horizontal style-form">
                  <input type="hidden" id="txtIdServicio" name="txtIdServicio" value="<?=$id_servicio?>">
                  <div class="form-group">
                    <label class="control-label col-sm-2">Denominación</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="txtDenominacion" id="txtDenominacion" required autofocus value="<?=$denominacion?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2">Descripción</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="txtDescripcion" id="txtDescripcion" value="<?=$descripcion?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2">Precio</label>
                    <div class="col-sm-4">
                      <input type="number" min="0" class="form-control" name="txtPrecio" id="txtPrecio" required value="<?=$precio?>">
                    </div>
                    <label class="control-label col-sm-2">Tipo</label>
                    <div class="col-sm-4">
                      <input type="text" name="txtTipo" id="txtTipo" class="form-control" readonly value="<?=$tipo?>">
                    </div>
                  </div>
                  <div class="form-group" id="divConsultorio">
                    <label class="control-label col-sm-6">¿Qué especialidad atiende a este servicio?</label>
                    <div class="col-sm-6">
                      <select name="txtConsultorio" id="txtConsultorio" class="form-control" readonly>
                        <?php
                          if ($consultorio == 1) {
                            echo "<option value='1'>Medicina General</option>";
                          } elseif ($consultorio == 2) {
                            echo "<option value='2'>Ginecología</option>";
                          } elseif ($consultorio == 3) {
                            echo "<option value='3'>Pediatría</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="row" id="formatoServicio">
                    <div class="col-lg-12 main-chart">
                      <div class="alert alert-danger">Si está modificando una Consulta o Procedimiento, <b>NO MODIFIQUE</b> la sección de formato de resultado de laboratorio. Cualquier modificación no será almacenada.</div>
                      <div class="box">
                        <header>
                          <div class="icons"><i class="icon-th-large"></i></div>
                          <h5>Formato de Resultado de Laboratorio</h5>
                          <ul class="nav pull-right">
                            <li>
                              <div class="btn-group">
                                <a class="accordion-toggle btn btn-xs minimize-box" data-toggle="collapse" href="#cleditorDiv" id="toggleFormato">
                                  <i class="icon-minus"></i>
                                </a>
                              </div>
                            </li>
                          </ul>
                        </header>
                        <div id="cleditorDiv" class="body in">
                          <textarea name="cleditor" id="cleditor" class="form-control">
                            <?php
                              echo $formato;
                            ?>
                          </textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="container" class="hidden">
                    <div id="wmd-button-bar" class="btn-toolbar"></div>
                    <textarea class="form-control wmd-input" rows="10" name="description" id="wmd-input">**Demo Text**
                    </textarea>
                    <div class="form-actions no-margin-bottom" id="cleditorForm">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Guardar</button>
                </form>
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
    <script src="../assets/js/lock.js"></script>
    <script type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script>
      $(function () { formWysiwyg(); });
      $(document).ready(function(){
        $("#a_administrador").addClass("active");
        var tipo = $("#txtTipo").val();
        if (tipo != "Consulta") {
          $("#divConsultorio").css("display", "none");
        }
      });
    </script>
  </body>
</html>
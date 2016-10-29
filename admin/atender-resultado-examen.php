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
    <title>Llenar Resultado de Examen | Administrador </title>
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
            <div class="col-lg-12">
              <div class="form-panel">
                <h3 class="mb">&nbsp;<i class="fa fa-angle-double-right"></i> Datos del Paciente</h3>
                <form class="form-horizontal style-form">
                  <?php
                    $sentencia = "CALL sp_taatencion_LlenarResultado(".$nro_atencion.");";
                    if (mysqli_multi_query($conexion, $sentencia)) {
                      if($resultado = mysqli_store_result($conexion)) {
                        if ($fila = mysqli_fetch_row($resultado)) {
                          $nombres = $fila[0];
                          $apellidos = $fila[1];
                          $nombre = $nombres." ".$apellidos;
                          $hoy = date('Y');
                          $nacimiento = strtotime($fila[6]);
                          $nacimiento = date('Y', $nacimiento);
                          $edad = $hoy - $nacimiento;
                          $sexo = $fila[2];
                          $usuario = $fila[4] . " " . $fila[5];
                          $fecha_resultado = $fila[7];
                          if (is_null($fecha_resultado)) {
                            $fecha_resultado = date('d-m-Y');
                          }
                        }
                      }
                      mysqli_free_result($resultado);
                    }
                    mysqli_next_result($conexion);
                  ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Nombres</label>
                    <div class="col-sm-6">
                      <input readonly class="form-control" name="txtNombres" id="txtNombres" value="<?=utf8_encode($nombre)?>">
                    </div>
                    <label class="col-sm-2 control-label">Edad</label>
                    <div class="col-sm-2">
                      <input readonly class="form-control" name="txtEdad" id="txtEdad" value="<?=$edad?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Fecha y Hora RCP</label>
                    <div class="col-sm-6">
                      <input readonly class="form-control" name="txtFecha" id="txtFecha" value="<?=utf8_encode($fecha_resultado)?>">
                    </div>
                    <label class="col-sm-2 control-label">Sexo</label>
                    <div class="col-sm-2">
                      <?php
                        if ($sexo == "F") {
                          echo "<input readonly class='form-control' name='txtSexo' id='txtSexo' value='Femenino'>";
                        } else {
                          echo "<input readonly class='form-control' name='txtSexo' id='txtSexo' value='Masculino'>";
                        }
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Médico</label>
                    <div class="col-sm-6">
                      <input readonly class="form-control" name="txtMedico" id="txtMedico" value="<?=utf8_encode($usuario)?>">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
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
                  <form class="form-horizontal style-form" method="POST" action="guardar-resultado-examen.php">
                    <?php
                      $sentencia = "CALL sp_taservicio_formato(".$nro_atencion.");";
                      if (mysqli_multi_query($conexion, $sentencia)) {
                        if($resultado = mysqli_store_result($conexion)) {
                          if ($fila = mysqli_fetch_row($resultado)) {
                            $id_servicio = $fila[0];
                            $formato = utf8_encode($fila[1]);
                          }
                        }
                        mysqli_free_result($resultado);
                      }
                      mysqli_next_result($conexion);
                    ?>
                    <textarea id="cleditor" name="cleditor" class="form-control">
                      <?php echo $formato; ?>
                    </textarea>
                    <div class="form-actions no-margin-bottom" id="cleditorForm">
                        <input type="hidden" class="form-control" name="NroAtencion" id="NroAtencion" value="<?=$nro_atencion?>">
                        <button type="submit" class="btn btn-primary btn-block" name="Examen"><i class="fa fa-check"></i> Guardar Examen</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div id="container" class="hidden">
            <div id="wmd-button-bar" class="btn-toolbar"></div>
            <textarea class="form-control wmd-input" rows="10" name="description" id="wmd-input">**Demo Text**
            </textarea>
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
      $(function () { formWysiwyg(); });
      $(document).ready(function(){
        $("#a_biologo").addClass("active");
      });
    </script>
  </body>
</html>

<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  session_start();
  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('biologo');
  $User = $_SESSION["UsuarioLogueado"];
  $con = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
  $Atencion =$_GET['nro_atencion'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="BLENS101">
    <title>Clínica - Mamá Canguro</title>
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- CSS -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet">
    <link href="../assets/css/style-login.css" rel="stylesheet">
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style-menu-admin.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout.css">
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="../assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../assets/plugins/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css" />
    <link rel="stylesheet" href="../assets/css/Markdown.Editor.hack.css" />
    <link rel="stylesheet" href="../assets/plugins/CLEditor1_4_3/jquery.cleditor.css" />
    <link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-wysihtml5-hack.css" />
    <style>
      ul.wysihtml5-toolbar > li {
        position: relative;
      }
    </style>
  </head>
  <body>
    <section id="container">
      <!--menu start-->
      <div class="bg">
        <div class="container">
          <div class="top-banner-grids wow bounceInUp" data-wow-delay="0.4s">
            <a href="index.php">
              <div class="banner-grid text-center">
                <span class="top-icon1"> </span>
                <h3>Pagina Principal</h3>
              </div>
            </a>
            <a href="BuscarPaciente.php">
              <div class="banner-grid text-center banner-grid-active">
                <span class="top-icon2"> </span>
                <h3>Buscar Paciente</h3>
              </div>
            </a>
            <a href="Reportes.php">
              <div class="banner-grid text-center">
                <span class="top-icon3"> </span>
                <h3>Generar Reportes</h3>
              </div>
            </a>
            <a href="edit.php">
              <div class="banner-grid text-center">
                <span class="top-icon3"> </span>
                <h3>Actualizar mis Datos</h3>
              </div>
            </a>
            <a href="../logout.php">
              <div class="banner-grid text-center">
                <span class="top-icon5"> </span>
                <h3>Cerrar Sesión</h3>
              </div>
            </a>
            <div class="clearfix"> </div>
          </div>
        </div>
        <!--MENU end-->
        <!--main content start-->
        <section id="main-content">
          <section class="wrapper site-min-height ">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-panel">
                  <h3><i class="fa fa-angle-double-right"></i> Datos del Paciente</h3>
                  <form class="form-horizontal style-form">
                    <?php
                      $sql = "CALL sp_taatencion_LlenarResultado($Atencion);";
                      if (mysqli_multi_query($con,$sql)) {
                        if($result=mysqli_store_result($con)) {
                          $row=mysqli_fetch_row($result);
                          $Nombres = $row[0];
                          $AP = $row[1];
                          $hoy = date('Y');
                          $nacimiento = strtotime($row[6]);
                          $nacimiento = date('Y', $nacimiento);
                          $edad = $hoy - $nacimiento;
                          $Sexo = $row[2];
                          $Medico = $row[4] . " " . $row[5];
                          $Medico = utf8_encode($Medico);
                          $FechaResultado=$row[7];
                          $nombre_completo = utf8_encode($Nombres." ".$AP);
                          if(!$FechaResultado) {
                            $FechaResultado=date('Y-m-d');
                          }
                          mysqli_free_result($result);
                        }
                        mysqli_next_result($con);
                      }
                    ?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nombres</label>
                      <div class="col-sm-6">
                        <input readonly class="form-control" name="txtNombres" id="txtNombres" value="<?=$nombre_completo?>" required>
                      </div>
                      <label class="col-sm-2 control-label">Edad</label>
                      <div class="col-sm-2">
                        <input readonly class="form-control" name="txtEdad" id="txtEdad" value="<?=$edad?>" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Fecha y Hora RCP</label>
                      <div class="col-sm-6">
                        <input readonly class="form-control" name="txtFecha" id="txtFecha" value="<?=$FechaResultado?>" required>
                      </div>
                      <label class="col-sm-2 control-label">Sexo</label>
                      <div class="col-sm-2">
                        <?php
                          if ($Sexo == "F") {
                            echo "<input readonly class='form-control' name='txtSexo' id='txtSexo' value='Femenino' required>";
                          } else {
                            echo "<input readonly class='form-control' name='txtSexo' id='txtSexo' value='Masculino' required>";
                          }
                        ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Médico</label>
                      <div class="col-sm-6">
                        <input readonly class="form-control" name="txtMedico" id="txtMedico" value="<?=$Medico?>" required>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="row">
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
                    <form class="form-horizontal style-form" method="POST" action="">
                      <?php
                        $sql = "CALL sp_taservicio_formato($Atencion);";
                        if (mysqli_multi_query($con,$sql)) {
                          if($result=mysqli_store_result($con)) {
                            $row=mysqli_fetch_row($result);
                            $IdServicio = $row[0];
                            $Formato = utf8_encode($row[1]);
                            mysqli_free_result($result);
                          }
                          mysqli_next_result($con);
                        }
                      ?>
                      <textarea  id="cleditor" name="cleditor" class="form-control" >
                        <?php
                          echo $Formato;
                        ?>
                      </textarea>
                      <div class="form-actions no-margin-bottom" id="cleditorForm">
                        <input type="hidden" class="form-control" name="NroAtencion" id="NroAtencion" value="<?=$Atencion?>">
                        <a role="button" class="btn btn-primary btn-block" name="Examen" id="Examen"><i class="fa fa-check"></i> Guardar Examen</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div id="container" style="display:none;">
                <div id="wmd-button-bar" class="btn-toolbar"></div>
                <textarea class="form-control wmd-input" rows="10" name="description" id="wmd-input">**Demo Text**
                </textarea>
              </div>
            </div>
          </section>
        </section>
        <?php
          _print_footer();
        ?>
      </div>
    </section>
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="assets/js/jquery-v1.min.js"></script>
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
    <script>
      $(function () { formWysiwyg(); });
    </script>
    <script>
      $(document).ready(function () {
        $("#Examen").click(function () {
          var Atencion = $("#NroAtencion").val();
          var Examen = $("#cleditor").val();
          $.ajax({
            method: "GET",
            url: "guardar-examen.php",
            data: {
              nroatencion : Atencion,
              resultado : Examen
            }
          }).done(function (data) {
            alert(data);
            location.href = "BuscarPaciente.php";
          });
        });
      });
    </script>
  </body>
</html>
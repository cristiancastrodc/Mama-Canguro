<?php
  // Llamado a las variables globales
  require_once "../global.php";
  require_once "components.php";
  // Inicializar la sesion
  session_start();
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
                <h3>&nbsp;<i class="fa fa-angle-double-right"></i> Crear nuevo servicio</h3>
                <form action="actualizar-datos-servicio.php" method="POST" class="form-horizontal style-form">
                  <input type="hidden" id="txtIdServicio" name="txtIdServicio" value="nuevo">
                  <div class="form-group">
                    <label class="control-label col-sm-2">Denominación</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="txtDenominacion" id="txtDenominacion" required autofocus>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2">Descripción</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="txtDescripcion" id="txtDescripcion">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2">Precio</label>
                    <div class="col-sm-4">
                      <input type="number" min="0" class="form-control" name="txtPrecio" id="txtPrecio" required>
                    </div>
                    <label class="control-label col-sm-2">Tipo</label>
                    <div class="col-sm-4">
                      <select name="txtTipo" id="txtTipo" class="form-control" required>
                        <option></option>
                        <option>Consulta</option>
                        <option>Examen</option>
                        <option>Procedimiento</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group" id="divConsultorio">
                    <label class="control-label col-sm-6">¿Qué especialidad atiende a este servicio?</label>
                    <div class="col-sm-6">
                      <select name="txtConsultorio" id="txtConsultorio" class="form-control" required>
                        <option value="1">Medicina General</option>
                        <option value="2">Ginecología</option>
                        <option value="3">Pediatría</option>
                      </select>
                    </div>
                  </div>
                  <div class="row" id="formatoServicio">
                    <div class="col-lg-12 main-chart">
                      <div class="alert alert-danger">Si está creando una Consulta o Procedimiento, <b>NO MODIFIQUE</b> la sección de formato de resultado de laboratorio. Cualquier modificación no será almacenada.</div>
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
                              $formato = "<img src='../assets/img/cabecera.png' width='1050' height='180'><div><p class='MsoNormal' style='margin-top:12.0pt;text-align:center'><b><span style='font-size:12.0pt; line-height:115%;font-family: Arial, sans-serif'>LABORATORIO CLÍNICO<o:p></o:p></span></b></p><center><table class='MsoNormalTable' border='0' cellspacing='0' cellpadding='0' width='638' style='width:478.85pt;margin-left:2.75pt;border-collapse:collapse;mso-yfti-tbllook: 1184;mso-padding-alt:0cm 3.5pt 0cm 3.5pt'><tbody><tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.25pt'><td width='311' nowrap='' style='width:233.25pt;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.25pt'><p class='MsoNormal' style='margin-bottom: 0.0001pt;'><b><span style='font-size: 9pt; font-family: Arial, sans-serif;'>PACIENTE:&nbsp;</span></b></p></td><td width='327' nowrap='' style='width:245.6pt;border-top:solid windowtext 1.0pt;border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.25pt'><p class='MsoNormal' style='margin-bottom: 0.0001pt;'><b><span style='font-size: 9pt; font-family: Arial, sans-serif;'>FECHA RCP:&nbsp;</span></b></p></td></tr><tr style='mso-yfti-irow:1;height:15.25pt'><td width='311' nowrap='' style='width:233.25pt;border:none;border-left:solid windowtext 1.0pt;mso-border-left-alt:solid windowtext .5pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.25pt'><p class='MsoNormal' style='margin-bottom: 0.0001pt;'><b><span style='font-size: 9pt; font-family: Arial, sans-serif;'>SEXO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;</span></b></p></td><td width='327' nowrap='' style='width:245.6pt;border:none;border-right:solid windowtext 1.0pt;mso-border-right-alt:solid windowtext .5pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.25pt'><p class='MsoNormal' style='margin-bottom: 0.0001pt;'><b><span style='font-size: 9pt; font-family: Arial, sans-serif;'>MEDICO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :<o:p></o:p></span></b></p></td></tr><tr style='mso-yfti-irow:2;mso-yfti-lastrow:yes;height:15.25pt'><td width='311' nowrap='' style='width:233.25pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;mso-border-left-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.25pt'><p class='MsoNormal' style='margin-bottom: 0.0001pt;'><b><span style='font-size: 9pt; font-family: Arial, sans-serif;'>EDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;</span></b></p></td><td width='327' nowrap='' style='width:245.6pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;padding:0cm 3.5pt 0cm 3.5pt;height:15.25pt'><p class='MsoNormal' style='margin-bottom: 0.0001pt;'><b><span style='font-size: 9pt; font-family: Arial, sans-serif;'>EMPRESA&nbsp;&nbsp;&nbsp; : </span></b><span style='font-size: 9pt; font-family: Arial, sans-serif;'>CMyO MAMA CANGURO E.I.R.L.<b><o:p></o:p></b></span></p></td></tr></tbody></table></center><p>Contenido</p></div>";
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
        $("#divConsultorio").css("display", "none");
        $("#txtTipo").change(function () {
          var tipo = $("#txtTipo").val();
          if (tipo == "Consulta") {
            $("#divConsultorio").slideDown();
          } else {
            $("#divConsultorio").slideUp();
          }
        });
      });
    </script>
  </body>
</html>
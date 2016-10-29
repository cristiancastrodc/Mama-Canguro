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
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="../assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../assets/plugins/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css" />
    <link rel="stylesheet" href="../assets/css/Markdown.Editor.hack.css" />
    <link rel="stylesheet" href="../assets/plugins/CLEditor1_4_3/jquery.cleditor.css" />
    <link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-wysihtml5-hack.css" />
    <link rel="stylesheet" href="assets/css/layout.css">
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
            <div class="row" ><!-- inicio de row1-->
              <div class="col-lg-12 main-chart" style="margin-left: -10%;">
                <div class="box" style="background: aliceblue;" id="targetTextArea">
                  <header>
                    <div class="icons"><i class="icon-th-large"></i></div>
                    <h5>Examen de Laboratorio</h5>
                  </header>
                  <div id="cleditorDiv" class="body collapse in">
                    <form class="form-horizontal style-form" method="POST" action="">
                      <div class="cleditorMain" style="width: 100%; height: 100%;">
                        <?php
                          $sql = "CALL sp_taatencion_ver_resultado($Atencion);";
                          if (mysqli_multi_query($con,$sql)) {
                            if($result=mysqli_store_result($con)) {
                              $row=mysqli_fetch_row($result);
                              $Formato = utf8_encode($row[0]);
                              mysqli_free_result($result);
                            }
                            mysqli_next_result($con);
                          }
                        ?>
                        <div id="muestra">
                          <?php
                            echo $Formato;
                          ?>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <button class="btn btn-primary btn-block" name="Examen" onclick="javascript:imprSelec('muestra')">Imprimir Examen</button>
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
    <script type="text/javascript">
      function imprSelec(muestra) {
        var ficha=document.getElementById(muestra);
        var ventimp=window.open(' ','popimpr');
        ventimp.document.write(ficha.innerHTML);
        ventimp.document.close();
        ventimp.print();
        ventimp.close();
      }
    </script>
  </body>
</html>
<?php
  // Llamado a las variables globales
  require_once "../global.php";
  //inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('biologo');
  $User = $_SESSION["UsuarioLogueado"];
  $con = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="BLENS101">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <title>Laboratorio | Clínica Mamá Canguro</title>
    <!--links -->
    <!--externos-->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet">
    <link href="../assets/css/style-login.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
    <link rel="stylesheet" href="../assets/js/jquery-ui.css">
    <link href="assets/css/style-menu-admin.css" rel='stylesheet' type='text/css' />
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/layout.css">
  </head>
  <body >
    <section id="container" >
      <!--menu start-->
      <div class="bg">
        <div class="container">
          <div class="top-banner-grids wow bounceInUp" data-wow-delay="0.4s">
            <div class="banner-grid banner-grid-active text-center">
              <!--<a href="index.html">-->
              <span class="top-icon1"> </span>
              <h3>Pagina Principal</h3>
              <!-- </a>-->
            </div>
            <a href="BuscarPaciente.php">
              <div class="banner-grid text-center">
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
        <div class="container">
          <div class="row" id="principal"></div> <!-- final de row1 -->
        </div>
      </div>
      <!--main content end-->
      <?php
        _print_footer();
      ?>
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="../assets/js/jquery-v1.min.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery-ui.js"></script>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jjquery-1.8.3.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script type="text/javascript" src="assets/js/move-top.js"></script>
    <script type="text/javascript" src="assets/js/easing.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script>
     new WOW().init();
    </script>
     <!-- para el ajax -->
    <script language="JavaScript" type="text/javascript" src="ajax.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script type="text/javascript">
      function actualizaratenciones (NroAtencion) {
        var blnRespuesta=confirm('¿Desea Confirmar la entrega de Muestra?');
        if(blnRespuesta){
          if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
          } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("principal").innerHTML = xmlhttp.responseText;
            }
          }
          xmlhttp.open("GET","noAtendidos.php?Atencion="+NroAtencion,true);
          xmlhttp.send();
        }
      }
    </script>
    <script type="text/javascript">
      function VernoAtendidos () {
        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("principal").innerHTML = xmlhttp.responseText;
          }
        }
        xmlhttp.open("GET","noAtendidos.php",true);
        xmlhttp.send();
      }
      window.onload =VernoAtendidos();
    </script>
  </body>
</html>

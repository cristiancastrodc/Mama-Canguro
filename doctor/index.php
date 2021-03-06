<?php
  // Llamado a las variables globales
  require_once "../global.php";
  // Inicializar la sesion
  if(!isset($_SESSION)) {
    session_start();
  }  // Si el usuario no es de tipo administrador, o no está logueado, redireccionar
  _redireccionar('doctor');
  // Conexión a la base de datos
  $conexion = mysqli_connect($global_host, $global_user_db, $global_pass_db, $global_db);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <!-- General -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Menú Doctor | Mamá Canguro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../assets/img/icon.ico" />
    <!-- Estilos CSS -->
    <link href="assets/css/style-menu-doctor.css" rel='stylesheet' type='text/css' />
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/lineicons/style.css">
    <link rel="stylesheet" href="assets/css/layout.css">
  </head>
  <body>
    <div class="bg">
      <!-- start-header -->
      <div class="container">
        <header class="pg-header">CLINICA MAMÁ CANGURO</header>
        <div class="top-banner-grids wow bounceInUp" data-wow-delay="0.4s">
          <a value="Default Message" class="myButton" id="default" href="index.php">
            <div class="banner-grid banner-grid-active text-center">
              <span class="top-icon1"> </span>
              <h3>Página Principal</h3>
            </div>
          </a>
          <a value="Default Message" class="myButton" id="default" href="edit.php">
            <div class="banner-grid text-center">
              <span class="top-icon2"> </span>
              <h3>Actualizar mis datos</h3>
            </div>
          </a>
          <a value="Default Message" class="myButton" id="default" href="../logout.php">
            <div class="banner-grid text-center">
              <span class="top-icon3"> </span>
              <h3>Cerrar Sesión</h3>
            </div>
          </a>
          <section id="main-content">
            <section class="wrapper">
              <div class="row mt" id="Contenido"></div>
            </section>
          </section>
        </div>
      </div>
    </div>
    <?php
      _print_footer();
    ?>
    <!-- Javascripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="../assets/js/jquery-v1.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/lock.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script>
     new WOW().init();
    </script>
    <script type="text/javascript" src="assets/js/move-top.js"></script>
    <script type="text/javascript" src="assets/js/easing.js"></script>
    <script>
      var myVar = setInterval( function () { mostrar_paciente() }, 5000);
      function mostrar_paciente () {
        $.ajax({
          method: "GET",
          url: "mostrar-paciente-espera.php"
        }).done( function ( data ) {
          $("#Contenido").html ( data );
        });
      }
    </script>
  </body>
</html>